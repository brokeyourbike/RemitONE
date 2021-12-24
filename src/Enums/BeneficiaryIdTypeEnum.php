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
enum BeneficiaryIdTypeEnum: string
{
    case PASSPORT = 'PASSPORT';
    case CHEQUE_BOOK = 'CHEQUEBOOK';
    case DRIVING_LICENSE = 'DRIVINGLICENSE';
    case NATIONAL_ID = 'NATIONALID';
    case VOTING_CARD = 'VOTINGCARD';
    case OTHER = 'OTHER';
}
