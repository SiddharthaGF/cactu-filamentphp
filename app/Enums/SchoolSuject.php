<?php

declare(strict_types=1);

namespace App\Enums;

enum SchoolSuject: string
{
    case Math = 'Math';
    case Chemistry = 'Chemistry';
    case Physics = 'Physics';
    case Biology = 'Biology';
    case Social = 'Social';
    case Arts = 'Arts';
    case Lenguage = 'Lenguage';
    case Computing = 'Computing';
    case English = 'English';
    case History = 'History';
    case Geography = 'Geography';
    case None = 'None';

    public static function getTranslatedLevels(): array
    {
        return [
            __(self::Math->value),
            __(self::Chemistry->value),
            __(self::Physics->value),
            __(self::Biology->value),
            __(self::Social->value),
            __(self::Lenguage->value),
            __(self::Arts->value),
            __(self::Computing->value),
            __(self::English->value),
            __(self::History->value),
            __(self::Geography->value),
            __(self::None->value),
        ];
    }
}
