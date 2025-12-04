# Offset Page Logic

Author: [Igor Pinchuk](https://github.com/somework "GitHub") Email: <i.pinchuk.work@gmail.com>

[![CI](https://img.shields.io/github/actions/workflow/status/somework/offset-page-logic/ci.yml?branch=master&label=CI)](https://github.com/somework/offset-page-logic/actions/workflows/ci.yml?query=branch%3Amaster)
[![Latest Stable Version](https://img.shields.io/packagist/v/somework/offset-page-logic.svg)](https://packagist.org/packages/somework/offset-page-logic)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Utility functions to convert offset/limit requests into page/page-size arguments.

## Installation

Install the package via Composer:

```bash
composer require somework/offset-page-logic
```

## Usage

`Offset::logic()` returns a DTO containing the calculated page (1-based) and page size
for the given offset and limit. The method also guards against requesting more
rows than are available.

```php
use SomeWork\OffsetPage\Logic\Offset;

$offset = 0;  // start from the first record
$limit = 10;  // request ten records
$nowCount = 42; // total records already processed or available

$result = Offset::logic($offset, $limit, $nowCount);

$result->getPage(); // 1 (first page)
$result->getSize(); // 10 (page size derived from limit)
```

If the requested limit would exceed the available records, an exception is thrown:

```php
use SomeWork\OffsetPage\Logic\AlreadyGetNeededCountException;
use SomeWork\OffsetPage\Logic\Offset;

$offset = 0;
$limit = 5;
$nowCount = 5;

$result = Offset::logic($offset, $limit, $nowCount); // throws AlreadyGetNeededCountException
```

## Development

Run the automated checks locally using Composer scripts:

```bash
composer install
composer test       # PHPUnit test suite
composer stan       # PHPStan static analysis
composer cs-check   # PHP CS Fixer dry-run for coding standards
```

## License

MIT
