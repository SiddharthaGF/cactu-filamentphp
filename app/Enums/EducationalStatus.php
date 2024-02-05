<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EducationalStatus: int implements HasLabel
{
    use BaseEnum;

    case Kindergarten = 1;
    case InitialEducation = 2;
    case BasicGeneralEducation = 3;
    case UnifiedGeneralBaccalaureate = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Kindergarten => __('Kindergarten (CHN, CDI or another type of children\'s center)'),
            self::InitialEducation => __('Initial education (sub-level: initial 1, initial 2)'),
            self::BasicGeneralEducation => __('Basic general education (1-10)'),
            self::UnifiedGeneralBaccalaureate => __('Unified General Baccalaureate (1-3)'),
        };
    }
}
