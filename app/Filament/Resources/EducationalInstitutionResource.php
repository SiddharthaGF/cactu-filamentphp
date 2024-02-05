<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\EducationalInstitutionResource\Pages;
use App\Models\EducationalInstitution;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class EducationalInstitutionResource extends Resource
{
    protected static ?string $model = EducationalInstitution::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('zone_code')
                    ->required()
                    ->maxLength(6),
                Geocomplete::make('search')
                    ->label('Search for a center educational')
                    ->prefixIcon('heroicon-o-magnifying-glass')
                    ->geolocate()
                    ->placeField('name')
                    ->geolocateIcon('heroicon-o-map')
                    ->placeholder('Search for a center educational')
                    ->types(['primary_school', 'secondary_school', 'school', 'university'])
                    ->reactive()
                    ->required()
                    ->reverseGeocodeUsing(function (callable $set, array $results): void {
                        $set('address', $results['formatted_address']);
                        $set('view_map', [
                            'lat' => (float)($results['geometry']['location']['lat']),
                            'lng' => (float)($results['geometry']['location']['lng']),
                        ]);
                    })
                    ->countries(['ec']),
                TextInput::make('address')
                    ->label('School address'),
                Map::make('view_map')
                    ->defaultZoom(17)
                    ->reactive()
                    ->reverseGeocodeUsing(function ($results, callable $get, callable $set): void {
                        $set('address', $results['formatted_address']);
                    })
                    ->draggable(false)
                    ->defaultLocation([env('GOOGLE_MAPS_DEFAULT_LAT'), env('GOOGLE_MAPS_DEFAULT_LNG')]),
                TextInput::make('name')
                    ->required()
                    ->maxLength(200),
                TextInput::make('education_type')
                    ->required()
                    ->maxLength(20),
                TextInput::make('financing_type')
                    ->required()
                    ->maxLength(20),
                TextInput::make('area')
                    ->required()
                    ->maxLength(10),
                TextInput::make('academic_regime')
                    ->required()
                    ->maxLength(20),
                TextInput::make('modality')
                    ->required()
                    ->maxLength(120),
                TextInput::make('academic_day')
                    ->required()
                    ->maxLength(50),
                TextInput::make('educative_level')
                    ->required()
                    ->maxLength(40),
                TextInput::make('typology')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('zone_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('financing_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area')
                    ->searchable(),
                Tables\Columns\TextColumn::make('academic_regime')
                    ->searchable(),
                Tables\Columns\TextColumn::make('modality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('academic_day')
                    ->searchable(),
                Tables\Columns\TextColumn::make('educative_level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('typology')
                    ->searchable(),
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
            'index' => Pages\ListEducationalInstitutions::route('/'),
            'create' => Pages\CreateEducationalInstitution::route('/create'),
            'edit' => Pages\EditEducationalInstitution::route('/{record}/edit'),
        ];
    }
}
