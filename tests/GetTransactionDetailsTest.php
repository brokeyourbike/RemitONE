<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\RemitOne\Models\TransactionDetailsResponse;
use BrokeYourBike\RemitOne\Models\Transaction;
use BrokeYourBike\RemitOne\Models\AddressParts;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Interfaces\TransactionInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class GetTransactionDetailsTest extends TestCase
{
    private readonly string $xml;

    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    private string $reference = '123445';

    protected function setUp(): void
    {
        parent::setUp();
        $this->xml = file_get_contents(dirname(__FILE__) . '/Data/transaction_details.xml');
    }

    /** @test */
    public function it_can_prepare_request(): void
    {
        $transaction = $this->getMockBuilder(TransactionInterface::class)->getMock();
        $transaction->method('getReference')->willReturn($this->reference);

        /** @var TransactionInterface $transaction */
        $this->assertInstanceOf(TransactionInterface::class, $transaction);

        $mockedUser = $this->getMockBuilder(UserInterface::class)->getMock();
        $mockedUser->method('getUrl')->willReturn('https://api.example/');
        $mockedUser->method('getType')->willReturn(UserTypeEnum::BANK);
        $mockedUser->method('getUsername')->willReturn($this->username);
        $mockedUser->method('getPassword')->willReturn($this->password);
        $mockedUser->method('getPin')->willReturn($this->pin);

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')->willReturn($this->xml);

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/getPayoutTransactionDetails',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'trans_ref' => $this->reference,
                    'username' => $this->username,
                    'password' => $this->password,
                    'pin' => $this->pin,
                ],
            ],
        ])->once()->andReturn($mockedResponse);

        /**
         * @var UserInterface $mockedUser
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedUser, $mockedClient);

        $response = $api->getTransactionDetails($transaction);
        $this->assertInstanceOf(TransactionDetailsResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());

        $transactionDecoded = $response->getResult()->getTransaction();
        $this->assertInstanceOf(Transaction::class, $transactionDecoded);
        $this->assertSame('LOL13241234', $transactionDecoded->getReference());
        $this->assertSame('Account', $transactionDecoded->getType());
        $this->assertSame('SENT_FOR_PAY', $transactionDecoded->getStatus());
        $this->assertSame('GB', $transactionDecoded->getSendCountryIso());
        $this->assertSame('GBP', $transactionDecoded->getSendCurrency());
        $this->assertSame('36.50', $transactionDecoded->getSendAmount());
        $this->assertSame('NG', $transactionDecoded->getReceiveCountryIso());
        $this->assertSame('USD', $transactionDecoded->getReceiveCurrency());
        $this->assertSame('50.00', $transactionDecoded->getReceiveAmount());
        $this->assertSame('49.00', $transactionDecoded->getReceiveAmountAfterBankCharges());

        $this->assertSame('18270', $transactionDecoded->getRemitterId());
        $this->assertSame('Male', $transactionDecoded->getRemitterGender());
        $this->assertSame('JANE', $transactionDecoded->getRemitterFirstName());
        $this->assertSame('BAROSSA', $transactionDecoded->getRemitterMiddleName());
        $this->assertSame('DOE', $transactionDecoded->getRemitterLastName());
        $this->assertSame('NG', $transactionDecoded->getRemitterNationality());
        $this->assertSame('1999-12-15', $transactionDecoded->getRemitterDateOfBirth());
        $this->assertSame('+441234123412', $transactionDecoded->getRemitterMobileNumber());
        $this->assertSame('Driving_License', $transactionDecoded->getRemitterIdentificationType());
        $this->assertSame('DRV12341234', $transactionDecoded->getRemitterIdentificationDetails());
        $this->assertSame('2026-11-29', $transactionDecoded->getRemitterIdentificationExpiry());

        $this->assertInstanceOf(AddressParts::class, $transactionDecoded->getRemitterAddressParts());
        $this->assertSame('building 123', $transactionDecoded->getRemitterAddressParts()->getBuildingNumber());
        $this->assertSame('ra1 ra2', $transactionDecoded->getRemitterAddressParts()->getAddress());
        $this->assertSame('MANCHESTER', $transactionDecoded->getRemitterAddressParts()->getCity());
        $this->assertSame('N/A', $transactionDecoded->getRemitterAddressParts()->getState());
        $this->assertSame('123 POST', $transactionDecoded->getRemitterAddressParts()->getPostcode());
        $this->assertSame('GB', $transactionDecoded->getRemitterAddressParts()->getCountry());

        $this->assertSame('44911', $transactionDecoded->getBeneficiaryId());
        $this->assertSame('JOHN', $transactionDecoded->getBeneficiaryFirstName());
        $this->assertSame('DOE', $transactionDecoded->getBeneficiaryLastName());
        $this->assertSame('WAROSSA', $transactionDecoded->getBeneficiaryMiddleName());
        $this->assertSame('NONE', $transactionDecoded->getBeneficiaryIdType());
        $this->assertSame('NO1245', $transactionDecoded->getBeneficiaryIdDetails());
        $this->assertSame('BEN 445', $transactionDecoded->getBeneficiaryPostcode());
        $this->assertSame('+12341234', $transactionDecoded->getBeneficiaryMobileTransferNumber());
        $this->assertSame('nortstar', $transactionDecoded->getBeneficiaryMobileTransferNetwork());
        $this->assertSame('a1 a2 a3', $transactionDecoded->getBeneficiaryAddress());
        $this->assertSame('LAGOS', $transactionDecoded->getBeneficiaryCity());
        $this->assertSame('+32323232', $transactionDecoded->getBeneficiaryMobileNumber());
        $this->assertSame('benef@example.com', $transactionDecoded->getBeneficiaryEmail());
        $this->assertSame('UA', $transactionDecoded->getBeneficiaryNationality());
        $this->assertSame('UNITED BANK FOR AFRICA', $transactionDecoded->getBeneficiaryBranch());
        $this->assertSame('033', $transactionDecoded->getBeneficiaryBranchCode());
        $this->assertSame('123412341234', $transactionDecoded->getBeneficiaryBankAccountNumber());
        $this->assertSame('actype', $transactionDecoded->getBeneficiaryBankAccountType());
        $this->assertSame('SWIFT556', $transactionDecoded->getBeneficiaryBankSwiftCode());
        $this->assertSame('IBAN887', $transactionDecoded->getBeneficiaryBankIban());
    }
}
