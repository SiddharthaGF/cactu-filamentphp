<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Messages;

use App\Whatsapp\Entry\Changes\Values\Messages\Interactive\ButtonReply;

final class Interactive
{
    private string $type;

    private ButtonReply $buttonReply;

    public function __construct(mixed $payload)
    {
        $this->type = $payload['type'];
        $this->buttonReply = new ButtonReply($payload['button_reply']);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function buttonReply(): ButtonReply
    {
        return $this->buttonReply;
    }
}
