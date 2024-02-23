<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SexualIdentity: int implements HasLabel
{
    use BaseEnum;

    case Boy = 2;
    case Girl = 1;
    case Other = 3;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
