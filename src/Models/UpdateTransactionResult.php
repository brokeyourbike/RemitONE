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
class UpdateTransactionResult
{
    public function __construct(
        private string $trans_ref,
        private string $benef_trans_ref,
        private string $bank_comments,
        private string $payout_comments,
        private string $collection_pin,
    ) {
    }

    public function getReference(): string
    {
        return $this->trans_ref;
    }

    public function getBeneficiaryReference(): string
    {
        return $this->benef_trans_ref;
    }

    public function getBankComments(): string
    {
        return $this->bank_comments;
    }

    public function getPayoutComments(): string
    {
        return $this->payout_comments;
    }

    public function getCollectionPin(): string
    {
        return $this->collection_pin;
    }
}
