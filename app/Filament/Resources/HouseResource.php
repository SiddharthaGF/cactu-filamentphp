<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Constants\BasicServices;
use App\Enums\FloorMaterials;
use App\Enums\HomeSpaceSituations;
use App\Enums\HousePropertyTypes;
use App\Enums\RoofMaterials;
use App\Enums\WallMaterials;
use App\Filament\Resources\HouseResource\Pages;
use App\Models\FamilyNucleus;
use App\Models\House;
use App\Models\Tutor;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms\Components\CheckboxList;
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
                fn() => FamilyNucleus::select(
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
            ->createOptionForm(fn(Form $form) => FamilyNucleusResource::form($form));
    }

    public static function getSchema(): array
    {
        return [
            Select::make('property')
                ->options(HousePropertyTypes::class)
                ->required()
                ->native(false),
            Select::make('home_space')
                ->options(HomeSpaceSituations::class)
                ->required()
                ->native(false),
            Select::make('roof')
                ->options(RoofMaterials::class)
                ->required()
                ->native(false),
            Select::make('walls')
                ->options(WallMaterials::class)
                ->required()
                ->native(false),
            Select::make('floor')
                ->options(FloorMaterials::class)
                ->required()
                ->native(false),
            CheckboxList::make('basic_services')
                ->options(BasicServices::class)
                ->columns(5)
                ->columnSpanFull()
                ->gridDirection('row'),
            TextInput::make('extras')
                ->required(),
            Map::make('location')
                ->defaultZoom(17)
                ->columnSpanFull()
                ->defaultLocation([env('GOOGLE_MAPS_DEFAULT_LAT', 0), env('GOOGLE_MAPS_DEFAULT_LNG', 0)]),
            TextInput::make('neighborhood')
                ->required(),
            Repeater::make('dangerous_places_nearby')
                ->relationship('risks_near_home')
                ->defaultItems(0)
                ->simple(
                    TextInput::make('description')
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
                        fn(int $state, House $record) => $state = $record->family_nucleus->children->count() + $record->family_nucleus->family_members->count()
                    )
                    ->badge()
                    ->sortable(),
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
            'index' => Pages\ListHouses::route('/'),
            'create' => Pages\CreateHouse::route('/create'),
            'edit' => Pages\EditHouse::route('/{record}/edit'),
        ];
    }
}
