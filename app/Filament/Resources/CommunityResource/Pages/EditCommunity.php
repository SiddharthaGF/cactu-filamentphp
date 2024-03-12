<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityResource\Pages;

use App\Filament\Resources\CommunityResource;
use App\Models\CommunityManager;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditCommunity extends EditRecord
{
    protected static string $resource = CommunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
