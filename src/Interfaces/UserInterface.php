<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Interfaces;

use BrokeYourBike\RemitOne\Enums\UserTypeEnum;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface UserInterface
{
    public function getType(): UserTypeEnum;
    public function getUsername(): string;
    public function getPassword(): string;
    public function getPin(): string;
    public function getUrl(): string;
}
