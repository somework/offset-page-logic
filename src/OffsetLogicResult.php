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

namespace SomeWork\OffsetPage\Logic;

class OffsetLogicResult
{
    protected int $page = 0;

    protected int $size = 0;

    public function __construct(int|string $page = 0, int|string $size = 0)
    {
        $this->setPage($page);
        $this->setSize($size);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int|string $page): self
    {
        $page = (int) $page;
        $this->page = $page >= 0 ? $page : 0;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int|string $size): self
    {
        $size = (int) $size;
        $this->size = $size > 0 ? $size : 0;

        return $this;
    }
}
