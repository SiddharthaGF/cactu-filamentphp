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
            self::NotSpecific => __('Not specific'),
            self::Good => __('Good'),
            self::Excellent => __('Excellent'),
            self::HasProblems => __('Has problems'),
        };
    }
}
