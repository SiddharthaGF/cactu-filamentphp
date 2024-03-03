<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DrinkingWater => __('Drinking Water'),
            self::TubingWater => __('Tubing Water'),
            self::WellWater => __('Well Water'),
            self::Internet => __('Internet'),
            self::Sewerage => __('Sewerage'),
            self::Toilet => __('Toilet'),
            self::Latrine => __('Latrine'),
            self::SepticTank => __('Septic Tank'),
            self::Electricity => __('Electricity'),
            self::Shower => __('Shower'),
        };
    }
}
