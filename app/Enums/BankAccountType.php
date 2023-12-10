<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BankAccountType: string implements HasLabel
{
    use BaseEnum;

    case Savings = 'Savings';
    case Current = 'Current';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
