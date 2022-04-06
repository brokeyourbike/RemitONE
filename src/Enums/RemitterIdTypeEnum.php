<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Enums;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
enum RemitterIdTypeEnum: string
{
    case PASSPORT = 'Passport';
    case DRIVING_LICENSE = 'Driving_License';
    case NATIONAL_INSURANCE = 'National_Insurance';
    case NATIONAL_ID = 'National_ID';
    case UTILITY_BILL = 'Utility_Bill';
    case RESIDENCE_CARD = 'Residence_card';
    case OTHER = 'Other';
}
