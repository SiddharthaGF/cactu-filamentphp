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
            self::FatherMother => __('Father/Mother'),
            self::GrandfatherGrandmother => __('Grandfather/Grandmother'),
            self::BrotherSister => __('Brother/Sister'),
            self::UncleAunt => __('Uncle/Aunt'),
            self::Cousin => __('Cousin'),
            self::StepfatherStepmother => __('Stepfather/Stepmother'),
            self::StepbrotherStepsister => __('Stepbrother/Stepsister'),
            self::Other => __('Other'),
        };
    }
}
