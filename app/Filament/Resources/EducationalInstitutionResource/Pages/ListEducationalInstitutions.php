<?php

declare(strict_types=1);

namespace App\Filament\Resources\EducationalInstitutionResource\Pages;

use App\Filament\Resources\EducationalInstitutionResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListEducationalInstitutions extends ListRecords
{
    use InteractsWithMaps;

    protected static string $resource = EducationalInstitutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
