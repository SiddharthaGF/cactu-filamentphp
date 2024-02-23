<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailBoxResource\RelationManagers;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Models\Mail;
use Exception;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
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
                    ->disabled(fn(Mail $record) => MailStatus::IsResponse === $record->status)
                    ->required()
                    ->native(false)
                    ->options(MailsTypes::class)
                    ->default(MailsTypes::Response),
                Select::make('status')
                    ->disabled(fn(Mail $record) => MailStatus::IsResponse === $record->status)
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
                        fn(Mail $record) => match ($record->status) {
                            MailStatus::IsResponse => 1,
                            default => 10,
                        }
                    )
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('content')
                            ->translateLabel()
                            ->rows(20)
                            ->required(),
                        FileUpload::make('attached_file_path')
                            ->translateLabel()
                            ->preserveFilenames()
                            ->downloadable()
                            ->required()
                            ->image(),
                    ]),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema(
                        [
                            TextEntry::make('id')
                                ->inlineLabel()
                                ->icon('heroicon-o-identification')
                                ->label('Mail Nro'),
                            TextEntry::make('answer_to')
                                ->inlineLabel()
                                ->icon('heroicon-o-identification')
                                ->label('Replies to letter')
                                ->url(fn (Mail $record) => route('filament.admin.resources.mails.view', $record->answer_to ?? ''))
                                ->color('info'),
                            TextEntry::make('mailbox.child.name')
                                ->color('info')
                                ->inlineLabel()
                                ->icon('heroicon-o-inbox-stack')
                                ->url(fn (Mail $record) => route('filament.admin.resources.mailboxes.edit', $record->mailbox)),
                            TextEntry::make('letter_type')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'initial' => 'gray',
                                    'response' => 'info',
                                    'thanks' => 'success',
                                    'goodbye' => 'danger',
                                })
                                ->inlineLabel(),
                            IconEntry::make('child_is_author')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-badge')
                                ->falseIcon('heroicon-o-x-mark')
                                ->inlineLabel(),
                            TextEntry::make('status')
                                ->color(fn (string $state): string => match ($state) {
                                    'create' => 'gray',
                                    'sent' => 'info',
                                    'replied' => 'success',
                                    'due' => 'danger',
                                })
                                ->badge()
                                ->inlineLabel(),
                            TextEntry::make('answer')
                                ->color('primary')
                                ->html()
                                ->inlineLabel()
                                ->icon('heroicon-o-chat-bubble-bottom-center-text'),
                            Section::make('Photos')
                                ->schema([
                                    ImageEntry::make('letter_photo_1_path'),
                                    ImageEntry::make('letter_photo_2_path'),
                                ])
                                ->icon('heroicon-o-photo')
                                ->collapsed()
                                ->columns(2),
                            TextEntry::make('creator.name')
                                ->color('gray')
                                ->inlineLabel()
                                ->icon('heroicon-o-user'),
                            TextEntry::make('created_at')
                                ->color('gray')
                                ->dateTime()
                                ->inlineLabel()
                                ->icon('heroicon-o-calendar-days'),
                            TextEntry::make('updater.name')
                                ->color('gray')
                                ->inlineLabel()
                                ->icon('heroicon-o-user'),
                            TextEntry::make('updated_at')
                                ->color('gray')
                                ->dateTime()
                                ->inlineLabel()
                                ->icon('heroicon-o-calendar-days'),
                        ]
                    )
                    ->columns(2),
            ])
            ->columns(2);
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
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make()
                    ->name('Notify')
                    ->color(Color::Green)
                    ->translateLabel()
                    ->hidden(fn(Mail $record) => MailStatus::IsResponse === $record->status)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->action(function (Mail $record): void {
                        try {
                            $record->mailbox->child->NotifyMails($record->id);
                            Notification::make()
                                ->title(__("Sent to whatsapp successfully"))
                                ->success()
                                ->send();
                            $record->update(["status" => MailStatus::Sent]);
                        } catch (Exception $e) {
                            Notification::make()
                                ->title(__("Error sending to whatsapp"))
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])

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
        return __("Mails");
    }
}
