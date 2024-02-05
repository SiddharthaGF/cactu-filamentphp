<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StatusVigency;
use App\Filament\Resources\MailboxResource\Pages;
use App\Filament\Resources\MailboxResource\RelationManagers;
use App\Models\Mailbox;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class MailboxResource extends Resource
{
    protected static ?string $model = Mailbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getLabel(): ?string
    {
        return __("Mailbox");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Mailboxes");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id')
                    ->searchable()
                    ->preload()
                    ->relationship('child', 'name')
                    ->required()
                    ->native(false)
                    ->disabled(),
                Select::make('vigency')
                    ->options(StatusVigency::class)
                    ->native(false)
                    ->required(),
                TextInput::make('token')
                    ->required()
                    ->disabled()
                    ->prefix(route('chat', '') . '/')
                    ->prefixAction(
                        Action::make('Visit mailbox')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->url(fn(Mailbox $record) => route('chat', $record->token ?? ''))
                            ->openUrlInNewTab(),
                    )
                    ->suffixActions(
                        [
                            Action::make('Create new token')
                                ->icon('heroicon-m-arrow-path')
                                ->requiresConfirmation()
                                ->action(
                                    function (Mailbox $record, Set $set): void {
                                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                        $new_token = mb_substr(str_shuffle($characters), 0, 15);
                                        $set('token', $new_token);
                                        $record->token = $new_token;
                                        $record->save();
                                    }
                                ),
                        ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('child.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vigency')
                    ->badge(),
                TextColumn::make('token')
                    ->url(fn(Mailbox $record) => route('chat', $record->token ?? ''))
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-arrow-top-right-on-square'),
            ])
            ->filters([])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                //Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MailRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMailboxes::route('/'),
            //'create' => Pages\CreateMailbox::route('/create'),
            'edit' => Pages\EditMailbox::route('/{record}/edit'),
        ];
    }
}
