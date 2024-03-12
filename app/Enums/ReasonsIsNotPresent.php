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
    case Other = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Divorced => __('Divorced'),
            self::Separated => __('Separated'),
            self::LivesElsewhere => __('Lives Elsewhere'),
            self::Dead => __('Dead'),
            self::Other => __('Other'),
        };
    }
}
