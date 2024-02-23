<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Gender: int implements HasColor, HasLabel
{
    use BaseEnum;

    case Male = 1;
    case Female = 2;
    case Other = 3;

    public function getLabel(): ?string
    {
        return __($this->name);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Male => Color::Blue,
            self::Female => Color::Pink,
            self::Other => Color::Gray,
        };
    }
}
