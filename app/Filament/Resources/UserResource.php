<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\GlobalSearch\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Hash;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'E-mail' => $record->email,
            'Roles' => $record->roles->pluck('name')->join(', '),
            'Vigency' => $record->vigency ? 'Active' : 'Inactive',
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return UserResource::getUrl('view', ['record' => $record]);
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil-square')
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Credentials'))
                    ->description(__('The user\'s email and password are used to log in to the system'))
                    ->icon('heroicon-o-lock-closed')
                    ->aside()
                    ->columns([
                        'md' => 1,
                        'lg' => 2,
                    ])
                    ->schema(components: [
                        Forms\Components\TextInput::make('name')
                            ->translateLabel()
                            ->prefixIcon('heroicon-o-user')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->translateLabel()
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->translateLabel()
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => 'create' === $context),
                    ]),
                Forms\Components\Section::make('Roles')
                    ->description(__('The panel_user role allows the user to log in, if you want a user not to access the system, remove the role'))
                    ->aside()
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        Select::make('role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->native(false)
                            ->preload()
                            ->reactive(),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar_url')
                        ->defaultImageUrl(fn(Model $record) => $record->getFilamentAvatarUrl())
                        ->circular()
                        ->grow(false)
                        ->alignEnd(),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-o-user')
                            ->color(fn(Model $record) => $record->vigency ? 'success' : 'danger')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-o-envelope')
                            ->searchable()
                            ->sortable(),
                    ]),
                ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->disabled(fn(Model $record) => $record->id === 1)
                    ->hidden(fn(Model $record) => $record->id === 1),
                Impersonate::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exports([
                    ExcelExport::make('Only what appears in the table')
                        ->withFilename('Users')
                        ->fromTable(),
                    ExcelExport::make('With the fields that appear in the registration form')->fromForm(),
                    ExcelExport::make('All the information')->fromModel(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
