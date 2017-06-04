<?php

/*
 * This file is part of the SomeWork/OffsetPage/Logic package.
 *
 * (c) Pinchuk Igor <i.pinchuk.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SomeWork\OffsetPage\Logic;

class OffsetLogicResult
{
    /**
     * @var int
     */
    protected $page;
    /**
     * @var int
     */
    protected $size;

    public function __construct($page = 0, $size = 0)
    {
        $this->setPage($page);
        $this->setSize($size);
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = (int) $page >= 0 ? (int) $page : 0;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = (int) $size > 0 ? (int) $size : 0;
        return $this;
    }
}
