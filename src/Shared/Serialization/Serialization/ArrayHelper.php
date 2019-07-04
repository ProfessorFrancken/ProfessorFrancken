<?php

declare(strict_types = 1);

namespace Francken\Shared\Serialization\Serialization;

final class ArrayHelper
{
    /**
     * Find out if the given array is numerically indexed?
     */
    public static function isNumericallyIndexed(array $values): bool
    {
        if (empty($values)) {
            return true;
        }

        reset($values);

        return is_int(key($values));
    }
}
