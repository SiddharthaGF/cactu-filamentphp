<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyNucleusResource\Pages;
use App\Filament\Resources\FamilyNucleusResource\RelationManagers;
use App\Models\FamilyNucleus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FamilyNucleusResource extends Resource
{
    protected static ?string $model = FamilyNucleus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tutor1')
                    ->relationship(
                        'tutor1',
                        'name'
                    )
                    ->required(),
                Forms\Components\Select::make('tutor2')
                    ->relationship(
                        'tutor2',
                        'name'
                    ),
                Forms\Components\TextInput::make('conventional_phone')
                    ->tel()
                    ->maxLength(9),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tutor1.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tutor2.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('conventional_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updater.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyNuclei::route('/'),
            'create' => Pages\CreateFamilyNucleus::route('/create'),
            'edit' => Pages\EditFamilyNucleus::route('/{record}/edit'),
        ];
    }
}
