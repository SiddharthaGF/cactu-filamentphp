<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Resources\Pages\CreateRecord;

final class CreateChild extends CreateRecord
{
    use InteractsWithMaps;

    protected static string $resource = ChildResource::class;
}
