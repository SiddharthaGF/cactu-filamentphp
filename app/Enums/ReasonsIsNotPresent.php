<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReasonsIsNotPresent: int implements HasLabel
{
    use BaseEnum;

    case Divorced = 1;
    case Separated = 2;
    case LivesElsewhere = 3;
    case Dead = 4;
    case Other = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Divorced => 'Divorced',
            self::Separated => 'Separated',
            self::LivesElsewhere => 'Lives Elsewhere',
            self::Dead => 'Dead',
            self::Other => 'Other',
        };
    }
}
