<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Literacy: int implements HasLabel
{
    use BaseEnum;

    case None = 1;
    case Write = 2;
    case Read = 3;
    case Both = 4;

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
