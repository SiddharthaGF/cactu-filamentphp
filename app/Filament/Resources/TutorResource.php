<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\FamilyRelationship;
use App\Enums\Gender;
use App\Enums\Occupation;
use App\Enums\ReasonsIsNotPresent;
use App\Filament\Resources\TutorResource\Pages;
use App\Models\Tutor;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

final class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): ?string
    {
        return __("Tutor");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Tutors");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(self::getSchemaForm());
    }

    public static function getSchemaForm(): array
    {
        return [
            TextInput::make('name')
                ->translateLabel()
                ->required(),
            TextInput::make('dni')
                ->prefixIcon('heroicon-o-identification')
                ->translateLabel()
                ->numeric()
                ->unique(ignorable: fn ($record) => $record)
                ->required(),
            Group::make()
                ->relationship('mobile_number')
                ->schema([
                    PhoneInput::make('number')
                        ->translateLabel()
                        ->unique(ignorable: fn ($record) => $record)
                        ->required(),
                ]),
            DatePicker::make('birthdate')
                ->translateLabel()
                ->prefixIcon('heroicon-o-calendar')
                ->native(false)
                ->maxDate(now())
                ->closeOnDateSelection()
                ->required(),
            Select::make('gender')
                ->translateLabel()
                ->prefixIcon('heroicon-o-sparkles')
                ->options(Gender::class)
                ->native(false)
                ->required(),
            Select::make('relationship')
                ->translateLabel()
                ->options(FamilyRelationship::class)
                ->native(false)
                ->required(),
            Toggle::make('is_present')
                ->translateLabel()
                ->onColor('success')
                ->offColor('gray')
                ->columnSpanFull()
                ->onIcon('heroicon-o-hand-thumb-up')
                ->reactive(),
            Section::make()
                ->hidden(
                    fn (Get $get, $state) => $state = $get('is_present')
                )
                ->schema([
                    Select::make('reason_not_present')
                        ->translateLabel()
                        ->prefixIcon('heroicon-o-question-mark-circle')
                        ->options(ReasonsIsNotPresent::class)
                        ->native(false)
                        ->required()
                        ->reactive(),
                    Textarea::make('specific_reason')
                        ->translateLabel()
                        ->required()
                        ->visible(
                            fn (Get $get, $state) => $state = ReasonsIsNotPresent::Other->value === $get('reason_not_present')
                        ),
                    DatePicker::make('deathdate')
                        ->translateLabel()
                        ->prefixIcon('heroicon-o-calendar')
                        ->required()
                        ->native(false)
                        ->maxDate(now())
                        ->visible(
                            fn (Get $get, $state) => $state = ReasonsIsNotPresent::Dead->value === $get('reason_not_present')
                        ),
                ]),
            Section::make()
                ->schema([
                    Select::make('occupation')
                        ->prefixIcon('heroicon-o-briefcase')
                        ->translateLabel()
                        ->options(Occupation::class)
                        ->native(false)
                        ->required()
                        ->reactive(),
                    TextInput::make('specific_occupation')
                        ->translateLabel()
                        ->prefixIcon('heroicon-o-question-mark-circle')
                        ->required()
                        ->visible(
                            fn (Get $get, $state) => $state = Occupation::Other->value === $get('occupation')
                        ),
                    TextInput::make('salary')
                        ->prefixIcon('heroicon-o-currency-dollar')
                        ->numeric()
                        ->minValue(1),
                ])
                ->hidden(
                    fn (Get $get, $state) => $state = ! $get('is_present')
                ),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getTableSchema())
            ->filters([
                SelectFilter::make('gender')
                    ->options(Gender::class),
                SelectFilter::make('Tutor type')
                    ->options([
                        true => 'Parents',
                        false => 'Guardians',
                    ])
                    ->attribute('is_parent'),
                Filter::make('is_present')
                    ->query(
                        fn (Builder $query, $state) => $query->where('is_parent', $state)
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make('With the fields that appear in the registration form')
                        ->withFilename(fn ($resource) => 'tutors-' . date('YmdHis'))
                        ->fromForm(),
                    ExcelExport::make('All the information')
                        ->withFilename(fn ($resource) => 'tutors-' . date('YmdHis'))
                        ->fromModel(),
                ]),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->modifyQueryUsing(
                fn (Builder $query) => Auth::user()->can('view_any_tutor')
                    ? $query
                    : $query->where('updated_by', auth()->id())
            );
    }

    public static function getTableSchema(): array
    {
        return [
            TextColumn::make('dni')
                ->searchable()
                ->sortable(),
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('birthdate')
                ->formatStateUsing(
                    fn ($state) => Carbon::parse($state)->age
                )
                ->badge()
                ->color('info')
                ->label('Age'),
            TextColumn::make('gender')
                ->searchable()
                ->badge()
                ->sortable(),

            IconColumn::make('is_parent')
                ->boolean()
                ->alignCenter()
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('is_present')
                ->alignCenter()
                ->boolean()
                ->toggleable(isToggledHiddenByDefault: true),
            IconColumn::make('deathdate')
                ->alignCenter()
                ->boolean()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //FamilyNucleiRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}
