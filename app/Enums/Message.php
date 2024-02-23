<?php

declare(strict_types=1);

namespace App\Enums;

enum Message: string
{
    case HelloForChild = "Hola %pseudonym%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que tienes una nueva carta de parte de tu auspiciante.";
    case HelloForTutor = "Hola %tutor%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que %pseudonym% tiene una nueva carta de parte de tu auspiciante.";
    case QuestionReply = "¿Deseas responder ahora? 🤔";
    case NotHaveLetter = "Por el momento no tienes cartas pendientes. 😊";
<<<<<<< HEAD
    case ReplyNow = "¡Estupendo 😁!\nEscribe tu respuesta a continuación.";
=======
    case ReplyNow = "¡Estupendo! 😊 Escribe tu respuesta a continuación.\nEsta es la carta Nro. %id%.";
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    case ThanksForReply = "¡Gracias por tu respuesta! 😊\nEsto eso todo por ahora.";
}
