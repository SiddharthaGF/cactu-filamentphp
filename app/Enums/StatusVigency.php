<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusVigency: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Active = 1;
    case Inactive = 0;

    public function getLabel(): ?string
    {
        return __($this->name);
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
        };
    }
}
