<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Language: int implements HasLabel
{
    use BaseEnum;

    case Spanish = 1;
    case Quechua = 2;
    case Other = 3;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
