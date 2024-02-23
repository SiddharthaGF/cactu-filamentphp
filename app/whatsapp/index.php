<?php

interface EntryInterface {
  public function id(): string;
  public function changes(): ChangesInterface;
}

interface ChangesInterface {
  public function value(): ValueInterface;
  public function field(): string;
}

interface ValueInterface
{
    public function messagingProduct(): string;
    public function metadata(): MetadataInterface;
    public function contacts(): ContactsInterface;
    public function messages(): MessagesInterface;
}

interface MetadataInterface
{
    public function displayPhoneNumber(): string;
    public function phoneNumberId(): string;
}

interface ContactsInterface
{
    public function profile(): ProfileInterface;
    public function waId(): string;
}

interface ProfileInterface
{
    public function name(): string;
}

interface MessagesInterface
{
    public function from(): string;
    public function id(): string;
    public function timestamp(): string;
    public function text(): TextInterface;
    public function type(): string;
    public function image(): ImageInterface;
}

interface TextInterface
{
    public function body(): string;
}

interface ImageInterface
{
    public function mimeType(): string;
    public function sha256(): string;
    public function id(): string;
}

final class whatsapp
{
  public string $object;
  public Entry $entry;

  public function __construct(string $object, Entry $entry)
  {
    $this->object = $object;
    $this->entry = $entry;
  }
}

final class Entry implements EntryInterface
{
  private  string $id;
  private  Changes $changes;

  public function __construct(string $id, Changes $changes)
  {
    $this->id = $id;
    $this->changes = $changes;
  }

  public function id(): string
  {
    return $this->id;
  }

  public function changes(): Changes
  {
    return $this->changes;
  }

}

final class Changes implements ChangesInterface
{
  private  Value $value;
  private  string $field;

  public function __construct(Value $value, string $field)
  {
    $this->value = $value;
    $this->field = $field;
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

final class Value implements ValueInterface
{
  private  string $messagingProduct;
  private  Metadata $metadata;
  private  Contacts $contacts;
  private  Messages $messages;

  public function __construct(
    string $messagingProduct,
    Metadata $metadata,
    Contacts $contacts,
    Messages $messages
  ) {
    $this->messagingProduct = $messagingProduct;
    $this->metadata = $metadata;
    $this->contacts = $contacts;
    $this->messages = $messages;
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

final class Metadata implements MetadataInterface
{
  private string $displayPhoneNumber;
  private string $phoneNumberId;

  public function __construct(string $displayPhoneNumber, string $phoneNumberId)
  {
    $this->displayPhoneNumber = $displayPhoneNumber;
    $this->phoneNumberId = $phoneNumberId;
  }

  public function displayPhoneNumber(): string
  {
    return $this->displayPhoneNumber;
  }

  public function phoneNumberId(): string
  {
    return $this->phoneNumberId;
  }
}

final class Contacts implements ContactsInterface
{
  private Profile $profile;
  private string $waId;

  public function __construct(ProfileInterface $profile, string $waId)
  {
    $this->profile = $profile;
    $this->waId = $waId;
  }

  public function profile(): Profile
  {
    return $this->profile;
  }

  public function waId(): string
  {
    return $this->waId;
  }
}

final class Profile implements ProfileInterface
{
  private string $name;

  public function __construct(string $name)
  {
    $this->name = $name;
  }

  public function name(): string
  {
    return $this->name;
  }
}

final class Messages implements MessagesInterface
{
  private string $from;
  private string $id;
  private string $timestamp;
  private string $type;
  private Text $text;
  private Image $image;

  public function __construct(
    string $from,
    string $id,
    string $timestamp,
    string $type,
    Text $text,
    Image $image
  ) {
    $this->from = $from;
    $this->id = $id;
    $this->timestamp = $timestamp;
    $this->type = $type;
    $this->text = $text;
    $this->image = $image;
  }

  public function from(): string
  {
    return $this->from;
  }

  public function id(): string
  {
    return $this->id;
  }

  public function timestamp(): string
  {
    return $this->timestamp;
  }

  public function type(): string
  {
    return $this->type;
  }

  public function text(): Text
  {
    return $this->text;
  }

  public function image(): Image
  {
    return $this->image;
  }
}

final class Text implements TextInterface
{
  private string $body;

  public function __construct(string $body)
  {
    $this->body = $body;
  }

  public function body(): string
  {
    return $this->body;
  }
}

final class Image implements ImageInterface
{
  private string $mimeType;
  private string $sha256;
  private string $id;

  public function __construct(string $mimeType, string $sha256, string $id)
  {
    $this->mimeType = $mimeType;
    $this->sha256 = $sha256;
    $this->id = $id;
  }

  public function mimeType(): string
  {
    return $this->mimeType;
  }

  public function sha256(): string
  {
    return $this->sha256;
  }

  public function id(): string
  {
    return $this->id;
  }
}


$wpp = new whatsapp();

$wpp->entry->changes();