<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use Psr\Http\Message\ResponseInterface;
use BrokeYourBike\RemitOne\Models\TransactionsResponse;
use BrokeYourBike\RemitOne\Models\Transaction;
use BrokeYourBike\RemitOne\Models\AddressParts;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Enums\UserTypeEnum;
use BrokeYourBike\RemitOne\Enums\StatusCodeEnum;
use BrokeYourBike\RemitOne\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class GetPendingTransactionsTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'john1234';
    private string $pin = '456';

    /** @test */
    public function it_can_prepare_request(): void
    {
        $xml = file_get_contents(dirname(__FILE__) . '/Data/transactions.xml');

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
            'https://api.example/transaction/getPendingPayoutTransactions',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
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

        $response = $api->getPendingTransactions();

        $this->assertInstanceOf(TransactionsResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertSame(1, $response->getResult()->getCount());
        $this->assertCount(1, $response->getResult()->getTransactionsList());

        $transactionDecoded = $response->getResult()->getTransactionsList()[0];
        $this->assertInstanceOf(Transaction::class, $transactionDecoded);
        $this->assertInstanceOf(AddressParts::class, $transactionDecoded->getRemitterAddressParts());
        $this->assertSame('ra1 ra2', $transactionDecoded->getRemitterAddressParts()->getAddress());
        $this->assertSame('a1 a2 a3', $transactionDecoded->getBeneficiaryAddress());
    }

    /** @test */
    public function it_can_decode_empty_transactions()
    {
        $xml = file_get_contents(dirname(__FILE__) . '/Data/empty_transactions.xml');

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
            'https://api.example/transaction/getPendingPayoutTransactions',
            [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => [
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

        $response = $api->getPendingTransactions();

        $this->assertInstanceOf(TransactionsResponse::class, $response);
        $this->assertSame(StatusCodeEnum::SUCCESS->value, $response->getStatus());
        $this->assertSame(0, $response->getResult()->getCount());
        $this->assertCount(0, $response->getResult()->getTransactionsList());
    }
}
