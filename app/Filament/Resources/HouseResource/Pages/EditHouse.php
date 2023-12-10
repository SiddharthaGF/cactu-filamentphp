<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseResource\Pages;

use App\Filament\Resources\HouseResource;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditHouse extends EditRecord
{
    use InteractsWithMaps;

    protected static string $resource = HouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
