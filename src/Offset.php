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

class Offset
{
    /**
     * @param int $offset
     * @param int $limit
     * @param int $nowCount
     *
     * @throws \LogicException
     * @throws \SomeWork\OffsetPage\Logic\AlreadyGetNeededCountException
     *
     * @return OffsetLogicResult
     */
    public static function logic(int $offset, int $limit, int $nowCount = 0): OffsetLogicResult
    {
        $offset = $offset >= 0 ? $offset : 0;
        $limit = $limit >= 0 ? $limit : 0;
        $nowCount = $nowCount >= 0 ? $nowCount : 0;

        /*
         * Indicates an unconstrained request: return everything.
         */
        if ($offset === 0 && $limit === 0 && $nowCount === 0) {
            return new OffsetLogicResult(0, 0);
        }

        if ($offset === 0 && $limit > 0 && $nowCount === 0) {
            return new OffsetLogicResult(1, $limit);
        }

        if ($offset > 0 && $limit === 0) {
            return new OffsetLogicResult(2, $nowCount + $offset);
        }

        if ($nowCount > 0) {
            if ($limit > $nowCount) {
                return static::logic($offset + $nowCount, $limit - $nowCount);
            }

            throw new AlreadyGetNeededCountException("Limit is less than or equal to the current count. You should stop asking.");
        }

        if ($offset > 0 && $limit > 0) {
            if ($offset === $limit) {
                return new OffsetLogicResult(2, $limit);
            }
            if ($offset < $limit) {
                return new OffsetLogicResult(2, $offset);
            }
            if ($offset > $limit) {
                for ($i = $limit; $i > 0; $i--) {
                    if ($offset % $i === 0) {
                        return new OffsetLogicResult(
                            intdiv($offset, $i) + 1,
                            $i,
                        );
                    }
                }
            }
        }

        /*
         * This branch should be unreachable.
         */

        throw new \LogicException('Unexpected offset/limit combination encountered');
    }
}
