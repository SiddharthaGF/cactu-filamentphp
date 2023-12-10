<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HealthStatus: int implements HasLabel
{
    use BaseEnum;

    case Excellent = 1;
    case Good = 2;
    case HasProblems = 3;
    case NotSpecific = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NotSpecific => 'Not specific',
            self::Good => 'Good',
            self::Excellent => 'Excellent',
            self::HasProblems => 'Has problems',
        };
    }
}
