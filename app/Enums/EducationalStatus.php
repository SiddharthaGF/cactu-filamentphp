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
            self::Kindergarten => 'Kindergarten (CHN, CDI another type of children\'s center)',
            self::InitialEducation => 'Initial education (sub-level: initial 1, initial 2)',
            self::BasicGeneralEducation => 'Basic general education (1-10)',
            self::UnifiedGeneralBaccalaureate => 'Unified General Baccalaureate (1-3)',
        };
    }
}
