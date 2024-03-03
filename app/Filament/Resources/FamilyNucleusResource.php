<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Builder\RecordBuilder;
use App\Enums\RisksTutor;
use App\Filament\Resources\FamilyNucleusResource\Pages;
use App\Filament\Resources\FamilyNucleusResource\RelationManagers;
use App\Models\FamilyNucleus;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class FamilyNucleusResource extends Resource
{
    protected static ?string $model = FamilyNucleus::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getLabel(): ?string
    {
        return __('Family');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        TextColumn::make('tutors.name')
                            ->weight(FontWeight::Bold)
                            ->searchable(),
                        TextColumn::make('tutors.dni')->searchable(),
                        TextColumn::make('house.neighborhood')
                            ->searchable()
                            ->label(__('Neighborhood')),
                    ]),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([])
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
                fn ($query) => RecordBuilder::correspondingRecords($query)->with('tutors')
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
                Section::make(__('Tutors'))
                    ->translateLabel()
                    ->description(__('This section is about the tutors of the family'))
                    ->aside()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('Tutor')
                            ->translateLabel()
                            ->relationship('tutors')
                            ->deleteAction(
                                fn (Action $action) => $action->requiresConfirmation(),
                            )
                            ->grid([
                                'lg' => 1,
                                'xl' => 2,
                            ])
                            ->schema(TutorResource::getSchemaForm())
                            ->columnSpanFull()
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(2),
                        CheckboxList::make('risk_factors')
                            ->translateLabel()
                            ->options(RisksTutor::class)
                            ->columns(4),
                    ]),
                Section::make(__('House'))
                    ->description(__('This section is about the house where the family lives'))
                    ->aside()
                    ->relationship('house')
                    ->collapsible()
                    ->schema(HouseResource::getSchema())
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ]),
                Section::make(__('Family Banking information'))
                    ->description(__('This section is about the banking information of the family'))
                    ->aside()
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        BankingInformationResource::getSchema(),
                    ]),
            ]);
    }
}
