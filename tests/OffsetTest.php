<?php

declare(strict_types=1);

/*
 * This file is part of the SomeWork/OffsetPage/Logic package.
 *
 * (c) Pinchuk Igor <i.pinchuk.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SomeWork\OffsetPage\Logic\Tests;

use PHPUnit\Framework\TestCase;
use SomeWork\OffsetPage\Logic\AlreadyGetNeededCountException;
use SomeWork\OffsetPage\Logic\Offset;

class OffsetTest extends TestCase
{
    /**
     * @dataProvider limitNowCountProvider
     *
     * @param array{page:int, size:int} $expectedResult
     */
    public function testLimitNowCount(int $offset, int $limit, int $nowCount, array $expectedResult): void
    {
        $result = Offset::logic($offset, $limit, $nowCount);
        $this->assertEquals($expectedResult['page'], $result->getPage());
        $this->assertEquals($expectedResult['size'], $result->getSize());
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int, expectedResult: array{page:int, size:int}}>
     */
    public static function limitNowCountProvider(): array
    {
        return [
            'offset=0;limit=5;nowCount=2;' => [
                'offset'         => 0,
                'limit'          => 5,
                'nowCount'       => 2,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 2,
                ],
            ],
            'offset<0;limit=5;nowCount=2;' => [
                'offset'         => -5,
                'limit'          => 5,
                'nowCount'       => 2,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 2,
                ],
            ],
            'offset=0;limit=5;nowCount=4;' => [
                'offset'         => 0,
                'limit'          => 5,
                'nowCount'       => 4,
                'expectedResult' => [
                    'page' => 5,
                    'size' => 1,
                ],
            ],
            'offset=0;limit=5;nowCount=0;' => [
                'offset'         => 0,
                'limit'          => 5,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 1,
                    'size' => 5,
                ],
            ],
            'offset=0;limit=5;nowCount<0;' => [
                'offset'         => 0,
                'limit'          => 5,
                'nowCount'       => -3,
                'expectedResult' => [
                    'page' => 1,
                    'size' => 5,
                ],
            ],
        ];
    }

    /**
     * @dataProvider oneMoreThanZeroProvider
     *
     * @param array{page:int, size:int} $expectedResult
     */
    public function testOneMoreThanZero(int $offset, int $limit, int $nowCount, array $expectedResult): void
    {
        $result = Offset::logic($offset, $limit, $nowCount);
        $this->assertEquals($expectedResult['page'], $result->getPage());
        $this->assertEquals($expectedResult['size'], $result->getSize());
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int, expectedResult: array{page:int, size:int}}>
     */
    public static function oneMoreThanZeroProvider(): array
    {
        return [
            'offset=0;limit=0;nowCount=0;' => [
                'offset'         => 0,
                'limit'          => 0,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 0,
                    'size' => 0,
                ],
            ],
            'offset<0;limit<0;nowCount<0;' => [
                'offset'         => -1,
                'limit'          => -1,
                'nowCount'       => -1,
                'expectedResult' => [
                    'page' => 0,
                    'size' => 0,
                ],
            ],
            'offset>0;limit=0;nowCount=0;' => [
                'offset'         => 22,
                'limit'          => 0,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 22,
                ],
            ],
            'offset=0;limit>0;nowCount=0;' => [
                'offset'         => 0,
                'limit'          => 10,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 1,
                    'size' => 10,
                ],
            ],
            /*
             * offset=0;limit=0;nowCount>0;
             * @see \SomeWork\OffsetPage\Logic\Tests\OffsetTest::testNowCountException()
             * Exception
             */
        ];
    }

    /**
     * @dataProvider offsetZeroProvider
     *
     * @param array{page:int, size:int} $expectedResult
     */
    public function testOffsetZero(int $offset, int $limit, int $nowCount, array $expectedResult): void
    {
        $result = Offset::logic($offset, $limit, $nowCount);
        $this->assertEquals($expectedResult['page'], $result->getPage());
        $this->assertEquals($expectedResult['size'], $result->getSize());
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int, expectedResult: array{page:int, size:int}}>
     */
    public static function offsetZeroProvider(): array
    {
        return [
            'offset=0;limit>0;nowCount=0;'                => [
                'offset'         => 0,
                'limit'          => 22,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 1,
                    'size' => 22,
                ],
            ],
            /*
             * offset=0;limit=0;nowCount>0;
             * offset=0;limit>0;nowCount>0;limit<nowCount;
             * offset=0;limit>0;nowCount>0;limit=nowCount;
             * @see \SomeWork\OffsetPage\Logic\Tests\OffsetTest::testNowCountException()
             * Exception
             */
            'offset=0;limit>0;nowCount>0;limit>nowCount;' => [
                'offset'         => 0,
                'limit'          => 22,
                'nowCount'       => 10,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 10,
                ],
            ],
            'offset<0;limit>0;nowCount>0;limit>nowCount;' => [
                'offset'         => -3,
                'limit'          => 22,
                'nowCount'       => 10,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 10,
                ],
            ],
        ];
    }

    /**
     * @dataProvider limitZeroProvider
     *
     * @param array{page:int, size:int} $expectedResult
     */
    public function testLimitZero(int $offset, int $limit, int $nowCount, array $expectedResult): void
    {
        $result = Offset::logic($offset, $limit, $nowCount);
        $this->assertEquals($expectedResult['page'], $result->getPage());
        $this->assertEquals($expectedResult['size'], $result->getSize());
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int, expectedResult: array{page:int, size:int}}>
     */
    public static function limitZeroProvider(): array
    {
        return [
            'offset>0;limit=0;nowCount=0;'                 => [
                'offset'         => 22,
                'limit'          => 0,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 22,
                ],
            ],
            'offset>0;limit<0;nowCount<0;'                  => [
                'offset'         => 22,
                'limit'          => -10,
                'nowCount'       => -5,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 22,
                ],
            ],
            'offset>0;limit=0;nowCount>0;nowCount<offset;' => [
                'offset'         => 22,
                'limit'          => 0,
                'nowCount'       => 2,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 24,
                ],
            ],
            'offset>0;limit=0;nowCount>0;nowCount=offset;' => [
                'offset'         => 22,
                'limit'          => 0,
                'nowCount'       => 22,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 44,
                ],
            ],
            'offset>0;limit=0;nowCount>0;nowCount>offset;' => [
                'offset'         => 22,
                'limit'          => 0,
                'nowCount'       => 40,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 62,
                ],
            ],
        ];
    }

    /**
     * @dataProvider limitOffsetMoreThanZeroProvider
     *
     * @param array{page:int, size:int} $expectedResult
     */
    public function testLimitOffsetMoreThanZero(int $offset, int $limit, int $nowCount, array $expectedResult): void
    {
        $result = Offset::logic($offset, $limit, $nowCount);
        $this->assertEquals($expectedResult['page'], $result->getPage());
        $this->assertEquals($expectedResult['size'], $result->getSize());
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int, expectedResult: array{page:int, size:int}}>
     */
    public static function limitOffsetMoreThanZeroProvider(): array
    {
        return [
            'offset>0;limit>0;nowCount=0;'                                      => [
                'offset'         => 22,
                'limit'          => 33,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 22,
                ],
            ],
            'offset>0;limit>0;nowCount<0;'                                      => [
                'offset'         => 22,
                'limit'          => 33,
                'nowCount'       => -5,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 22,
                ],
            ],
            'offset>0;limit>0;nowCount>0;limit>nowCount;limit-nowCount<offset;' => [
                'offset'         => 22,
                'limit'          => 33,
                'nowCount'       => 13,
                'expectedResult' => [
                    'page' => 6,
                    'size' => 7,
                ],
            ],
            'offset>0;limit>0;nowCount>0;limit>nowCount;limit-nowCount=offset;' => [
                'offset'         => 22,
                'limit'          => 35,
                'nowCount'       => 13,
                'expectedResult' => [
                    'page' => 6,
                    'size' => 7,
                ],
            ],
            'offset>0;limit>0;nowCount>0;limit>nowCount;limit-nowCount>offset;' => [
                'offset'         => 22,
                'limit'          => 35,
                'nowCount'       => 1,
                'expectedResult' => [
                    'page' => 2,
                    'size' => 23,
                ],
            ],
            'offset>limit;limit|offset;'                                       => [
                'offset'         => 44,
                'limit'          => 22,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 3,
                    'size' => 22,
                ],
            ],
            'offset>limit;limit!|offset;limit%offset;divisible;'               => [
                'offset'         => 45,
                'limit'          => 22,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 4,
                    'size' => 15,
                ],
            ],
            'offset>limit;limit!|offset;limit%offset;not-divisible;'           => [
                'offset'         => 47,
                'limit'          => 22,
                'nowCount'       => 0,
                'expectedResult' => [
                    'page' => 48,
                    'size' => 1,
                ],
            ],
            /*
             * offset>0;limit>0;nowCount>0;limit=nowCount;
             * offset>0;limit>0;nowCount>0;limit<nowCount;
             * @see \SomeWork\OffsetPage\Logic\Tests\OffsetTest::testNowCountException()
             */
        ];
    }

    /**
     * @dataProvider nowCountExceptionProvider
     */
    public function testNowCountException(int $offset, int $limit, int $nowCount): void
    {
        $this->expectException(AlreadyGetNeededCountException::class);
        $this->expectExceptionMessage('Limit is less than or equal to the current count. You should stop asking.');
        Offset::logic($offset, $limit, $nowCount);
    }

    /**
     * @return array<string, array{offset:int, limit:int, nowCount:int}>
     */
    public static function nowCountExceptionProvider(): array
    {
        return [
            'offset=0;limit=0;nowCount>0;'                => [
                'offset'   => 0,
                'limit'    => 0,
                'nowCount' => 22,
            ],
            'offset>0;limit>0;nowCount>0;limit=nowCount;' => [
                'offset'   => 22,
                'limit'    => 33,
                'nowCount' => 33,
            ],
            'offset>0;limit>0;nowCount>0;limit<nowCount;' => [
                'offset'   => 22,
                'limit'    => 32,
                'nowCount' => 33,
            ],
            'offset=0;limit>0;nowCount>0;limit<nowCount;' => [
                'offset'   => 0,
                'limit'    => 2,
                'nowCount' => 10,
            ],
            'offset=0;limit>0;nowCount>0;limit=nowCount;' => [
                'offset'   => 0,
                'limit'    => 10,
                'nowCount' => 10,
            ],
        ];
    }
}
