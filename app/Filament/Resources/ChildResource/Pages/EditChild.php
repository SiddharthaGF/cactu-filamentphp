<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChildResource\Pages;

use App\Enums\AffiliationStatus;
use App\Enums\StatusVigency;
use App\Filament\Resources\ChildResource;
use App\Models\Mailbox;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditChild extends EditRecord
{
    use InteractsWithMaps;

    protected static string $resource = ChildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $updated_user = $this->record;
        $current_user = $this->record->getOriginal();
        if ($updated_user->affiliation_status != $current_user['affiliation_status']) return;
        $affiliation_status = $updated_user->affiliation_status;
        switch ($affiliation_status) {
            case AffiliationStatus::Affiliated:
                $mailbox = Mailbox::find($updated_user->id);
                if ($mailbox) {
                    $mailbox->update(['vigency' => StatusVigency::Active->value]);
                } else {
                    Mailbox::create([
                        'id' => $updated_user->id,
                        'vigency' => StatusVigency::Active->value,
                        'token' => Mailbox::generateToken()
                    ]);
                }
                break;
            default:
                Mailbox::updateOrCreate(
                    ['id' => $updated_user->id],
                    ['vigency' => StatusVigency::Inactive->value]
                );
                break;
        }
    }
}
