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
enum TransactionStatusEnum: string
{
    /**
     * Transaction has been created in the system but the remitter has not paid for transaction.
     * Awaiting payment before transaction will be ready for processing.
     */
    case PENDING_CLEARANCE = 'PENDING_CLEARANCE';

    /**
     * Transaction awaiting approval by sending agent before processing.
     */
    case ENTERED = 'ENTERED';

    /**
     * Transaction awaiting HQ approval or routing before processing.
     */
    case AGENT_OK = 'AGENT_OK';

    /**
     * ransaction has been approved by HQ and will be sent to processing bank/agent in the next batch.
     * This only applies if you are using batch processing.
     */
    case HQ_READY = 'HQ_READY';

    /**
     * Transaction awaiting processing bank/agent approval before ready for processing.
     */
    case HQ_OK = 'HQ_OK';

    /**
     * Transaction awaiting processing bank/agent approval before ready for processing
     * but transaction has been credited to processing bank/agent already.
     * This status only applies in error correction scenarios.
     */
    case HQ_OK_PAID = 'HQ_OK_PAID';

    /**
     * Transaction ready to be paid out by processing bank/agent.
     */
    case SENT_FOR_PAY = 'SENT_FOR_PAY';

    /**
     * Transaction ready to be paid out by processing bank/agent branch.
     */
    case SENT_FOR_DELIVERY = 'SENT_FOR_DELIVERY';

    /**
     * Transaction has been processed.
     */
    case PROCESSED = 'PROCESSED';

    /**
     * Transaction has been accepted by processing bank/agent but now it has been requested to be cancelled.
     * Awaiting processing bank/agent approval for cancellation or rejection of cancellation request.
     */
    case ABORTED = 'ABORTED';

    /**
     * Transaction has some problem with it and is going through error correction cycle.
     */
    case ERROR = 'ERROR';

    /**
     * Transaction has been cancelled.
     */
    case DELETED = 'DELETED';
}
