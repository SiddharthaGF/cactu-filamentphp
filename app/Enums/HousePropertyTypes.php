<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum HousePropertyTypes: int implements HasLabel
{

    use BaseEnum;

    case SelfOwned = 1;
    case Rental = 2;
    case Borrowed = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SelfOwned => 'Self-owned',
            self::Rental => 'Rental',
            self::Borrowed => 'Borrowed',
        };
    }

}
