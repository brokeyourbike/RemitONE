<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Normalizer extends ObjectNormalizer
{
    /**
     * Normalizes the given data to an array. It's particularly useful during
     * the denormalization process.
     */
    protected function prepareForDenormalization(object|array|null $data): array
    {
        $normalized = (array) $data;

        // we map transactions to the object
        // it should contain list of transactions or be null
        // not a string
        if (isset($normalized['result']['transactions']) &&
        is_string($normalized['result']['transactions'])) {
            unset($normalized['result']['transactions']);
        }

        return $normalized;
    }
}
