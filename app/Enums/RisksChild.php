<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RisksChild: int implements HasLabel
{
    use BaseEnum;

    case DoesNotGoToSchool = 1;
    case IsAloneAtHome = 2;
    case Works = 3;
    case TakesCareOfSiblings = 4;
    case HasADangerousJob = 5;
    case CooksAline = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DoesNotGoToSchool => __('Doesn\'t Go To School'),
            self::IsAloneAtHome => __('Is Alone At Home'),
            self::Works => __('Works'),
            self::TakesCareOfSiblings => __('Takes Care Of Siblings'),
            self::HasADangerousJob => __('Has A Dangerous Job'),
            self::CooksAline => __('Cooks Aline'),
        };
    }
}
