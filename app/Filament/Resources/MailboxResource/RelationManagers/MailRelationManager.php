<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailBoxResource\RelationManagers;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Http\Controllers\WhatsappController;
use App\Models\Mail;
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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;

final class MailRelationManager extends RelationManager
{
    protected static string $relationship = 'mails';

    protected static function getPluralModelLabel(): ?string
    {
        return __("Mails");
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->required()
                    ->native(false)
                    ->options(MailsTypes::class),
                Select::make('status')
                    ->required()
                    ->native(false)
                    ->options(MailStatus::class),
                Repeater::make('Answers')
                    ->relationship('answers')
                    ->itemLabel('Answer')
                    ->minItems(1)
                    ->defaultItems(1)
                    ->schema([
                        Textarea::make('content')
                            ->required(),
                        FileUpload::make('attached_file_path')
                            ->downloadable()
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
                                ->url(fn(Mail $record) => route('filament.admin.resources.mails.view', $record->answer_to ?? ''))
                                ->color('info'),
                            TextEntry::make('mailbox.child.name')
                                ->color('info')
                                ->inlineLabel()
                                ->icon('heroicon-o-inbox-stack')
                                ->url(fn(Mail $record) => route('filament.admin.resources.mailboxes.edit', $record->mailbox)),
                            TextEntry::make('letter_type')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
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
                                ->color(fn(string $state): string => match ($state) {
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
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('letter_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('answer_to'),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make()
                    ->name('Notify')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->action(
                        function (Mail $record): void {
                            $mobile_number = $record->mailbox->child->mobile_number->number;
                            $pseudonym = $record->mailbox->child->pseudonym;
                            $text = "
                                Hola {$pseudonym}, te saludamos desde Cactu! 🌵😊
                                \nTe contamos que tienes una nueva carta de parte de tu auspiciente.
                            ";
                            WhatsappController::sendTextMessage($mobile_number, $text);
                            WhatsappController::sendButtonReplyMessage(
                                $mobile_number,
                                "¿Quieres leerla ahora?",
                                [
                                    new Button('ver-ahora', 'Ver ahora'),
                                ]
                            );
                        }
                    )
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
                fn(Builder $query) => $query->orderBy('id', 'desc')
            );
    }
}
