<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes;

use App\Whatsapp\Entry\Changes\Values\Contacts;
use App\Whatsapp\Entry\Changes\Values\Messages;
use App\Whatsapp\Entry\Changes\Values\Metadata;

final class Value
{
    private string $messagingProduct;
    private Metadata $metadata;
    private Contacts $contacts;
    private Messages $messages;

    public function __construct(mixed $payload)
    {
        $this->messagingProduct = $payload['messaging_product'];
        $this->metadata = new Metadata($payload['metadata']);
        $this->contacts = new Contacts($payload['contacts']);
        $this->messages = new Messages($payload['messages']);
    }

    public function messagingProduct(): string
    {
        return $this->messagingProduct;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }

    public function contacts(): Contacts
    {
        return $this->contacts;
    }

    public function messages(): Messages
    {
        return $this->messages;
    }
}
