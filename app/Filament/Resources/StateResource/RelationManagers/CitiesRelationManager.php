<?php

declare(strict_types=1);

namespace App\Filament\Resources\StateResource\RelationManagers;

use App\Filament\Resources\CityResource;
use App\Models\City;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class CitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'cities';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Cities');
    }

    protected static function getModelLabel(): ?string
    {
        return __('City');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->translateLabel()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('zones_count')
                    ->counts('zones')
                    ->badge(),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(
                        fn (City $city) => CityResource::getUrl('edit', [$city->code])
                    ),
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
