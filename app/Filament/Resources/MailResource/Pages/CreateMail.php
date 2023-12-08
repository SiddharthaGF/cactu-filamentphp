<?php

declare(strict_types=1);

namespace App\Filament\Resources\LetterResource\Pages;

use App\Filament\Resources\MailResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMail extends CreateRecord
{
    protected static string $resource = MailResource::class;
}
