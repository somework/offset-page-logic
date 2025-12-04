# Offset Page Logic

Author: [Igor Pinchuk](https://github.com/somework "Github")  
Email: i.pinchuk.work@gmail.com

[![Tests](https://img.shields.io/github/actions/workflow/status/somework/offset-page-logic/ci.yml?branch=master&label=Tests)](https://github.com/somework/offset-page-logic/actions/workflows/ci.yml?query=branch%3Amaster)
[![Quality](https://img.shields.io/github/actions/workflow/status/somework/offset-page-logic/ci.yml?branch=master&label=Quality)](https://github.com/somework/offset-page-logic/actions/workflows/ci.yml?query=branch%3Amaster)
[![Latest Stable Version](https://img.shields.io/packagist/v/somework/offset-page-logic.svg)](https://packagist.org/packages/somework/offset-page-logic)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Package that handle problem when you have only page, pagesize source interface and you need offset limit interface

```php
$offset = 0;
$limit = 0;
$nowCount = 0;

$result = \SomeWork\OffsetPage\Logic\Offset::logic($offset, $limit, $nowCount);
$result->getPage(); //0
$result->getSize(); //0
```

```php
$offset = 0;
$limit = 5;
$nowCount = 5;

$result = \SomeWork\OffsetPage\Logic\Offset::logic($offset, $limit, $nowCount);
// Throw exception \SomeWork\OffsetPage\Logic\AlreadyGetNeededCountException
```
 
License
----

MIT  
