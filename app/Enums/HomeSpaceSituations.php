<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum HomeSpaceSituations: int implements HasLabel
{

    use BaseEnum;

    case Room = 1;
    case RoomAndKitchen = 2;
    case Other = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Room => 'Room',
            self::RoomAndKitchen => 'Room and kitchen',
            self::Other => 'Other',
        };
    }

}
