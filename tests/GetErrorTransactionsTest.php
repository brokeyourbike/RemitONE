<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use BrokeYourBike\RemitOne\Models\ErrorTransactionsResponse;
use BrokeYourBike\RemitOne\Models\ErrorTransaction;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class GetErrorTransactionsTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    /** @test */
    public function it_can_prepare_request(): void
    {
        $xml = file_get_contents(dirname(__FILE__) . '/Data/error_transactions.xml');

        $mockedUser = $this->getMockBuilder(UserInterface::class)->getMock();
        $mockedUser->method('getUrl')->willReturn('https://api.example/');
        $mockedUser->method('getType')->willReturn(UserTypeEnum::BANK);
        $mockedUser->method('getUsername')->willReturn($this->username);
        $mockedUser->method('getPassword')->willReturn($this->password);
        $mockedUser->method('getPin')->willReturn($this->pin);

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')->willReturn($xml);

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/getErrorTransactions',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'from_date' => '2021-01-05',
                    'to_date' => '2025-02-15',
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

        $response = $api->getErrorTransactions(Carbon::create(2021, 1, 5), Carbon::create(2025, 2, 15));

        $this->assertInstanceOf(ErrorTransactionsResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertSame(1, $response->getResult()->getCount());
        $this->assertCount(1, $response->getResult()->getTransactionsList());

        [$transactionDecoded] = $response->getResult()->getTransactionsList();
        $this->assertInstanceOf(ErrorTransaction::class, $transactionDecoded);
    }

    /** @test */
    public function it_can_decode_empty_transactions()
    {
        $xml = file_get_contents(dirname(__FILE__) . '/Data/empty_error_transactions.xml');

        $mockedUser = $this->getMockBuilder(UserInterface::class)->getMock();
        $mockedUser->method('getUrl')->willReturn('https://api.example/');
        $mockedUser->method('getType')->willReturn(UserTypeEnum::BANK);
        $mockedUser->method('getUsername')->willReturn($this->username);
        $mockedUser->method('getPassword')->willReturn($this->password);
        $mockedUser->method('getPin')->willReturn($this->pin);

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')->willReturn($xml);

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/transaction/getErrorTransactions',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
                    'from_date' => '2021-01-05',
                    'to_date' => '2025-02-15',
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

        $response = $api->getErrorTransactions(Carbon::create(2021, 1, 5), Carbon::create(2025, 2, 15));

        $this->assertInstanceOf(ErrorTransactionsResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertSame(0, $response->getResult()->getCount());
        $this->assertCount(0, $response->getResult()->getTransactionsList());
    }
}
