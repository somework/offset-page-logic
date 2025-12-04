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
    public static function logic($offset, $limit, $nowCount = 0)
    {
        $offset = (int) $offset;
        $limit = (int) $limit;
        $nowCount = (int) $nowCount;

        $offset = $offset >= 0 ? $offset : 0;
        $limit = $limit >= 0 ? $limit : 0;
        $nowCount = $nowCount >= 0 ? $nowCount : 0;

        /*
         * Means that you should get all
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
            // Means that you should stop fetching
            throw new AlreadyGetNeededCountException('Limit <= no count. You should stop asking (:');
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
                            ($offset / $i) + 1,
                            $i
                        );
                    }
                }
            }
        }

        /*
         * Really its can be here oO
         */
        throw new \LogicException('Something gone wrong');
    }
}
