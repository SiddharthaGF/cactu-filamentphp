<?php

declare(strict_types=1);

namespace App\Enums;

enum SchoolLevel: string
{
    case Initial = 'Initial';
    case Initial1 = 'Initial 1';
    case Initial2 = 'Initial 2';

    case Grade1 = '1st Grade';
    case Grade2 = '2nd Grade';
    case Grade3 = '3rd Grade';
    case Grade4 = '4th Grade';
    case Grade5 = '5th Grade';
    case Grade6 = '6th Grade';
    case Grade7 = '7th Grade';
    case Grade8 = '8th Grade';
    case Grade9 = '9th Grade';
    case Grade10 = '10th Grade';

    case Baccalaureate1 = '1st Baccalaureate';
    case Baccalaureate2 = '2nd Baccalaureate';
    case Baccalaureate3 = '3rd Baccalaureate';
}
