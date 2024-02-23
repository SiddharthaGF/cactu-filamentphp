<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BankAccountType: int implements HasLabel
{
    use BaseEnum;

    case Savings = 1;
    case Checking = 2;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
