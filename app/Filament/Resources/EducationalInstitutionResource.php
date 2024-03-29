<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\EducationalInstitutionResource\Pages;
use App\Models\City;
use App\Models\EducationalInstitution;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class EducationalInstitutionResource extends Resource
{
    protected static ?string $model = EducationalInstitution::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getLabel(): ?string
    {
        return __('Educational Institution');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Educational Institutions');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Location');
    }

    protected static ?int $navigationSort = 4;

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(200),
                Select::make('zone_code')
                    ->translateLabel()
                    ->searchable()
                    ->preload()
                    ->options(
                        City::all()->mapWithKeys(fn ($city) => ["$city->code - $city->name" => $city->zones->mapWithKeys(
                            fn ($zone) => [$zone->code => "$zone->code - $zone->name"]
                        )])->toArray(),
                    )
                    //->relationship('zone', 'name')
                    ->native(false)
                    ->required(),
                Geocomplete::make('search')
                    ->translateLabel()
                    ->label('Search for a center educational')
                    ->prefixIcon('heroicon-o-magnifying-glass')
                    ->geolocate()
                    ->placeField('name')
                    ->geolocateIcon('heroicon-o-map')
                    ->placeholder('Search for a center educational')
                    ->types(['primary_school', 'secondary_school', 'school', 'university'])
                    ->reactive()
                    ->reverseGeocodeUsing(function (callable $set, array $results): void {
                        $set('address', $results['formatted_address']);
                        $set('view_map', [
                            'lat' => (float) ($results['geometry']['location']['lat']),
                            'lng' => (float) ($results['geometry']['location']['lng']),
                        ]);
                    })
                    ->countries(['ec']),
                TextInput::make('address')
                    ->disabled()
                    ->dehydrated()
                    ->label('School address'),
                Map::make('view_map')
                    ->translateLabel()
                    ->defaultZoom(17)
                    ->reactive()
                    ->reverseGeocodeUsing(function ($results, callable $get, callable $set): void {
                        $set('address', $results['formatted_address']);
                    })
                    ->draggable(false)
                    ->defaultLocation([env('GOOGLE_MAPS_DEFAULT_LAT'), env('GOOGLE_MAPS_DEFAULT_LNG')]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('zone_code')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('address')
                    ->translateLabel()
                    ->searchable(),
            ])
            ->filters([])
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
        return [];
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
