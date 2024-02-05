<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BankAccountType: string implements HasLabel
{
    use BaseEnum;

    case Savings = 'Savings';
    case Checking = 'Checking';

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
