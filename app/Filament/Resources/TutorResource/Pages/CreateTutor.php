<?php

declare(strict_types=1);

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTutor extends CreateRecord
{
    protected static string $resource = TutorResource::class;
}
