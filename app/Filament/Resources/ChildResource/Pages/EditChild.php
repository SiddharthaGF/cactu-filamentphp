<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChildResource\Pages;

use App\Enums\AffiliationStatus;
use App\Enums\StatusVigency;
use App\Filament\Resources\ChildResource;
use App\Models\Child;
use App\Models\Mailbox;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;
use Filament\Actions;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

final class EditChild extends EditRecord
{
    use InteractsWithMaps;

    protected static string $resource = ChildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('transfer_child')
                ->color(Color::Amber)
                ->translateLabel()
                ->form([
                    Radio::make('choice')
                        ->translateLabel()
                        ->default(1)
                        ->options([
                            1 => __('Just the boy'),
                            2 => __('With the family'),
                        ])
                        ->required(),
                    Select::make('manager_id')
                        ->label('New manager in charge')
                        ->required()
                        ->translateLabel()
                        ->native(false)
                        ->dehydrated()
                        ->options(fn () => User::where('id', '!=', auth()->user()->id)->byRole('gestor')->pluck('name', 'id')),
                ])
                ->action(function (array $data, Child $record): void {
                    try {
                        $opc = intval($data['choice']);
                        $manager_id = intval($data['manager_id']);
                        $record->manager_id = $manager_id;
                        $record->updated_by = $manager_id;
                        if ($opc === 1) {
                            $record->family_nucleus_id = null;
                        } else if ($opc === 2) {
                            $record->family_nucleus->updated_by = $manager_id;
                            $record->family_nucleus->tutors->each(function ($tutor) use ($manager_id) {
                                $tutor->updated_by = $manager_id;
                                $tutor->save();
                            });
                            $record->family_nucleus->family_members->each(
                                function ($member) use ($manager_id) {
                                    $member->updated_by = $manager_id;
                                    $member->save();
                                }
                            );
                            $record->family_nucleus->save();
                        }
                        $record->mailbox->each(
                            function ($mailbox) use ($manager_id) {
                                $mailbox->updated_by = $manager_id;
                                $mailbox->save();
                            }
                        );
                        $record->save();
                        Notification::make()
                            ->title(__('Child successfully transferred'))
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(__('Child could not be transferred'))
                            ->error()
                            ->send();
                    }
                    redirect(ChildResource::getUrl('index'));
                }),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $updated_user = $this->record;
        $current_user = $this->record->getOriginal();
        if ($updated_user->affiliation_status !== $current_user['affiliation_status']) {
            return;
        }
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
