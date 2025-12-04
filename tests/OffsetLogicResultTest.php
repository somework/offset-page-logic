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
use SomeWork\OffsetPage\Logic\OffsetLogicResult;

class OffsetLogicResultTest extends TestCase
{
    public function testDefaultCreate()
    {
        $offsetLogicResult = new OffsetLogicResult();
        $this->assertEquals(0, $offsetLogicResult->getPage());
        $this->assertEquals(0, $offsetLogicResult->getSize());
    }

    public function testSetOnCreate()
    {
        $offsetLogicResult = new OffsetLogicResult(4, 20);
        $this->assertEquals(4, $offsetLogicResult->getPage());
        $this->assertEquals(20, $offsetLogicResult->getSize());
    }

    public function testWrongCreate()
    {
        $offsetLogicResult = new OffsetLogicResult(-1, -22);
        $this->assertEquals(0, $offsetLogicResult->getPage());
        $this->assertEquals(0, $offsetLogicResult->getSize());
    }

    public function testPageSet()
    {
        $offsetLogicResult = new OffsetLogicResult();
        $offsetLogicResult->setPage(5);
        $this->assertEquals(5, $offsetLogicResult->getPage());
    }

    public function testSizeSet()
    {
        $offsetLogicResult = new OffsetLogicResult();
        $offsetLogicResult->setSize(6);
        $this->assertEquals(6, $offsetLogicResult->getSize());
    }
}
