<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum WallMaterials: int implements HasLabel {

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
            self::Brick => 'Brick',
            self::Adobe => 'Adobe',
            self::CinderBlock => 'Cinder Block',
            self::Wood => 'Wood',
            self::Bahareque => 'Bahareque',
            self::Cane => 'Cane',
            self::Other => 'Other',
        };
    }
}
