<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityResource\Pages;
use App\Models\Community;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CommunityResource extends Resource
{
    protected static ?string $model = Community::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function getNavigationGroup(): ?string
    {
        return __('Location');
    }

    protected static ?int $navigationSort = 4;

    public static function getLabel(): ?string
    {
        return __('Community');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Communities');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Select::make('zone_code')
                    ->relationship(
                        'zone',
                        'name'
                    )
                    ->translateLabel()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->label('Zone'),
                Toggle::make('vigency')
                    ->translateLabel(),
                Select::make('manager_id')
                    ->translateLabel()
                    ->relationship('managers', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->maxItems(10)
                    ->columnSpanFull()
                    ->reactive()
                    ->label('Managers'),
                Hidden::make('created_by')
                    ->default(auth()->id())
                    ->dehydrated(
                        fn ($context) => $context == 'create'
                    ),
                Hidden::make('updated_by')
                    ->default(auth()->id())
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->translateLabel()
                    ->sortable(),
                TextColumn::make('community_managers_count')
                    ->label('Managers')
                    ->translateLabel()
                    ->counts('community_managers')
                    ->badge(),
                TextColumn::make('vigency')
                    ->translateLabel()
                    ->badge(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommunities::route('/'),
            'create' => Pages\CreateCommunity::route('/create'),
            'edit' => Pages\EditCommunity::route('/{record}/edit'),
        ];
    }
}
