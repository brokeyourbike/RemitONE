<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Tests;

use PHPUnit\Framework\TestCase;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;
use BrokeYourBike\RemitOne\Client;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;
use BrokeYourBike\HasSourceModel\HasSourceModelTrait;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class ClientTest extends TestCase
{
    /** @test */
    public function it_implemets_http_client_interface(): void
    {
        /** @var UserInterface */
        $mockedUser = $this->getMockBuilder(UserInterface::class)->getMock();

        /** @var \GuzzleHttp\ClientInterface */
        $mockedHttpClient = $this->getMockBuilder(\GuzzleHttp\ClientInterface::class)->getMock();

        $api = new Client($mockedUser, $mockedHttpClient);

        $this->assertInstanceOf(HttpClientInterface::class, $api);
        $this->assertSame($mockedUser, $api->getUser());
    }

    /** @test */
    public function it_uses_http_client_trait(): void
    {
        $usedTraits = class_uses(Client::class);

        $this->assertArrayHasKey(HttpClientTrait::class, $usedTraits);
    }

    /** @test */
    public function it_uses_resolve_uri_trait(): void
    {
        $usedTraits = class_uses(Client::class);

        $this->assertArrayHasKey(ResolveUriTrait::class, $usedTraits);
    }

    /** @test */
    public function it_uses_has_source_model_trait(): void
    {
        $usedTraits = class_uses(Client::class);

        $this->assertArrayHasKey(HasSourceModelTrait::class, $usedTraits);
    }
}
