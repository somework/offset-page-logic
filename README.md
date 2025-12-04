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
rows than are available. All inputs are strict integers; negative values are coerced to
`0`.

## Behavior

`Offset::logic()` branches through several scenarios to normalize offset/limit inputs
into page-based pagination:

* **Zeroed inputs** – if `offset`, `limit`, and `nowCount` are all `0`, the method
  returns page `0` and size `0`, representing a request for “everything” without
  pagination.
* **Limit-only** – with `offset` at `0`, a positive `limit` sets the page size while
  the page is `1`.
* **Offset-only** – with `limit` at `0`, a positive `offset` yields page `2` and a
  size of `offset + nowCount` (the offset is always at least the page size).
* **Limit exceeds current count** – when `nowCount` is positive and smaller than the
  requested `limit`, the method recurses by subtracting `nowCount` from `limit` and
  adding it to `offset`, then resolves the pagination with the remaining values.
* **Standard offset/limit division** – when both are positive and `nowCount` is `0`,
  the page and size are derived from `offset` divided by `limit`, using the largest
  divisor of the offset to maximize page size.
* **`AlreadyGetNeededCountException` condition** – if `nowCount` is positive and not
  less than the requested `limit`, the method throws
  `AlreadyGetNeededCountException` to signal that all required rows are already
  retrieved.

| Offset | Limit | nowCount | Outcome                                 | Notes                                                  |
|--------|-------|----------|-----------------------------------------|--------------------------------------------------------|
| `0`    | `0`   | `0`      | Page `0`, Size `0`                      | Zeroed inputs return a sentinel “all rows” response.   |
| `0`    | `10`  | `0`      | Page `1`, Size `10`                     | Limit-only scenario with a page starting at `1`.       |
| `22`   | `0`   | `0`      | Page `2`, Size `22`                     | Offset-only scenario; size grows with the offset.      |
| `0`    | `22`  | `10`     | Page `2`, Size `10`                     | Limit exceeds `nowCount`; recursion reduces the limit. |
| `44`   | `22`  | `0`      | Page `3`, Size `22`                     | Standard offset/limit division (`44/22 + 1`).          |
| `0`    | `5`   | `5`      | Throws `AlreadyGetNeededCountException` | Requested limit is already satisfied by `nowCount`.    |

```php
use SomeWork\OffsetPage\Logic\Offset;

$offset = 0;  // start from the first record
$limit = 10;  // request ten records
$nowCount = 0; // no rows have been processed yet

$result = Offset::logic($offset, $limit, $nowCount);

$result->getPage(); // 1 (first page)
$result->getSize(); // 10 (page size derived from limit)
```

If the requested limit is already satisfied by `nowCount`, an exception is thrown:

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
