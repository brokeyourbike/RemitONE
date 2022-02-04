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
class ErrorTransactionResult
{
    public function __construct(
        private ?string $trans_ref,
        private ?string $error_result,
        private ?string $message,
    ) {
    }

    public function getReference(): ?string
    {
        return $this->trans_ref;
    }

    public function getErrorResult(): ?string
    {
        return $this->error_result;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
