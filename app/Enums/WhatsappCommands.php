<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WhatsappCommands: string implements HasLabel
{
    use BaseEnum;

    case Greeting = '!!GREETING!!';
    case Question = '!!QUESTION!!';
    case Answer = '!!ANSWER!!';
    case Farewell = '!!FAREWELL!!';
    case ViewNow = '!!VIEW-NOW!!';
    case ViewLetter = '!!VIEW-LETTER!!';
    case ReplyNow = '!!REPLY-NOW!!';

    public function getLabel(): string
    {
        return match ($this) {
            self::Greeting => __('Greeting'),
            self::Question => __('Question'),
            self::Answer => __('Answer'),
            self::Farewell => __('Farewell'),
            self::ViewNow => __('View Now'),
            self::ViewLetter => __('View Letter'),
            self::ReplyNow => __('Reply Now'),
        };
    }
}
