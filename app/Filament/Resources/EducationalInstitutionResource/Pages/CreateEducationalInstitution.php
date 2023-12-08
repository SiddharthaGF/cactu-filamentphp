<?php

declare(strict_types=1);

namespace App\Filament\Resources\EducationalInstitutionResource\Pages;

use App\Filament\Resources\EducationalInstitutionResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Resources\Pages\CreateRecord;

final class CreateEducationalInstitution extends CreateRecord
{
    use InteractsWithMaps;

    protected static string $resource = EducationalInstitutionResource::class;
}
