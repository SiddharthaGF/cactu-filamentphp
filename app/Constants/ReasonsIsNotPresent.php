<?php

declare(strict_types=1);

namespace App\Constants;

use Illuminate\Support\Str;

final class ReasonsIsNotPresent
{
    public const options = [
        'Divorced',
        'Separated',
        'Lives Elsewhere',
        'Dead',
        'Other',
    ];

    public static function getAllOnlySlugs(): array
    {
        foreach (self::options as $option) {
            $options[$option] = Str::slug($option);
        }

        return $options;
    }

    public static function getAll(): array
    {
        return self::options;
    }

    public static function getAllSlugs(): array
    {
        foreach (self::options as $option) {
            $newArray[$option] = $option;
        }

        return $newArray;
    }
}
