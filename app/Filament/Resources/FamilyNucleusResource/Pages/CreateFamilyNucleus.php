<?php

declare(strict_types=1);

namespace App\Filament\Resources\FamilyNucleusResource\Pages;

use App\Filament\Resources\FamilyNucleusResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateFamilyNucleus extends CreateRecord
{
    protected static string $resource = FamilyNucleusResource::class;
}
