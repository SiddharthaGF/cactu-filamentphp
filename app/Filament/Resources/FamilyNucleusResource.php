<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\EducationalLevel;
use App\Enums\FamilyRelationship;
use App\Enums\Gender;
use App\Enums\RisksTutor;
use App\Filament\Resources\FamilyNucleusResource\Pages;
use App\Filament\Resources\FamilyNucleusResource\RelationManagers;
use App\Models\FamilyNucleus;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class FamilyNucleusResource extends Resource
{
    protected static ?string $model = FamilyNucleus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('conventional_phone')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated(false)
            ->filters([

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
            ])
            ->modifyQueryUsing(
                fn($query) => $query->with('tutors')
            );
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenRelationManager::class,
            RelationManagers\FamilyMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyNuclei::route('/'),
            'create' => Pages\CreateFamilyNucleus::route('/create'),
            'edit' => Pages\EditFamilyNucleus::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('House')
                    ->relationship('house')
                    ->collapsible()
                    ->collapsed()
                    ->schema(HouseResource::getSchema()),
                Section::make('Family Banking information')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([BankingInformationResource::getSchema()]),
                Section::make('Tutors')
                    ->collapsed()
                    ->schema([
                        Repeater::make('Tutor')
                            ->relationship('tutors')
                            ->deleteAction(
                                fn(Action $action) => $action->requiresConfirmation(),
                            )
                            ->grid(2)
                            ->schema(TutorResource::getSchemaForm())
                            ->columnSpanFull()
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(2),
                        CheckboxList::make('risk_factors')
                            ->options(RisksTutor::class)
                            ->columns(4),
                    ]),
            ]);
    }
}
