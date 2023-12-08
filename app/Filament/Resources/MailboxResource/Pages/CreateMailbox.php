<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailboxResource\Pages;

use App\Filament\Resources\MailboxResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMailbox extends CreateRecord
{
    protected static string $resource = MailboxResource::class;
}
