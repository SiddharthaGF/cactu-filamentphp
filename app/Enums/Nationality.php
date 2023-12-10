<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Nationality: int implements HasLabel
{
    use BaseEnum;

    case Ecuadorian = 1;
    case Other = 0;

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
