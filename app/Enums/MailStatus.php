<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MailStatus: int implements HasLabel, HasColor
{
    use BaseEnum;

    case Create = 1;
    case Sent = 2;
    case Replied = 3;
    case Due = 4;

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Create => 'success',
            self::Sent => 'danger',
            self::Replied => 'warning',
            self::Due => 'primary',
        };
    }
}
