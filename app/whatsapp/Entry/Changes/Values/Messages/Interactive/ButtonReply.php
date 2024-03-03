<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Messages\Interactive;

final class ButtonReply
{
    private string $id;

    private string $title;

    public function __construct(mixed $payload)
    {
        $this->id = $payload['id'];
        $this->title = $payload['title'];
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }
}
