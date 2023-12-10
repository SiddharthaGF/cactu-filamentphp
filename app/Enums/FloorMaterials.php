<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

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
            self::Dirt => 'Dirt',
            self::Cement => 'Cement',
            self::Wood => 'Wood',
            self::Other => 'Other',
        };
    }
}
