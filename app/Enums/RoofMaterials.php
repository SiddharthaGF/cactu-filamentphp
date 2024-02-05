<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoofMaterials: int implements HasLabel
{
    use BaseEnum;

    case Thatched = 1;
    case Shingle = 2;
    case Asbestos = 3;
    case TileZinc = 4;
    case Other = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Thatched => __('Thatched'),
            self::Shingle => __('Shingle'),
            self::Asbestos => __('Asbestos'),
            self::TileZinc => __('Tile/Zinc'),
            self::Other => __('Other'),
        };
    }
}
