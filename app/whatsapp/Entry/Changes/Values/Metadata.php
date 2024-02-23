<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values;

use App\Interfaces\Whatsapp\Entry\Changes\Values\MetadataInterface;

final class Metadata implements MetadataInterface
{
    private string $displayPhoneNumber;
    private int $phoneNumberId;

    public function __construct(mixed $payload)
    {
        $this->displayPhoneNumber = $payload['display_phone_number'];
        $this->phoneNumberId = (int)($payload['phone_number_id']);
    }

    public function displayPhoneNumber(): string
    {
        return $this->displayPhoneNumber;
    }

    public function phoneNumberId(): int
    {
        return $this->phoneNumberId;
    }
}
