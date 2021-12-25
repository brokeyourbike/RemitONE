<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\RemitOne\Models\UpdateTransactionResponse;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Interfaces\TransactionInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Enums\OperationResultStatusEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class UpdateTransactionCollectionPinTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    private string $reference = 'RC000224000100';
    private string $collectionPin = '123456789';

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
        $mockedResponse->method('getBody')
            ->willReturn('<?xml version="1.0" encoding="utf-8"?>
            <response>
                <status>'. StatusCodeEnum::SUCCESS->value  .'</status>
                <result>
                    <trans_id>1</trans_id>
                    <trans_ref>'. $this->reference .'</trans_ref>
                    <benef_trans_ref>'. $this->reference .'</benef_trans_ref>
                    <bank_comments>Some bank comments</bank_comments>
                    <payout_comments>Some payout comments</payout_comments>
                    <collection_pin>'. $this->collectionPin .'</collection_pin>
                </result>
            </response>');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/updatePayoutTransDetails',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'trans_ref' => $this->reference,
                    'benef_trans_ref' => $this->reference,
                    'collection_pin' => $this->collectionPin,
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

        $response = $api->updateTransactionCollectionPin($transaction, $this->collectionPin);

        $this->assertInstanceOf(UpdateTransactionResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertSame($this->reference, $response->getResult()->getReference());
        $this->assertSame($this->reference, $response->getResult()->getBeneficiaryReference());
        $this->assertSame('Some bank comments', $response->getResult()->getBankComments());
        $this->assertSame('Some payout comments', $response->getResult()->getPayoutComments());
        $this->assertSame($this->collectionPin, $response->getResult()->getCollectionPin());
    }
}
