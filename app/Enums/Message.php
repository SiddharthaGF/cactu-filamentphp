<?php

declare(strict_types=1);

namespace App\Enums;

enum Message: string
{
    case HelloForChild = "Hola %pseudonym%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que tienes una nueva carta de parte de tu auspiciante.";
    case HelloForTutor = "Hola %tutor%.\nTe saludamos desde CACTU! 🌵😊\nTe contamos que %pseudonym% tiene una nueva carta de parte de tu auspiciante.";
    case QuestionReply = "¿Deseas responder ahora? 🤔";
    case NotHaveLetter = "No tienes cartas pendientes 🫣\nTe escribiremos apenas tengamos respuestas para ti 👀";
    case ReplyNow = "¡Estupendo 😁!\nEscribe tu respuesta a continuación.";
    case ThanksForReply = "¡Gracias por tu respuesta! 🙌\nEsto eso todo por ahora.";
    case RequirePhoto = "¡Genial! 😎\nAhora envía una foto que desees compartir con tu auspiciante. 📷";
}
