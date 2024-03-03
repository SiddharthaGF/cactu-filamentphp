<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActivityForRecreation: int implements HasLabel
{
    use BaseEnum;

    case PlaysWithDolls = 1;
    case JumpsRope = 2;
    case PlaysBall = 3;
    case PlaysMarbles = 4;
    case PlaysHouse = 5;
    case PlaysWithCarts = 6;
    case PlaysHopscotch = 7;
    case Runs = 8;
    case PlaysWithRattles = 9;
    case PlaysHideAndSeek = 10;
    case PlaysWithFriends = 11;
    case PlaysHulaHoops = 12;
    case RidesABicycle = 13;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PlaysWithDolls => __('Plays With Dolls'),
            self::JumpsRope => __('Jumps Rope'),
            self::PlaysBall => __('Plays Ball'),
            self::PlaysMarbles => __('Plays Marbles'),
            self::PlaysHouse => __('Plays House'),
            self::PlaysWithCarts => __('Plays With Carts'),
            self::PlaysHopscotch => __('Plays Hopscotch'),
            self::Runs => __('Runs'),
            self::PlaysWithRattles => __('Plays With Rattles'),
            self::PlaysHideAndSeek => __('Plays Hide And Seek'),
            self::PlaysWithFriends => __('Plays With Friends'),
            self::PlaysHulaHoops => __('Plays Hula Hoops'),
            self::RidesABicycle => __('Rides A Bicycle'),
        };
    }
}
