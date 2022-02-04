# Changelog

### [0.5.3](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.5.2...v0.5.3) (2022-02-04)


### Bug Fixes

* error result can fail ([183f923](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/183f923cda1af7c7a685dbb80f7c122b7f97f373))

### [0.5.2](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.5.1...v0.5.2) (2022-02-04)


### Bug Fixes

* add card transfer type ([2a49fd8](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/2a49fd858464b851dd1a9eb9126240068e45f62a))

### [0.5.1](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.5.0...v0.5.1) (2022-02-02)


### Bug Fixes

* make normalizer compatible with symfony ([544b7bf](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/544b7bf0c6b54c86b13f169629cf46ffaf8d059b))

## [0.5.0](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.4.0...v0.5.0) (2022-01-25)


### ⚠ BREAKING CHANGES

* `send_currency` and `send_amount` are not required

### Bug Fixes

* `send_currency` and `send_amount` are not required ([0e93ed6](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/0e93ed666b76616abceb164740977f9369ff20c5))

## [0.4.0](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.3.1...v0.4.0) (2022-01-11)


### ⚠ BREAKING CHANGES

* allow more fields to be null

### Bug Fixes

* allow more fields to be null ([da8b151](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/da8b151be82407b5232fc26031aa193bf3595bf2))

### [0.3.1](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.3.0...v0.3.1) (2022-01-07)


### Bug Fixes

* add more properties ([e430b56](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/e430b56b629514d0cb094b212b942b30d867e9df))

## [0.3.0](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.2.0...v0.3.0) (2022-01-07)


### ⚠ BREAKING CHANGES

* ErrorTransaction, handle empty lists

### Bug Fixes

* ErrorTransaction, handle empty lists ([21e2f73](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/21e2f7364702a8884a6dfda54278e2d7b0cfaadf))

## [0.2.0](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.1.1...v0.2.0) (2022-01-04)


### Features

* add interfaces for Transaction and AddressParts ([a662999](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/a662999dfbee38766fee30b590bc4d7973462eda))

### [0.1.1](https://www.github.com/brokeyourbike/remit-one-api-client-php/compare/v0.1.0...v0.1.1) (2022-01-02)


### Bug Fixes

* add baseline for mehods ([950d2fc](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/950d2fc50a3d5d60fb5d66944f15a60e1309e48e))

## 0.1.0 (2021-12-25)


### Features

* add client ([c7b8534](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/c7b853424b82455d134f0688fef1831f638d484e))
* add response for `getTransactionDetails` ([acd504c](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/acd504c6e4434037e2557c6f0b9b3918210e8e77))
* add responses to more methods ([e09dd97](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/e09dd9730f10013fadb7953d1183f1aef73ec9c7))


### Bug Fixes

* access transactions ([922c958](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/922c958158db8d95a2f7478c5ca1f6146000adc9))
* add more enums ([73f0d64](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/73f0d6459ba541c842687c5bf97097c582814378))
* add response for `errorPayoutTransaction` ([d354d35](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/d354d3573f4529eec5ce405462ec877652465d1a))
* add response for `getTransactionStatus` ([60d8f82](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/60d8f820d0a4cab55c084dd12a509db1313611f9))
* add response for `updatePayoutTransDetails` ([bbbc334](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/bbbc3346fd240293303256454a875db1bf725293))
* remove unused code ([5a00db4](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/5a00db42200192825bda7de6951104d7bec67c80))
* remove unused dependencies ([970bcc8](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/970bcc8fdf189c272eb931131e2a77dabcfc16da))
* simplify code ([23d26f4](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/23d26f4f5c58e5202a60bc19e2852d03afd9cdbc))
* simplify methods name ([c260475](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/c26047589cdf008894e36907af844860a5d01966))
* use proper enum ([bd39631](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/bd39631a1ae13b2661dc58553524d198642db8d8))


### Miscellaneous Chores

* update example ([9032e51](https://www.github.com/brokeyourbike/remit-one-api-client-php/commit/9032e51a5f532d26c631ac33485c5971ba921027))
