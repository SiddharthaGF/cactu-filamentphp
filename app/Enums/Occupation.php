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
            self::PrivateEmployee => 'Private Employee',
            self::Artisan => 'Artisan',
            self::Farmer => 'Farmer',
            self::AnimalKeeper => 'Animal Keeper',
            self::Cook => 'Cook',
            self::Carpenter => 'Carpenter',
            self::Builder => 'Builder',
            self::DayLaborer => 'Day Laborer',
            self::Mechanic => 'Mechanic',
            self::Salesman => 'Salesman',
            self::PaidHouseholdWork => 'Paid Household Work',
            self::UnpaidHouseholdWork => 'Unpaid Household Work',
            self::Unknown => 'Unknown',
            self::Other => 'Other',
        };
    }
}
