# [2.1.0](https://github.com/stickeeuk/canary/compare/v2.0.6...v2.1.0) (2023-03-20)


### Features

* Allow command specific options to be injected in - in this case, for disabling xDebug when present for PHPStan performance. ([14e8d95](https://github.com/stickeeuk/canary/commit/14e8d9577c91c45aa615a32d230099c8247dca23))

## [2.0.6](https://github.com/stickeeuk/canary/compare/v2.0.5...v2.0.6) (2023-03-16)


### Bug Fixes

* output for tool command to also contain error output ([#22](https://github.com/stickeeuk/canary/issues/22)) ([ef9585d](https://github.com/stickeeuk/canary/commit/ef9585dfabe2dd1e7462bb75a3563fe9d2024b15))

## [2.0.5](https://github.com/stickeeuk/canary/compare/v2.0.4...v2.0.5) (2023-01-12)


### Bug Fixes

* PHP CS Fixer action finding too many changed files ([92d50ae](https://github.com/stickeeuk/canary/commit/92d50ae9d34606cfd1357d34ebaa7d28dc3cb597))

## [2.0.4](https://github.com/stickeeuk/canary/compare/v2.0.3...v2.0.4) (2023-01-11)


### Bug Fixes

* example PHP CS Fixer action not always picking up changed files ([0ab8a68](https://github.com/stickeeuk/canary/commit/0ab8a68fe731703fb5e162e78c8a976b8efb314c))

## [2.0.3](https://github.com/stickeeuk/canary/compare/v2.0.2...v2.0.3) (2023-01-11)


### Bug Fixes

* composer bin dir fallback by reverting earlier change ([ef75ad5](https://github.com/stickeeuk/canary/commit/ef75ad57417716f4b92173e1cfba48ac955e6a1d))
* composer bin dir requirements and fallback ([72499b4](https://github.com/stickeeuk/canary/commit/72499b4a4c23178ced7dc70c08b4f7f06389a73a))

## [2.0.2](https://github.com/stickeeuk/canary/compare/v2.0.1...v2.0.2) (2022-12-14)


### Bug Fixes

* paths inside installed PHPStan config ([5e1387c](https://github.com/stickeeuk/canary/commit/5e1387cef9dd4156d6875864040d7bfc342dffac))
* short timeout by increasing it to 5 minutes ([15911ad](https://github.com/stickeeuk/canary/commit/15911ad94125470a21ad349ad0abc36158c496f7))

## [2.0.1](https://github.com/stickeeuk/canary/compare/v2.0.0...v2.0.1) (2022-12-13)


### Bug Fixes

* composer bin path when installed with composer ([#12](https://github.com/stickeeuk/canary/issues/12)) ([a64162e](https://github.com/stickeeuk/canary/commit/a64162ea28390b62b5999aee80b78ffebfcd5404))

# [2.0.0](https://github.com/stickeeuk/canary/compare/v1.0.2...v2.0.0) (2022-12-13)


### Features

* Laravel 9 ([#10](https://github.com/stickeeuk/canary/issues/10)) ([4445db0](https://github.com/stickeeuk/canary/commit/4445db092f11d1c9cdcc7218c036a68de49a43d3))


### BREAKING CHANGES

* drops PHP 7.4 and requires PHP 8.1

Co-authored-by: Oliver Earl <oliver.earl@stickee.co.uk>

## [1.0.2](https://github.com/stickeeuk/canary/compare/v1.0.1...v1.0.2) (2022-12-09)


### Bug Fixes

* remove temperamental bash script and installation command ([f3b8a59](https://github.com/stickeeuk/canary/commit/f3b8a5991688c17767e8bee68a7832d99ccef0ad))

## [1.0.1](https://github.com/stickeeuk/canary/compare/v1.0.0...v1.0.1) (2022-11-10)


### Bug Fixes

* drop Rector for PHP7.4 ([7d49e1b](https://github.com/stickeeuk/canary/commit/7d49e1b69a924ecfea08e4a1790f51a6b469cf64))
* PHP CS Fixer example CI git commit path ([ef7752f](https://github.com/stickeeuk/canary/commit/ef7752f961916adf68495f4b2c56743d6a489776))
