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
use Illuminate\Database\Eloquent\Model;

final class FamilyMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'family_members';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Family Members');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                DatePicker::make('birthdate')
                    ->translateLabel()
                    ->required()
                    ->native(false),
                Select::make('gender')
                    ->options(Gender::class)
                    ->translateLabel()
                    ->native(false)
                    ->required(),
                Select::make('relationship')
                    ->translateLabel()
                    ->options(FamilyRelationship::class)
                    ->native(false)
                    ->required(),
                Select::make('education_level')
                    ->translateLabel()
                    ->options(EducationalLevel::class)
                    ->native(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel(),
                TextColumn::make('gender')
                    ->badge()
                    ->translateLabel(),
                TextColumn::make('relationship')
                    ->translateLabel()
                    ->searchable()
                    ->badge(),
                TextColumn::make('birthdate')
                    ->translateLabel()
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->age.' '.__('years'))
                    ->badge()
                    ->label('Age'),
            ])
            ->filters([])
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

    protected static function getModelLabel(): ?string
    {
        return __('Family Member');
    }
}
