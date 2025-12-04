# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html). Update this file with each release so adopters and Packagist visitors can track what changed.

## [2.0.0] - 2025-12-04
### Changed
- Raised the PHP requirement to 8.2 and refreshed development tooling (PHPUnit 10, PHPStan, and PHP CS Fixer) with composer scripts to run tests, static analysis, and coding standards checks.
- Enforced integer-only inputs for offset, limit, and nowCount with strict typing while normalizing negative values to zero.
- Clarified the `AlreadyGetNeededCountException` message when the requested limit is already satisfied.
- Expanded PHPUnit coverage for divisor-loop pagination edges and negative offset/limit inputs.
- Modernized PHPUnit data providers and exception expectations to clear deprecations when running on PHP 8.2.

## [1.0.0] - 2017-06-04
### Added
- Initial release delivering offset/limit to page/page-size conversion logic and the `AlreadyGetNeededCountException` guard.
