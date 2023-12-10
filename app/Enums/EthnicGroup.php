<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EthnicGroup: int implements HasLabel
{
    use BaseEnum;

    case AfroEcuadorian = 1;
    case Indigenous = 2;
    case Mestizo = 3;
    case Other = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AfroEcuadorian => 'Afro-ecuadorian',
            self::Indigenous => 'Indigenous',
            self::Mestizo => 'Mestizo',
            self::Other => 'Other',
        };
    }
}
