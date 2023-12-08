<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LetterResource\Pages;
use App\Models\Mail;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class MailResource extends Resource
{
    protected static ?string $model = Mail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
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
                                    ImageEntry::make('letter_photo_1_path')
                                        ->size(300),
                                    ImageEntry::make('letter_photo_2_path')
                                        ->size(300),
                                ])
                                ->icon('heroicon-o-photo')
                                ->collapsed()
                                ->columns(),
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
                    ->columns(),
            ])
            ->columns();
    }

    public static function table(Table $table): Table
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
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMail::route('/'),
            'create' => Pages\CreateMail::route('/create'),
            'view' => Pages\ViewMail::route('/{record}'),
            'edit' => Pages\EditMail::route('/{record}/edit'),
        ];
    }
}
