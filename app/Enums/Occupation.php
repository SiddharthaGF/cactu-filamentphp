<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Occupation: int implements HasLabel
{
    use BaseEnum;

    case PrivateEmployee = 1;
    case Artisan = 2;
    case Farmer = 3;
    case AnimalKeeper = 4;
    case Cook = 5;
    case Carpenter = 6;
    case Builder = 7;
    case DayLaborer = 8;
    case Mechanic = 9;
    case Salesman = 10;
    case PaidHouseholdWork = 11;
    case UnpaidHouseholdWork = 12;
    case Unknown = 13;
    case Other = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PrivateEmployee => __('Private Employee'),
            self::Artisan => __('Artisan'),
            self::Farmer => __('Farmer'),
            self::AnimalKeeper => __('Animal Keeper'),
            self::Cook => __('Cook'),
            self::Carpenter => __('Carpenter'),
            self::Builder => __('Builder'),
            self::DayLaborer => __('Day Laborer'),
            self::Mechanic => __('Mechanic'),
            self::Salesman => __('Salesman'),
            self::PaidHouseholdWork => __('Paid Household Work'),
            self::UnpaidHouseholdWork => __('Unpaid Household Work'),
            self::Unknown => __('Unknown'),
            self::Other => __('Other'),
        };
    }
}
