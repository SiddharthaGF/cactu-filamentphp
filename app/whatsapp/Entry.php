<?php

declare(strict_types=1);

namespace App\Whatsapp;

use App\Interfaces\Whatsapp\EntryInterface;
use App\Whatsapp\Entry\Changes;

final class Entry implements EntryInterface
{
    private int $id;
    private Changes $changes;

    public function __construct(mixed $payload)
    {
        $this->id = (int)($payload[0]['id']);
        $this->changes = new Changes($payload[0]['changes']);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function changes(): Changes
    {
        return $this->changes;
    }
}
