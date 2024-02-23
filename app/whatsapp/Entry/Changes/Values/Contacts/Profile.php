<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Contacts;

use App\Interfaces\Whatsapp\Entry\Changes\Values\Contacts\ProfileInterface;

final class Profile implements ProfileInterface
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
