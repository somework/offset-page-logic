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

## Behavior

`Offset::logic()` branches through several scenarios to normalize offset/limit inputs
into page-based pagination:

* **Unconstrained requests** – when neither `offset` nor `limit` is provided, the
  method assumes the first page with the default page size.
* **Offset-only** – a provided `offset` derives the page from the offset divisor with
  the page size unchanged.
* **Limit-only** – a provided `limit` sets the page size while the page remains `1`.
* **Offset > limit divisor logic** – when both are provided and the offset exceeds the
  limit, the page is calculated from the integer division `offset / limit + 1`.
* **`AlreadyGetNeededCountException` condition** – if `offset + limit` would exceed
  the available records (`nowCount`), the method throws
  `AlreadyGetNeededCountException` to signal that all required rows are already
  retrieved.

| Offset | Limit | nowCount | Outcome | Notes |
| --- | --- | --- | --- | --- |
| `null` | `null` | `100` | Page `1`, Size default | Unconstrained request uses defaults. |
| `20` | `null` | `100` | Page derived from offset, Size default | Offset-only scenario. |
| `null` | `25` | `100` | Page `1`, Size `25` | Limit-only scenario. |
| `40` | `20` | `100` | Page `3`, Size `20` | Offset > limit divisor logic (`40/20 + 1`). |
| `80` | `30` | `100` | Throws `AlreadyGetNeededCountException` | Offset + limit exceeds available rows. |

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
