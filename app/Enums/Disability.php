<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Disability: int implements HasLabel
{
    use BaseEnum;

    case Cognitive = 1;
    case Physical = 2;
    case Visual = 3;
    case Hearing = 4;
    case Speech = 5;
    case Psychosocial = 6;

    public function getLabel(): ?string
    {
        return __($this->name);
    }
}
