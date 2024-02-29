<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class StateResource extends Resource
{
    protected static ?string $model = State::class;

    public static function getNavigationGroup(): ?string
    {
        return __("Location");
    }

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function getLabel(): ?string
    {
        return __("State");
    }

    public static function getPluralLabel(): ?string
    {
        return __("States");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->translateLabel()
                    ->unique(ignorable: fn ($record) => $record)
                    ->required()
                    ->maxLength(2)
                    ->minLength(2)
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(100),
                Forms\Components\Select::make('coordinator_id')
                    ->translateLabel()
                    ->relationship('coordinator', 'name')
                    ->native(false)
                    ->label('Coordinator'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("State")
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('coordinator.name')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cities_count')
                    ->translateLabel()
                    ->label('Cities')
                    ->counts('cities')
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\CitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
