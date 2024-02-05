<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MigratoryStatus: int implements HasLabel
{
    use BaseEnum;

    case None = 1;
    case Migrant = 2;
    case Refugee = 3;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
