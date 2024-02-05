<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HomeSpaceSituations: int implements HasLabel
{
    use BaseEnum;

    case Room = 1;
    case RoomAndKitchen = 2;
    case Other = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Room => __('Room'),
            self::RoomAndKitchen => __('Room and kitchen'),
            self::Other => __('Other'),
        };
    }

}
