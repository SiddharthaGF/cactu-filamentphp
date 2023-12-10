<?php

declare(strict_types=1);

namespace App\Filament\Resources\BankingInformationResource\Pages;

use App\Filament\Resources\BankingInformationResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBankingInformation extends CreateRecord
{
    protected static string $resource = BankingInformationResource::class;
}
