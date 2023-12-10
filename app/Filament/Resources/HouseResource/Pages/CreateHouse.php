<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseResource\Pages;

use App\Filament\Resources\HouseResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Resources\Pages\CreateRecord;

final class CreateHouse extends CreateRecord
{
    use InteractsWithMaps;

    protected static string $resource = HouseResource::class;
}
