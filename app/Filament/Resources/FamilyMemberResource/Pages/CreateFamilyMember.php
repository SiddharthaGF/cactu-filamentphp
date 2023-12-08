<?php

declare(strict_types=1);

namespace App\Filament\Resources\FamilyMemberResource\Pages;

use App\Filament\Resources\FamilyMemberResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;
}
