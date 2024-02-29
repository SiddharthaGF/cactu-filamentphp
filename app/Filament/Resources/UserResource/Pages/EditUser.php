<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

final class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Disable 2FA')
                ->label('Disable 2FA')
                ->icon('heroicon-m-lock-open')
                ->translateLabel()
                ->color(Color::Emerald)
                ->visible(fn () => $this->record->hasEnabledTwoFactor())
                ->action(fn () => $this->record->disableTwoFactorAuthentication())
                ->requiresConfirmation(),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
