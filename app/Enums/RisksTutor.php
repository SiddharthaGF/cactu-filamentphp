<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RisksTutor: string implements HasLabel
{
    use BaseEnum;

    case Disability = 'Disability';
    case Absent = 'Absent';
    case Disease = 'Disease';
    case Jobless = 'Jobless';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
