<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Models;

use BrokeYourBike\RemitOne\Models\AcceptTransaction;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class AcceptTransactionsWrapper
{
    /**
     * @param AcceptTransaction[] $transaction
     */
    public function __construct(
        private array $transaction,
    ) {
    }
}
