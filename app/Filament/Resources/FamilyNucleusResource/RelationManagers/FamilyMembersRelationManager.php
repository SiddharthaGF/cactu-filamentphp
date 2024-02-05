<?php

declare(strict_types=1);

namespace App\Filament\Resources\FamilyNucleusResource\RelationManagers;

use App\Enums\EducationalLevel;
use App\Enums\FamilyRelationship;
use App\Enums\Gender;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class FamilyMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'family_members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('birthdate')
                    ->required()
                    ->native(false),
                Select::make('gender')
                    ->options(Gender::class)
                    ->native(false)
                    ->required(),
                Select::make('relationship')
                    ->options(FamilyRelationship::class)
                    ->native(false)
                    ->required(),
                Select::make('education_level')
                    ->options(EducationalLevel::class)
                    ->native(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('gender')
                    ->badge(),
                TextColumn::make('relationship')
                    ->searchable()
                    ->badge(),
                TextColumn::make('birthdate')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->age)
                    ->badge()
                    ->label('Age'),
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
