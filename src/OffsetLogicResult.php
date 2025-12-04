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
    public function __construct(protected int $page = 0, protected int $size = 0)
    {
        $this->setPage($page);
        $this->setSize($size);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page >= 0 ? $page : 0;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size > 0 ? $size : 0;

        return $this;
    }
}
