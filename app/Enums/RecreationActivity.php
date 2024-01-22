<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ActivityForFamilySupport: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Washes = 1;
    case BringsFirewood = 2;
    case BringsWater = 3;
    case TakesCareOfAnimals = 4;
    case Cooks = 5;
    case HasDeBed = 6;
    case DoesTheShopping = 7;
    case CaresOfBrothersSisters = 8;
    case CleansTheHouse = 9;
    case RunsErrands = 10;
    case GathersGrassForAnimals = 11;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Washes => __('Washes'),
            self::BringsFirewood => __('Brings firewood'),
            self::BringsWater =>__('Brings water'),
            self::TakesCareOfAnimals => __('Takes care of animals'),
            self::Cooks => __('Cooks'),
            self::HasDeBed => __('Has de bed'),
            self::DoesTheShopping => __('Does the shopping'),
            self::CaresOfBrothersSisters => __('Cares of brothers/sisters'),
            self::CleansTheHouse => __('Cleans the house'),
            self::RunsErrands => __('Runs errands'),
            self::GathersGrassForAnimals => __('Gathers grass for animals'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Affiliated => 'success',
            self::Disaffiliated => 'gray',
            self::Pending => 'warning',
            self::Rejected => 'danger',
        };
    }
}
