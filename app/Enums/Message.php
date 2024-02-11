<?php

declare(strict_types=1);

namespace App\Enums;

enum Message: string
{
    case HelloForChild = "Hola %pseudonym%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que tienes una nueva carta de parte de tu auspiciante.";
    case HelloForTutor = "Hola %tutor%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que %pseudonym% tiene una nueva carta de parte de tu auspiciante.";
}
