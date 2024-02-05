<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ActivityForFamilySupport: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Affiliated = 1;
    case Disaffiliated = 2;
    case Pending = 3;
    case Rejected = 4;

    public function getLabel(): ?string
    {
        return __($this->name);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Affiliated => 'success',
            self::Disaffiliated => 'gray',
            self::Pending => 'warning',
            self::Rejected => 'danger',
        };
    }
}
