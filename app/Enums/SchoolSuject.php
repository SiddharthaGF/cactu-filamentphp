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
    case Computing = 'Computing';
    case English = 'English';
    case History = 'History';
    case Geography = 'Geography';
    case None = 'None';
}
