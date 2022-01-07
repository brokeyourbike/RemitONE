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
class ErrorTransaction
{
    public function __construct(
        private string $trans_ref,
        private string $trans_type,
        private string $status,
        private string $error_date,
        private string $error_reason,
        private string $previous_status_before_error,
        private string $error_user_id,
        private string $error_username,
        private string $error_agent_code,
        private string $error_agent_name,
    ) {}

    public function getReference(): string
    {
        return $this->trans_ref;
    }

    public function getType(): string
    {
        return $this->trans_type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrorDate(): string
    {
        return $this->error_date;
    }

    public function getErrorReason(): string
    {
        return $this->error_reason;
    }

    public function getPreviousStatusBeforeError(): string
    {
        return $this->previous_status_before_error;
    }

    public function getErrorUserId(): string
    {
        return $this->error_user_id;
    }

    public function getErrorUsername(): string
    {
        return $this->error_username;
    }

    public function getErrorAgentCode(): string
    {
        return $this->error_agent_code;
    }

    public function getErrorAgentName(): string
    {
        return $this->error_agent_name;
    }
}
