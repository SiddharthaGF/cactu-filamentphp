<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values;

use App\Interfaces\Whatsapp\Entry\Changes\Values\ContactsInterface;
use App\Whatsapp\Entry\Changes\Values\Contacts\Profile;

final class Contacts implements ContactsInterface
{
    private Profile $profile;
    private int $waId;

    public function __construct(mixed $payload)
    {
        $this->profile = new Profile($payload[0]['profile']);
        $this->waId = (int)($payload[0]['wa_id']);
    }

    public function profile(): Profile
    {
        return $this->profile;
    }

    public function waId(): int
    {
        return $this->waId;
    }
}
