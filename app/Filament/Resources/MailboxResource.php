<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Builder\RecordBuilder;
use App\Enums\StatusVigency;
use App\Filament\Resources\MailboxResource\Pages;
use App\Filament\Resources\MailboxResource\RelationManagers;
use App\Models\Mailbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class MailboxResource extends Resource
{
    protected static ?string $model = Mailbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static int $globalSearchResultsLimit = 3;

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->child->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['child.name', 'child.dni', 'child.children_number', 'child.case_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('Vigency') => $record->vigency->getLabel(),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('Mailbox');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Mailboxes');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id')
                    ->translateLabel()
                    ->searchable()
                    ->preload()
                    ->relationship('child', 'name')
                    ->required()
                    ->native(false)
                    ->disabled(),
                Select::make('vigency')
                    ->translateLabel()
                    ->options(StatusVigency::class)
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('child.child_photo_path')
                        ->defaultImageUrl(fn (Model $record) => $record->child->getFilamentAvatarUrl())
                        ->circular()
                        ->grow(false)
                        ->alignEnd(),
                    Tables\Columns\Layout\Stack::make([
                        TextColumn::make('child.name')
                            ->weight(FontWeight::Bold)
                            ->searchable()
                            ->sortable(),
                        TextColumn::make('vigency')
                            ->badge(),
                    ]),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->modifyQueryUsing(
                fn ($query) => RecordBuilder::correspondingRecords($query)->with('child')
            );
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
