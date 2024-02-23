<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values;

use App\Whatsapp\Entry\Changes\Values\Messages\Image;
use App\Whatsapp\Entry\Changes\Values\Messages\Interactive;
use App\Whatsapp\Entry\Changes\Values\Messages\Text;
use Throwable;

final class Messages
{
    private string $from;
    private string $id;
    private int $timestamp;
    private Messages\Text|null $text;
    private string $type;
    private Messages\Image|null $image;
    private Messages\Interactive|null $interactive;

    public function __construct(mixed $payload)
    {
        $payload = $payload[0];
        $this->from = $payload['from'];
        $this->id = $payload['id'];
        $this->timestamp = (int)($payload['timestamp']);
        try {
            $this->text = new Text($payload['text']);
        } catch (Throwable) {
            $this->text = null;
        }
        $this->type = $payload['type'];
        try {
            $this->image = new Image($payload['image']);
        } catch (Throwable) {
            $this->image = null;
        }
        try {
            $this->interactive = new Interactive($payload['interactive']);
        } catch (Throwable) {
            $this->interactive = null;
        }
    }

    public function from(): string
    {
        return $this->from;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function timestamp(): int
    {
        return $this->timestamp;
    }

    public function text(): Text|null
    {
        return $this->text;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function image(): Image|null
    {
        return $this->image;
    }

    public function interactive(): Interactive|null
    {
        return $this->interactive;
    }
}
