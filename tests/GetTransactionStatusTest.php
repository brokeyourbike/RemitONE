<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\RemitOne\Models\TransactionStatusResponse;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Interfaces\TransactionInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\TransactionStatusEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class GetTransactionStatusTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    private string $reference = '123445';

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
                    <agent_trans_ref>ABC12345678</agent_trans_ref>
                    <benef_trans_ref>ABC12345678</benef_trans_ref>
                    <status>'. TransactionStatusEnum::SENT_FOR_PAY->value .'</status>
                    <compliance_check_required>f</compliance_check_required>
                    <compliance_checked>f</compliance_checked>
                </result>
            </response>');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/getTransactionStatus',
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

        $response = $api->getTransactionStatus($transaction);

        $this->assertInstanceOf(TransactionStatusResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
    }
}
