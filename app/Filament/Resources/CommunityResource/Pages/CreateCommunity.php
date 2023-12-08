<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityResource\Pages;

use App\Filament\Resources\CommunityResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCommunity extends CreateRecord
{
    protected static string $resource = CommunityResource::class;
}
