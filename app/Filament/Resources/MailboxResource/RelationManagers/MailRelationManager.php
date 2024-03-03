<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailBoxResource\RelationManagers;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Models\Mail;
use Exception;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class MailRelationManager extends RelationManager
{
    protected static string $relationship = 'mails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->translateLabel()
                    ->disabled(function (?Mail $record, string $context) {
                        $status = $record ? $record->status : null;

                        return $status === MailStatus::Response && $context == 'edit';
                    })
                    ->required()
                    ->native(false)
                    ->options(MailsTypes::class)
                    ->default(MailsTypes::Response),
                Select::make('status')
                    ->disabled(function (?Mail $record, string $context) {
                        $status = $record ? $record->status : null;

                        return $status === MailStatus::Response && $context == 'edit';
                    })
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->options(MailStatus::class)
                    ->default(MailStatus::Created),
                Repeater::make('Answers')
                    ->translateLabel()
                    ->relationship('answers')
                    ->required()
                    ->minItems(1)
                    ->maxItems(
                        function (?Mail $record, string $context) {
                            $status = $record ? $record->status : null;

                            return match ($status) {
                                MailStatus::Response => 1,
                                default => 10,
                            };
                        })
                    ->deletable(
                        function (?Mail $record, string $context) {
                            $status = $record ? $record->status : null;
                            if ($context == 'create') {
                                return true;
                            }

                            return $status !== MailStatus::Response;
                        })
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('content')
                            ->translateLabel()
                            ->rows(20)
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('attached_file_path')
                            ->image()
                            ->translateLabel()
                            ->imageEditor()
                            ->downloadable()
                            ->required()
                            ->maxFiles(1)
                            ->collection('answers'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\IconColumn::make('reply_mail_id')
                    ->label('')
                    ->translateLabel()
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-down-left')
                    ->falseIcon('heroicon-o-arrow-up-right')
                    ->alignCenter()
                    ->color(Color::Green),
            ])
            ->filters([
                SelectFilter::make('Author')
                    ->options([
                        true => 'Child',
                        false => 'Sponsor',
                    ])
                    ->attribute('child_is_author'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make()
                    ->name('Notify')
                    ->color(Color::Green)
                    ->translateLabel()
                    ->hidden(fn (Mail $record) => $record->status === MailStatus::Response)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->action(function (Mail $record): void {
                        try {
                            $record->mailbox->child->NotifyMails($record->id);
                            Notification::make()
                                ->title(__('Sent to whatsapp successfully'))
                                ->success()
                                ->send();
                            $record->update(['status' => MailStatus::Sent]);
                        } catch (Exception $e) {
                            Notification::make()
                                ->title(__('Error sending to whatsapp'))
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->modifyQueryUsing(
                fn (Builder $query) => $query->orderBy('id', 'desc')
            );
    }

    protected static function getPluralModelLabel(): ?string
    {
        return __('Mails');
    }
}
