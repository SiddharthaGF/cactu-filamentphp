<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WallMaterials: int implements HasLabel
{
    use BaseEnum;

    case Brick = 1;
    case Adobe = 2;
    case CinderBlock = 3;
    case Wood = 4;
    case Bahareque = 5;
    case Cane = 6;
    case Other = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::Brick => __('Brick'),
            self::Adobe => __('Adobe'),
            self::CinderBlock => __('Cinder Block'),
            self::Wood => __('Wood'),
            self::Bahareque => __('Bahareque'),
            self::Cane => __('Cane'),
            self::Other => __('Other'),
        };
    }
}
