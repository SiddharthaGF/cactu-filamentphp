<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MailStatus: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Created = 1;
    case Sent = 2;
    case View = 3;
    case Replied = 4;
    case Expired = 5;
    case Response = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Created => __('Created'),
            self::Sent => __('Sent'),
            self::View => __('View'),
            self::Replied => __('Replied'),
            self::Expired => __('Expired'),
            self::Response => __('Es Respuesta'),
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::Created => 'success',
            self::Sent => 'primary',
            self::View => 'info',
            self::Replied => 'warning',
            self::Expired => 'gray',
            self::Response => 'primary',
        };
    }
}
