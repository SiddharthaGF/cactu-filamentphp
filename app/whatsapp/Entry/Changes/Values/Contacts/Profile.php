<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Contacts;

final class Profile
{
    private string $name;

    public function __construct(mixed $payload)
    {
        $this->name = $payload['name'];
    }

    public function name(): string
    {
        return $this->name;
    }
}
