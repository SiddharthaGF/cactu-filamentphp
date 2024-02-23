<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Messages;

final class Text
{
    private string $body;

    public function __construct(mixed $payload)
    {
        $this->body = $payload['body'];
    }

    public function body(): string
    {
        return $this->body;
    }
}
