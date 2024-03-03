<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MailsTypes: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Initial = 1;
    case Response = 2;
    case Thanks = 3;
    case Goodbye = 4;

    public function getLabel(): ?string
    {
        return __($this->name);
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Initial => 'gray',
            self::Response => 'success',
            self::Thanks => 'primary',
            self::Goodbye => 'danger',
        };
    }
}
