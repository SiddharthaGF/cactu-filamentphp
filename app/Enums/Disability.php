<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Disability: string implements HasLabel
{
    use BaseEnum;

    case Cognitive = 'Cognitive';
    case Physical = 'Physical';
    case Visual = 'Visual';
    case Hearing = 'Hearing';
    case Speech = 'Speech';
    case Psychosocial = 'Psychosocial';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
