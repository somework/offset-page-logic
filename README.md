# Offset Page Logic

Author: [Igor Pinchuk](https://github.com/somework "Github")  
Email: i.pinchuk.work@gmail.com

![Travis build](https://travis-ci.org/somework/offset-page-logic.svg?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/somework/offset-page-logic/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/somework/offset-page-logic/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/871fdfea-e1e2-4251-bb8c-f8b12e085eaf/mini.png)](https://insight.sensiolabs.com/projects/871fdfea-e1e2-4251-bb8c-f8b12e085eaf)

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
