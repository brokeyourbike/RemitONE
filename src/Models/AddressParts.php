<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Models;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class AddressParts
{
    public function __construct(
        private string $remitter_building_no,
        private string $remitter_address1,
        private string $remitter_address2,
        private string $remitter_city,
        private string $remitter_state,
        private string $remitter_postcode,
        private string $remitter_country,
    ) {
    }

    public function getBuildingNumber(): string
    {
        return $this->remitter_building_no;
    }

    public function getAddress(): string
    {
        return trim("{$this->remitter_address1} {$this->remitter_address2}");
    }

    public function getCity(): string
    {
        return $this->remitter_city;
    }

    public function getState(): string
    {
        return $this->remitter_state;
    }

    public function getPostcode(): string
    {
        return $this->remitter_postcode;
    }

    public function getCountry(): string
    {
        return $this->remitter_country;
    }
}
