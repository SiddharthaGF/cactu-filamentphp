<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Location: int implements HasLabel
{
    use BaseEnum;

    case Urban = 1;
    case Periurban = 2;
    case Rural = 3;
    case Other = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Urban => __('Urban'),
            self::Periurban => __('Periurban'),
            self::Rural => __('Rural'),
            self::Other => __('Other'),
        };
    }
}
