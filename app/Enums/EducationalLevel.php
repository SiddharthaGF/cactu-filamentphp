<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EducationalLevel: int implements HasLabel
{
    use BaseEnum;

    case None = 0;
    case BasicPreparatoryEducation = 1;
    case ElementaryBasicEducation = 2;
    case MediumBasicEducation = 3;
    case HigherBasicEducation = 4;
    case Baccalaureate = 5;
    case Superior = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::None => 'None',
            self::BasicPreparatoryEducation => 'Basic Preparatory Education',
            self::ElementaryBasicEducation => 'Elementary Basic Education',
            self::MediumBasicEducation => 'Medium Basic Education',
            self::HigherBasicEducation => 'Higher Basic Education',
            self::Baccalaureate => 'Baccalaureate',
            self::Superior => 'Superior',
        };
    }
}
