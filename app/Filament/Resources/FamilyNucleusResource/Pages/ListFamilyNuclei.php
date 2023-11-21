<?php

namespace App\Filament\Resources\FamilyNucleusResource\Pages;

use App\Filament\Resources\FamilyNucleusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyNuclei extends ListRecords
{
    protected static string $resource = FamilyNucleusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
