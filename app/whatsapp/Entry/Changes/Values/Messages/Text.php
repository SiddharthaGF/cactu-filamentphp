<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Messages;

use App\Interfaces\Whatsapp\Entry\Changes\Values\Messages\TextInterface;

final class Text implements TextInterface
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
