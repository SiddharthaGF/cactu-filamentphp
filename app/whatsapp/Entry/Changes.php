<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry;

use App\Whatsapp\Entry\Changes\Value;

final class Changes
{
    private Value $value;

    private string $field;

    public function __construct(mixed $payload)
    {
        $this->field = $payload[0]['field'];
        $this->value = new Value($payload[0]['value']);
    }

    public function value(): Value
    {
        return $this->value;
    }

    public function field(): string
    {
        return $this->field;
    }
}
