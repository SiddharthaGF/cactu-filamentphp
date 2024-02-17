<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MailStatus: int implements HasLabel, HasColor
{
    use BaseEnum;

    case Created = 1;
    case Sent = 2;
    case View = 3;
    case Replied = 4;
    case Expired = 5;
    case IsResponse = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Created => 'Creado',
            self::Sent => 'Enviado',
            self::View => 'Visto',
            self::Replied => 'Respondido',
            self::Expired => 'Expirado',
            self::IsResponse => 'Es Respuesta',
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
            self::IsResponse => 'primary',
        };
    }
}
