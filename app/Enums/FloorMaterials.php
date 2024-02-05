<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FloorMaterials: int implements HasLabel
{
    use BaseEnum;

    case Dirt = 1;
    case Cement = 2;
    case Wood = 3;
    case Other = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::Dirt => __('Dirt'),
            self::Cement => __('Cement'),
            self::Wood => __('Wood'),
            self::Other => __('Other'),
        };
    }
}
