<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RisksChild: string implements HasLabel
{
    use BaseEnum;

    case DoesNotGoToSchool = 'Doesn\'t Go To School';
    case IsAloneAtHome = 'Is Alone At Home';
    case Works = 'Works';
    case TakesCareOfSiblings = 'Takes Care Of Siblings';
    case HasADangerousJob = 'Has A Dangerous Job';
    case CooksAline = 'Cooks Aline';

    public function getLabel(): ?string
    {
        return __($this->value);
    }
}
