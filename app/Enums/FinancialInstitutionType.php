<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FinancialInstitutionType: string implements HasLabel
{
    use BaseEnum;

    case Bank = 'Bank';
    case Cooperative = 'Cooperative';
    case Mutuality = 'Mutuality';

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
