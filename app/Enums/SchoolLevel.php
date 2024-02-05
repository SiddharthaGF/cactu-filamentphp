<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SchoolLevel: string implements HasLabel
{
    case Initial = 'Initial';
    case Initial1 = 'Initial 1';
    case Initial2 = 'Initial 2';

    case Grade1 = '1st Grade';
    case Grade2 = '2nd Grade';
    case Grade3 = '3rd Grade';
    case Grade4 = '4th Grade';
    case Grade5 = '5th Grade';
    case Grade6 = '6th Grade';
    case Grade7 = '7th Grade';
    case Grade8 = '8th Grade';
    case Grade9 = '9th Grade';
    case Grade10 = '10th Grade';

    case Baccalaureate1 = '1st Baccalaureate';
    case Baccalaureate2 = '2nd Baccalaureate';
    case Baccalaureate3 = '3rd Baccalaureate';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Initial => __('Initial'),
            self::Initial1 => __('Initial 1'),
            self::Initial2 => __('Initial 2'),

            self::Grade1 => __('1st Grade'),
            self::Grade2 => __('2nd Grade'),
            self::Grade3 => __('3rd Grade'),
            self::Grade4 => __('4th Grade'),
            self::Grade5 => __('5th Grade'),
            self::Grade6 => __('6th Grade'),
            self::Grade7 => __('7th Grade'),
            self::Grade8 => __('8th Grade'),
            self::Grade9 => __('9th Grade'),
            self::Grade10 => __('10th Grade'),

            self::Baccalaureate1 => __('1st Baccalaureate'),
            self::Baccalaureate2 => __('2nd Baccalaureate'),
            self::Baccalaureate3 => __('3rd Baccalaureate'),
        };
    }
}
