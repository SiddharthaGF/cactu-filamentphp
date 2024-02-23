<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityResource\Pages;
use App\Models\Community;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class CommunityResource extends Resource
{
    protected static ?string $model = Community::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Location';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Checkbox::make('vigency'),
                Select::make('zone_code')
                    ->relationship(
                        'zone',
                        'name'
                    )
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->label('Zone'),
                Select::make('manager_id')
                    ->relationship('managers')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->label('Manager'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('community_managers_count')
                    ->counts('community_managers')
                    ->badge(),
                TextColumn::make('vigency')
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
