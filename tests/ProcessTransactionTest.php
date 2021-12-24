<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\RemitOne\Models\ProcessTransactionResult;
use BrokeYourBike\RemitOne\Models\ProcessTransactionResponse;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Interfaces\TransactionInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Enums\OperationResultStatusEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class ProcessTransactionTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    private string $reference = '123445';
    private string $payMethod = 'KEK';

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
                    <trans_ref>'. $this->reference .'</trans_ref>
                    <sms_benef_payout>True</sms_benef_payout>
                    <sms_benef_payout_mobile>+447767123456</sms_benef_payout_mobile>
                    <process_result>'. OperationResultStatusEnum::SUCCESS->value  .'</process_result>
                    <message>hello!</message>
                </result>
            </response>');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/processPayoutTransaction',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'trans_ref' => $this->reference,
                    'pay_method' => $this->payMethod,
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

        $response = $api->processTransaction($transaction, $this->payMethod);

        $this->assertInstanceOf(ProcessTransactionResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertInstanceOf(ProcessTransactionResult::class, $response->getResult());
        $this->assertSame($this->reference, $response->getResult()->getReference());
        $this->assertSame(OperationResultStatusEnum::SUCCESS->value, $response->getResult()->getProcessResult());
        $this->assertSame('hello!', $response->getResult()->getMessage());
    }
}
