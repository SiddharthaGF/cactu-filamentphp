<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorResource\Pages;
use App\Filament\Resources\TutorResource\RelationManagers;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('dni')
                    ->required()
                    ->disabledOn('edit'),
                //TODO add regex for dni
                TextInput::make('mobile_phone')
                    ->required()
                    ->tel()
                    ->telRegex('/^09\d{8}$/'),
                DatePicker::make('birthdate')
                    ->required()
                    ->native(false),
                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female'
                    ])
                    ->native(false)
                    ->required(),
                Toggle::make('is_parent'),
                Toggle::make('is_present')
                    ->reactive(),
                Select::make('reason_not_present')
                    ->options([
                        'divorced' => 'Divorced',
                        'separated' => 'Separated',
                        'lives_elsewhere' => 'Lives Elsewhere',
                        'dead' => 'Dead',
                        'other' => 'Other',
                    ])
                    ->native(false),
                Textarea::make('specific_reason'),
                DatePicker::make('deathdate'),
                Select::make('occupation')
                    ->options([
                        'private_employee' => 'Private Employee',
                        'artisan' => 'Artisan',
                        'farmer' => 'Farmer',
                        'animal_keeper' => 'Animal Keeper',
                        'cook' => 'Cook',
                        'carpenter' => 'Carpenter',
                        'builder' => 'Builder',
                        'day_laborer' => 'Day Laborer',
                        'mechanic' => 'Mechanic',
                        'salesman' => 'Salesman',
                        'paid_household_work' => 'Paid Household Work',
                        'unpaid_household_work' => 'Unpaid Household Work',
                        'unknown' => 'Unknown',
                        'other' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                TextInput::make('specific_occupation'),
                TextInput::make('salary')
                    ->numeric()
                    ->minValue(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dni')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable()
                    ->badge(),
                TextColumn::make('mobile_phone')
                    ->searchable(),
                IconColumn::make('is_parent')
                    ->boolean(),
                IconColumn::make('is_present')
                    ->boolean(),
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
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}
