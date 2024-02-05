<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MailsTypes: int implements HasLabel, HasColor
{
    use BaseEnum;

    case Initial = 1;
    case Response = 2;
    case Thanks = 3;
    case Goodbye = 4;

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Initial => 'success',
            self::Response => 'danger',
            self::Thanks => 'warning',
            self::Goodbye => 'primary',
        };
    }
}
