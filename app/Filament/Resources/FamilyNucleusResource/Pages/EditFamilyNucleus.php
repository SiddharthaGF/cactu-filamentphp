<?php

declare(strict_types=1);

namespace App\Filament\Resources\FamilyNucleusResource\Pages;

use App\Filament\Resources\FamilyNucleusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditFamilyNucleus extends EditRecord
{
    protected static string $resource = FamilyNucleusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
