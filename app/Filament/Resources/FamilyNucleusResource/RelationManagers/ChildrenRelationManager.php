<?php

declare(strict_types=1);

namespace App\Filament\Resources\FamilyNucleusResource\RelationManagers;

use App\Filament\Resources\ChildResource;
use App\Models\Child;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Children');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('dni')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('children_number')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('case_number')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->translateLabel()
                    ->badge(),
                TextColumn::make('birthdate')
                    ->translateLabel()
                    ->formatStateUsing(
                        fn ($state) => Carbon::parse($state)->age
                    )
                    ->badge()
                    ->label('Age'),
                TextColumn::make('affiliation_status')
                    ->translateLabel()
                    ->badge(),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Edit')
                    ->translateLabel()
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (Child $record) => ChildResource::getUrl('edit', [$record->id])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function getModelLabel(): ?string
    {
        return __('Child');
    }
}
