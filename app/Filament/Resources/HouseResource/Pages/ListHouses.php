<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseResource\Pages;

use App\Filament\Resources\HouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListHouses extends ListRecords
{
    protected static string $resource = HouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
