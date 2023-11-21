<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('family_nucleus_id')
                    ->searchable()
                    ->relationship('family_nucleus', 'id')
                    ->required()
                    ->native(false)
                    ->disabledOn('edit')
                    ->preload(),
                Select::make('manager_id')
                    ->searchable()
                    ->relationship('manager', 'name')
                    ->required()
                    ->native(false)
                    ->preload()
                    ->default(Auth::user()->id)
                    ->disabled(
                        fn () => !Auth::user()->hasRole('super_admin')
                    ),
                TextInput::make('name')
                    ->required(),
                TextInput::make('dni')
                    ->required(),
                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female'
                    ])
                    ->native(false)
                    ->required(),
                DatePicker::make('birthdate')
                    ->required()
                    ->native(false),
                TextInput::make('children_number'),
                TextInput::make('case_number'),
                Select::make('affiliation_status')
                    ->options([
                        'pending' => 'Pending',
                        'affiliated' => 'Affiliated',
                        'desaffiliated' => 'Desaffiliated',
                        'rejected' => 'Rejected',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('contact_id')
                    ->searchable()
                    ->relationship('contact', 'name')
                    ->native(false),
                TextInput::make('pseudonym'),
                Select::make('sexual_identity')
                    ->options([
                        'boy' => 'Boy',
                        'girl' => 'Girl',
                        'other' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('literacy')
                    ->options([
                        'none' => 'None',
                        'write' => 'Write',
                        'Read' => 'Read',
                        'both' => 'Both',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('language')
                    ->options([
                        'SPANISH' => 'Spanish',
                        'QUECHUA' => 'Quechua',
                        'OTHER' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                TextInput::make('specific_language'),
                TextInput::make('religious'),
                Select::make('nationality')
                    ->options([
                        'ECUADORIAN' => 'Ecuadorian',
                        'OTHER' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('migratory_status')
                    ->options([
                        'NONE' => 'None',
                        'REFUGEE' => 'Refugee',
                        'MIGRANT' => 'Migrant',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('ethnic_group')
                    ->options([
                        'AFRO-ECUADORIAN' => 'Afro-ecuadorian',
                        'INDIGENOUS' => 'Indigenous',
                        'MESTIZO' => 'Mestizo',
                        'OTHER' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                Textarea::make('activities_for_family_support'),
                Textarea::make('recreation_activities'),
                Textarea::make('additional_information'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dni')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('children_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('case_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('birthdate')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->age)
                    ->badge()
                    ->label('Age'),
                TextColumn::make('affiliation_status')
                    ->badge(),
                TextColumn::make('manager.name')
                    ->badge(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updater.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            ])
            ->modifyQueryUsing(
                function (Builder $query) {
                    if (Auth::user()->hasRole('super_admin')) {
                        return $query;
                    } else {
                        return $query->where('manager_id', Auth::user()->id);
                    }
                }
            );
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
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
        ];
    }
}
