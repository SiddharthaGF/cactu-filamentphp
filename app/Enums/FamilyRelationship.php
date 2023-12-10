<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FamilyRelationship: int implements HasLabel
{
    use BaseEnum;

    case FatherMother = 1;
    case GrandfatherGrandmother = 2;
    case BrotherSister = 3;
    case UncleAunt = 4;
    case Cousin = 5;
    case StepfatherStepmother = 6;
    case StepbrotherStepsister = 7;
    case Other = 0;

    public function getLabel(): string
    {
        return match ($this) {
            self::FatherMother => 'Father/Mother',
            self::GrandfatherGrandmother => 'Grandfather/Grandmother',
            self::BrotherSister => 'Brother/Sister',
            self::UncleAunt => 'Uncle/Aunt',
            self::Cousin => 'Cousin',
            self::StepfatherStepmother => 'Stepfather/Stepmother',
            self::StepbrotherStepsister => 'Stepbrother/Stepsister',
            self::Other => 'Other',
        };
    }
}
