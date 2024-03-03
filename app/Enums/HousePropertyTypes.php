<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HousePropertyTypes: int implements HasLabel
{
    use BaseEnum;

    case SelfOwned = 1;
    case Rental = 2;
    case Borrowed = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SelfOwned => __('Self-owned'),
            self::Rental => __('Rental'),
            self::Borrowed => __('Borrowed'),
        };
    }
}
