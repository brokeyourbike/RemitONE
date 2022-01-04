<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Interfaces;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface DecodedAddressPartsInterface
{
    public function getBuildingNumber(): string;
    public function getAddress(): string;
    public function getCity(): string;
    public function getState(): string;
    public function getPostcode(): string;
    public function getCountry(): string;
}
