<?php

declare(strict_types=1);

namespace App\Constants;

use App\Enums\BaseEnum;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum BasicServices: int implements HasLabel
{
    use BaseEnum;

    case DrinkingWater = 1;
    case TubingWater = 2;
    case WellWater = 3;
    case Internet = 4;
    case Sewerage = 5;
    case Toilet = 6;
    case Latrine = 7;
    case SepticTank = 8;
    case Electricity = 9;
    case Shower = 10;

    public function getLabel():? string
    {
       return match ($this) {
            self::DrinkingWater => 'Drinking Water',
            self::TubingWater => 'Tubing Water',
            self::WellWater => 'Well Water',
            self::Internet => 'Internet',
            self::Sewerage => 'Sewerage',
            self::Toilet => 'Toilet',
            self::Latrine => 'Latrine',
            self::SepticTank => 'Septic Tank',
            self::Electricity => 'Electricity',
            self::Shower => 'Shower',
        };
    }
}
