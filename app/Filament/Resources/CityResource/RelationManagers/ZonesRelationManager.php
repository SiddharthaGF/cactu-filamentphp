<?php

declare(strict_types=1);

namespace App\Filament\Resources\CityResource\RelationManagers;

use App\Filament\Resources\ZoneResource;
use App\Models\Zone;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class ZonesRelationManager extends RelationManager
{
    protected static string $relationship = 'zones';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Zones');
    }

    protected static function getModelLabel(): ?string
    {
        return __('Zone');
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
            ->recordTitleAttribute('city_code')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('communities_count')
                    ->counts('communities')
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
                        fn (Zone $zone) => ZoneResource::getUrl('edit', [$zone->code])
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
