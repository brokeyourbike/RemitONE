<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\RemitOne\Models\TransactionStatusResponse;
use BrokeYourBike\RemitOne\Models\ProcessTransactionResponse;
use BrokeYourBike\RemitOne\Models\AcceptTransactionResponse;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Interfaces\TransactionInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\HttpEnums\HttpMethodEnum;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;
use BrokeYourBike\HasSourceModel\SourceModelInterface;
use BrokeYourBike\HasSourceModel\HasSourceModelTrait;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Client implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;
    use HasSourceModelTrait;

    private UserInterface $user;
    private SerializerInterface $serializer;

    public function __construct(UserInterface $user, ClientInterface $httpClient)
    {
        $this->user = $user;
        $this->httpClient = $httpClient;

        if ($user instanceof SourceModelInterface) {
            $this->setSourceModel($user);
        }

        $this->serializer = $this->makeSerializer();
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getPayoutTransactions(): ResponseInterface
    {
        return $this->performRequest(HttpMethodEnum::POST, 'transaction/getPayoutTransactions', []);
    }

    public function getPendingPayoutTransactions(): ResponseInterface
    {
        return $this->performRequest(HttpMethodEnum::POST, 'transaction/getPendingPayoutTransactions', []);
    }

    public function getErrorTransactions(\DateTime $start, \DateTime $end): ResponseInterface
    {
        return $this->performRequest(HttpMethodEnum::POST, 'transaction/getErrorTransactions', [
            'from_date' => $start->format('Y-m-d'),
            'to_date' => $end->format('Y-m-d'),
        ]);
    }

    public function getPayoutTransactionDetails(TransactionInterface $transaction): ResponseInterface
    {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        return $this->performRequest(HttpMethodEnum::POST, 'transaction/getPayoutTransactionDetails', [
            'trans_ref' => $transaction->getReference(),
        ]);
    }

    public function getTransactionStatus(TransactionInterface $transaction): TransactionStatusResponse
    {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        $response = $this->performRequest(HttpMethodEnum::POST, 'transaction/getTransactionStatus', [
            'trans_ref' => $transaction->getReference(),
        ]);
        return $this->serializer->deserialize($response->getBody(), TransactionStatusResponse::class, 'xml');
    }

    public function acceptPayoutTransaction(TransactionInterface $transaction): AcceptTransactionResponse
    {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        if ($this->user->getType() === UserTypeEnum::BANK_SUPER && !$transaction->getBankName()) {
            // throw
        }

        $data = [
            'trans_ref' => $transaction->getReference(),
        ];

        if ($transaction->getBankName()) {
            $data['bank_name'] = $transaction->getBankName();
        }

        $response = $this->performRequest(HttpMethodEnum::POST, 'transaction/acceptPayoutTransactions', $data);
        return $this->serializer->deserialize($response->getBody(), AcceptTransactionResponse::class, 'xml');
    }

    public function processPayoutTransaction(TransactionInterface $transaction, string $payMethod): ProcessTransactionResponse
    {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        if ($this->user->getType() === UserTypeEnum::BANK_SUPER && !$transaction->getBankName()) {
            // throw
        }

        $data = [
            'trans_ref' => $transaction->getReference(),
            'pay_method' => $payMethod,
        ];

        if ($transaction->getBankName()) {
            $data['bank_name'] = $transaction->getBankName();
        }

        $response = $this->performRequest(HttpMethodEnum::POST, 'transaction/processPayoutTransaction', $data);
        return $this->serializer->deserialize($response->getBody(), ProcessTransactionResponse::class, 'xml');
    }

    public function errorPayoutTransaction(
        TransactionInterface $transaction,
        string $errorReason,
        string $errorDetails = null
    ): ResponseInterface {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        if ($this->user->getType() === UserTypeEnum::BANK_SUPER && !$transaction->getBankName()) {
            // throw
        }

        $data = [
            'trans_ref' => $transaction->reference,
            'error_reason' => $errorReason,
        ];

        if ($errorDetails !== null) {
            $data['error_details'] = $errorDetails;
        }

        if ($transaction->getBankName()) {
            $data['bank_name'] = $transaction->getBankName();
        }

        return $this->performRequest(HttpMethodEnum::POST, 'transaction/errorPayoutTransaction', $data);
    }

    public function updateTransactionCollectionPin(TransactionInterface $transaction, string $collectionPin): ResponseInterface
    {
        if ($transaction instanceof SourceModelInterface) {
            $this->setSourceModel($transaction);
        }

        return $this->performRequest(HttpMethodEnum::POST, 'transaction/updatePayoutTransDetails', [
            'trans_ref' => $transaction->getReference(),
            'benef_trans_ref' => $transaction->getReference(),
            'collection_pin' => $collectionPin,
        ]);
    }

    /**
     * @param HttpMethodEnum $method
     * @param string $uri
     * @param array<mixed> $data
     * @return ResponseInterface
     */
    private function performRequest(HttpMethodEnum $method, string $uri, array $data): ResponseInterface
    {
        $data['username'] = $this->user->getUsername();
        $data['password'] = $this->user->getPassword();
        $data['pin'] = $this->user->getPin();

        $option = match($method) {
            HttpMethodEnum::GET => \GuzzleHttp\RequestOptions::QUERY,
            default => \GuzzleHttp\RequestOptions::FORM_PARAMS,
        };

        $options = [];
        $options[$option] = $data;

        if ($this->getSourceModel()) {
            $options[\BrokeYourBike\HasSourceModel\Enums\RequestOptions::SOURCE_MODEL] = $this->getSourceModel();
        }

        $uri = (string) $this->resolveUriFor($this->user->getUrl(), $uri);
        return $this->httpClient->request($method->value, $uri, $options);
    }

    private function makeSerializer(): SerializerInterface
    {
        $loader = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);

        return new Serializer([
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer(
                classMetadataFactory: $loader,
                propertyTypeExtractor: $extractor,
            ),
        ], [new XmlEncoder()]);
    }
}
