<?php

declare(strict_types=1);

namespace App\Filament\Resources\ZoneResource\RelationManagers;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CommunitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'communities';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('zone_code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->required(),
                Checkbox::make('vigency')
                    ->dehydrateStateUsing(fn ($state) => $state ? 'active' : 'inactive')
                    ->formatStateUsing(
                        fn (string $state) => $state === 'active'
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('zone_code')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('community_managers_count')
                    ->counts('community_managers')
                    ->badge(),
                TextColumn::make('vigency')
                    ->badge(),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
}
