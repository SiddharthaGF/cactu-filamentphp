<?php

declare(strict_types=1);

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditTutor extends EditRecord
{
    protected static string $resource = TutorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave() : void {
        if ($this->record->is_present) {
            $this->record->reason_not_present = null;
            $this->record->specific_reason = null;
            $this->record->deathdate = null;
        } else {
            $this->record->occupation = null;
            $this->record->specific_occupation = null;
            $this->record->salary = null;
        }
    }

}
