# remit-one-api-client

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/remit-one-api-client-php)](https://github.com/brokeyourbike/remit-one-api-client-php/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/remit-one-api-client/downloads)](https://packagist.org/packages/brokeyourbike/remit-one-api-client)
[![License: MPL-2.0](https://img.shields.io/badge/license-MPL--2.0-purple.svg)](https://github.com/brokeyourbike/remit-one-api-client-php/blob/main/LICENSE)

[![Maintainability](https://api.codeclimate.com/v1/badges/db4ebf963ec59de7bb90/maintainability)](https://codeclimate.com/github/brokeyourbike/remit-one-api-client-php/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/db4ebf963ec59de7bb90/test_coverage)](https://codeclimate.com/github/brokeyourbike/remit-one-api-client-php/test_coverage)
[![tests](https://github.com/brokeyourbike/remit-one-api-client-php/actions/workflows/tests.yml/badge.svg)](https://github.com/brokeyourbike/remit-one-api-client-php/actions/workflows/tests.yml)

RemitONE API Client for PHP

## Installation

```bash
composer require brokeyourbike/remit-one-api-client
```

## Usage

```php
use BrokeYourBike\RemitOne\Client;
use BrokeYourBike\RemitOne\Interfaces\UserInterface;

assert($user instanceof UserInterface);
assert($httpClient instanceof \GuzzleHttp\ClientInterface);

$apiClient = new Client($user, $httpClient);
$apiClient->getPayoutTransactions();
```

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/remit-one-api-client-php/blob/main/LICENSE)
