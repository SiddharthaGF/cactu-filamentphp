<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FinancialInstitutionType: int implements HasLabel
{
    use BaseEnum;

    case Bank = 1;
    case Cooperative = 2;
    case Mutuality = 3;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
