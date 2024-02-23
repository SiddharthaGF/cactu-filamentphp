<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\BasicServices;
use App\Enums\FloorMaterials;
use App\Enums\HomeSpaceSituations;
use App\Enums\HousePropertyTypes;
use App\Enums\Location;
use App\Enums\RoofMaterials;
use App\Enums\WallMaterials;
use App\Filament\Resources\HouseResource\Pages;
use App\Models\FamilyNucleus;
use App\Models\House;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

final class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                array_merge(
                    [self::getSelectFamily()],
                    self::getSchema(),
                )
            );
    }

    public static function getSelectFamily(): Select
    {
        return Select::make('family_nucleus_id')
            ->helperText('This information is shared by all affiliated children belonging to the same family nucleus.')
            ->options(
                fn () => FamilyNucleus::select(
                    'family_nuclei.id as id',
                    DB::raw("GROUP_CONCAT(CONCAT(tutors.dni, ' - ', tutors.name) SEPARATOR ' : ') as full_name")
                )
                    ->join('tutors', 'family_nuclei.id', '=', 'tutors.family_nucleus_id')
                    ->groupBy('family_nuclei.id')
                    ->pluck('full_name', 'id')
            )
            ->searchable()
            ->columnSpanFull()
            ->required()
            ->native(false)
            //->editOptionForm(fn(Form $form) => FamilyNucleusResource::form($form))
            ->createOptionForm(fn (Form $form) => FamilyNucleusResource::form($form));
    }

    public static function getSchema(): array
    {
        return [
            Select::make('property')
                ->translateLabel()
                ->options(HousePropertyTypes::class)
                ->required()
                ->native(false),
            Select::make('home_space')
                ->translateLabel()
                ->options(HomeSpaceSituations::class)
                ->required()
                ->native(false),
            Select::make('roof')
                ->translateLabel()
                ->options(RoofMaterials::class)
                ->required()
                ->native(false),
            Select::make('walls')
                ->translateLabel()
                ->options(WallMaterials::class)
                ->required()
                ->native(false),
            Select::make('floor')
                ->translateLabel()
                ->options(FloorMaterials::class)
                ->required()
                ->native(false),
            CheckboxList::make('basic_services')
                ->translateLabel()
                ->options(BasicServices::class)
                ->columns([
                    'sm' => 2,
                    'md' => 2,
                    'lg' => 3,
                    'xl' => 4,
                ])
                ->bulkToggleable()
                ->columnSpanFull()
                ->gridDirection('row'),
            Map::make('location')
                ->translateLabel()
                ->defaultZoom(17)
                ->columnSpanFull()
                ->defaultLocation([env('GOOGLE_MAPS_DEFAULT_LAT', 0), env('GOOGLE_MAPS_DEFAULT_LNG', 0)]),
            TextInput::make('neighborhood')
                ->translateLabel()
                ->columnSpanFull()
                ->required(),
            Radio::make('territory')
                ->translateLabel()
                ->options(Location::class)
                ->columns([
                    'sm' => 4,
                ])
                ->required(),
            Repeater::make('dangerous_places_nearby')
                ->translateLabel()
                ->columnSpanFull()
                ->relationship('risks_near_home')
                ->defaultItems(0)
                ->simple(
                    TextInput::make('description')
                        ->columnSpanFull()
                        ->translateLabel()
                        ->required(),
                ),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('family_nucleus.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('family_nucleus.id')
                    ->formatStateUsing(
                        fn (int $state, House $record) => $state = $record->family_nucleus->children->count() + $record->family_nucleus->family_members->count()
                    )
                    ->badge()
                    ->sortable(),
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
            'index' => Pages\ListHouses::route('/'),
            'create' => Pages\CreateHouse::route('/create'),
            'edit' => Pages\EditHouse::route('/{record}/edit'),
        ];
    }
}
