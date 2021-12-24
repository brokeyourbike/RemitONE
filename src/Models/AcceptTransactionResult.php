<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Models;

use BrokeYourBike\RemitOne\Models\AcceptTransactionsWrapper;
use BrokeYourBike\RemitOne\Models\AcceptTransaction;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class AcceptTransactionResult
{
    public function __construct(
        private int $total_count,
        private int $success_count,
        private int $failed_count,
        private AcceptTransactionsWrapper $transactions,
    ) {
    }

    public function getTotalCount(): int
    {
        return $this->total_count;
    }

    public function getSuccessCount(): int
    {
        return $this->success_count;
    }

    public function getFailedCount(): int
    {
        return $this->failed_count;
    }

    /**
     * @return AcceptTransaction[]
     */
    public function getTransactionsList(): array
    {
        return $this->transactions->all();
    }
}
