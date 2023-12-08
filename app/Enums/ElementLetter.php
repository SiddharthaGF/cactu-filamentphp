<?php

namespace App\Enums;

enum ElementLetter: string
{
    use BaseEnum;

    case Greeting = 'greeting';
    case Question = 'question';
    case Answer = 'answer';
    case Farewell = 'farewell';

}
