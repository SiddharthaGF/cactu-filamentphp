<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyMemberResource\Pages;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class FamilyMemberResource extends Resource
{
    protected static ?string $model = FamilyMember::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return __("Family Member");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Family Members");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('family_nucleus_id')
                    ->relationship('family_nucleus', 'id')
                    ->required()
                    ->disabledOn('edit'),
                TextInput::make('name')
                    ->required(),
                DatePicker::make('birthdate')
                    ->required()
                    ->native(false),
                Select::make('gender')
                    ->options([
                        'MALE' => 'Male',
                        'FEMALE' => 'Female',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('relationship')
                    ->options([
                        'father/mother' => 'Father/Mother',
                        'grandfather/grandmother' => 'Grandfather/Grandmother',
                        'brother/sister' => 'Brother/Sister',
                        'uncle/aunt' => 'Uncle/Aunt',
                        'cousin' => 'Cousin',
                        'stepfather/stepmother' => 'Stepfather/Stepmother',
                        'stepbrother/stepsister' => 'Stepbrother/Stepsister',
                        'other',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('education_level')
                    ->options([
                        'none' => 'None',
                        'basic_preparatory_education' => 'Basic Preparatory Education',
                        'elementary_basic_education' => 'Elementary Basic Education',
                        'medium_basic_education' => 'Medium Basic Education',
                        'higher_basic_education' => 'Higher Basic Education',
                        'baccalaureate' => 'Baccalaureate',
                        'superior' => 'Superior',
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('family_nucleus.id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable()
                    ->badge(),
                TextColumn::make('relationship')
                    ->searchable()
                    ->badge(),
                TextColumn::make('birthdate')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->age)
                    ->badge()
                    ->label('Age'),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyMembers::route('/'),
            'create' => Pages\CreateFamilyMember::route('/create'),
            'edit' => Pages\EditFamilyMember::route('/{record}/edit'),
        ];
    }
}
