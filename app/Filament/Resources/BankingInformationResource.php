<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\BankAccountType;
use App\Enums\FinancialInstitutionType;
use App\Filament\Resources\BankingInformationResource\Pages;
use App\Models\BankingInformation;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class BankingInformationResource extends Resource
{
    protected static ?string $model = BankingInformation::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema(self::getSchema());
    }

    public static function getSchema(string $name = 'family_account'): Repeater
    {
        return Repeater::make($name)
            ->relationship('banking_information')
            ->label('Banking Account')
            ->translateLabel()
            ->deleteAction(
                fn(Action $action) => $action->requiresConfirmation(),
            )
            ->schema([
                Select::make('account_type')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->options(BankAccountType::class)
                    ->native(false)
                    ->required(),
                Select::make('financial_institution_types')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->options(FinancialInstitutionType::class)
                    ->native(false)
                    ->required(),
                TextInput::make('financial_institution_bank')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('account_number')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->unique(ignorable: fn($record) => $record)
                    ->required(),
            ])
            ->defaultItems(0)
            ->columns()
            ->columnSpanFull()
            ->maxItems(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

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
            'index' => Pages\ListBankingInformation::route('/'),
            'create' => Pages\CreateBankingInformation::route('/create'),
            'edit' => Pages\EditBankingInformation::route('/{record}/edit'),
        ];
    }
}
