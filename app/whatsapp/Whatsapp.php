<?php

declare(strict_types=1);

namespace App\Whatsapp;

final class Whatsapp
{
    private string $object;

    private Entry $entry;

    public function __construct(mixed $json)
    {
        $this->object = $json['object'];
        $this->entry = new Entry($json['entry']);
    }

    public function object(): string
    {
        return $this->object;
    }

    public function entry(): Entry
    {
        return $this->entry;
    }
}
