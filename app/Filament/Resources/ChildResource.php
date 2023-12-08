<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Builder\RecordBuilder;
use App\Enums\AffiliationStatus;
use App\Enums\Disability;
use App\Enums\EducationalStatus;
use App\Enums\EthnicGroup;
use App\Enums\Gender;
use App\Enums\HealthStatus;
use App\Enums\Language;
use App\Enums\Literacy;
use App\Enums\MigratoryStatus;
use App\Enums\Nationality;
use App\Enums\RisksChild;
use App\Enums\SchoolLevel;
use App\Enums\SchoolSuject;
use App\Enums\SexualIdentity;
use App\Filament\Resources\ChildResource\Pages;
use App\Models\Child;
use App\Models\EducationalInstitution;
use Carbon\Carbon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

final class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make(
                    [
                        Step::make('General information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Sponsor Information')
                                    ->compact()
                                    ->collapsed()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('children_number')
                                            ->numeric(),
                                        TextInput::make('case_number')
                                            ->numeric(),
                                        Select::make('affiliation_status')
                                            ->options(AffiliationStatus::class)
                                            ->default(AffiliationStatus::Pending)
                                            ->native(false)
                                            ->required(),
                                    ]),
                                Section::make('Personal Information.')
                                    ->compact()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->placeholder('Name and last name')
                                            ->required(),
                                        TextInput::make('dni')
                                            ->required()
                                            ->placeholder('DNI')
                                            ->prefixIcon('heroicon-o-identification')
                                            ->disabledOn('edit'),
                                        TextInput::make('pseudonym')
                                            ->placeholder('Pseudonym')
                                            ->prefixIcon('heroicon-o-bug-ant')
                                            ->required(),
                                        DatePicker::make('birthdate')
                                            ->required()
                                            ->placeholder('Birthdate')
                                            ->prefixIcon('heroicon-o-calendar')
                                            ->native(false)
                                            ->closeOnDateSelection()
                                            ->maxDate(Carbon::now()),
                                        Select::make('gender')
                                            ->options(Gender::class)
                                            ->native(false)
                                            ->required()
                                            ->prefixIcon('heroicon-o-sparkles'),
                                        Select::make('sexual_identity')
                                            ->options(SexualIdentity::class)
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-heart')
                                            ->required(),
                                    ]),
                                Section::make('General information about the child and family.')
                                    ->columns(2)
                                    ->compact()
                                    ->schema([
                                        Section::make()
                                            ->columns(2)
                                            ->schema([
                                                Select::make('language')
                                                    ->options(Language::class)
                                                    ->default(Language::Spanish)
                                                    ->reactive()
                                                    ->native(false)
                                                    ->prefixIcon('heroicon-o-language')
                                                    ->required(),
                                                TextInput::make('specific_language')
                                                    ->hidden(
                                                        fn(Get $get) => Language::Other !== $get('language')
                                                    )
                                                    ->required(),
                                            ]),
                                        Section::make()
                                            ->columns(2)
                                            ->schema([
                                                Select::make('nationality')
                                                    ->options(Nationality::class)
                                                    ->default(Nationality::Ecuadorian)
                                                    ->native(false)
                                                    ->required()
                                                    ->prefixIcon('heroicon-o-flag')
                                                    ->live(),
                                                TextInput::make('specific_nationality')
                                                    ->hidden(
                                                        fn(Get $get) => Nationality::Other !== $get('nationality')
                                                    )
                                                    ->required(),
                                            ]),
                                        Section::make()
                                            ->columns(2)
                                            ->schema([
                                                Select::make('ethnic_group')
                                                    ->options(EthnicGroup::class)
                                                    ->native(false)
                                                    ->required()
                                                    ->prefixIcon('heroicon-o-user-group')
                                                    ->live(),
                                                TextInput::make('specific_ethnic_group')
                                                    ->hidden(
                                                        fn(Get $get) => EthnicGroup::Other !== $get('ethnic_group')
                                                    )
                                                    ->required(),
                                            ]),
                                        TextInput::make('religious')
                                            ->datalist([
                                                'Catholic',
                                                'Evangelical',
                                                'Jehovah\'s Witness',
                                                'Agnostic',
                                                'Atheist',
                                            ])
                                            ->placeholder('Religious')
                                            ->prefixIcon('heroicon-o-star')
                                            ->suffixAction(
                                                Action::make('Clean field')
                                                    ->icon('heroicon-o-x-circle')
                                                    ->action(fn(Set $set) => $set('religious', '')),
                                            ),
                                        Select::make('migratory_status')
                                            ->options(MigratoryStatus::class)
                                            ->default(MigratoryStatus::None)
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-globe-americas')
                                            ->required(),
                                    ])
                                    ->columns(2),
                                CheckboxList::make('activities_for_family_support')
                                    ->options([
                                        'washes' => 'Washes',
                                        'brings firewood' => 'Brings firewood',
                                        'brings water' => 'Brings water',
                                        'takes care of animals' => 'Takes care of animals',
                                        'cooks' => 'Cooks',
                                        'has de bed' => 'Has de bed',
                                        'does the shopping' => 'Does the shopping',
                                        'cares of brothers/sisters' => 'cares of brothers/sisters',
                                        'cleans the house' => 'Cleans the house',
                                        'runs errands' => 'Runs errands',
                                        'gathers grass for animals' => 'Gathers grass for animals',
                                    ])
                                    ->columns(5)
                                    ->columnSpanFull(),
                                TextArea::make('specific_activities_for_family_support')
                                    ->columnSpanFull(),
                                CheckboxList::make('recreation_activities')
                                    ->options([
                                        'plays with dolls' => 'Plays with dolls',
                                        'jumps rope' => 'Jumps rope',
                                        'plays ball' => 'Plays ball',
                                        'plays marbles' => 'Plays marbles',
                                        'plays house' => 'Plays house',
                                        'plays with carts' => 'Plays with carts',
                                        'plays hopscotch' => 'Plays hopscotch',
                                        'runs' => 'Runs',
                                        'plays with rattles' => 'Plays with rattles',
                                        'plays hide and seek' => 'Plays hide and seek',
                                        'plays with friends' => 'Plays with friends',
                                        'plays hula hoops' => 'Plays hula hoops',
                                        'rides a bicycle' => 'Rides a bicycle',
                                    ])
                                    ->columns(5)
                                    ->columnSpanFull(),
                                TextArea::make('specific_recreation_activities')
                                    ->columnSpanFull(),
                                Textarea::make('additional_information'),
                            ]),
                        Step::make('Educational Information')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Select::make('literacy')
                                    ->columnSpanFull()
                                    ->label('Literacy (It was detected that the child is older than 5 years)')
                                    ->selectablePlaceholder(false)
                                    ->options(Literacy::class)
                                    ->default(Literacy::Both)
                                    ->native(false)
                                    ->required(),
                                Group::make()
                                    ->schema([
                                        Repeater::make('educational_record')
                                            ->relationship('educational_record')
                                            ->schema([
                                                Radio::make('status')
                                                    ->options(EducationalStatus::class)
                                                    ->columnSpanFull()
                                                    ->required(),
                                                Select::make('educational_institution_id')
                                                    ->options(
                                                        fn() => EducationalInstitution::select([
                                                            'id',
                                                            DB::raw("CONCAT(educational_Institutions.name, ' (', zone_city.name, ')') AS full_name"),
                                                        ])
                                                            ->leftJoin(DB::raw('(select zones.code, cities.name from zones INNER join cities on zones.city_code = cities.code) as zone_city'), 'zone_city.code', '=', 'educational_institutions.zone_code')
                                                            ->distinct()
                                                            ->pluck('full_name', 'id')->toArray()
                                                    )
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->native(false)
                                                    ->searchable(),
                                                TextInput::make('level')
                                                    ->datalist(SchoolLevel::cases())
                                                    ->required(),
                                                TextInput::make('fovorite_subject')
                                                    ->required()
                                                    ->datalist(SchoolSuject::cases())
                                                    ->prefixIcon('heroicon-o-star')
                                                    ->suffixAction(
                                                        Action::make('Clean field')
                                                            ->icon('heroicon-o-x-circle')
                                                            ->action(fn(Set $set) => $set('fovorite_subject', '')),
                                                    ),

                                            ])
                                            ->hidden(fn(Get $get, $state) => count($get('reasons_leaving_study')) > 0)
                                            ->maxItems(1)
                                            ->defaultItems(0)
                                            ->columns(2),
                                        Repeater::make('reasons_leaving_study')
                                            ->relationship('reasons_leaving_study')
                                            ->schema([
                                                TextInput::make('reason')
                                                    ->columnSpanFull()
                                                    ->required(),
                                            ])
                                            ->hidden(fn(Get $get, $state) => count($get('educational_record')) > 0)
                                            ->maxItems(1)
                                            ->defaultItems(0),
                                    ]),
                            ]),
                        Step::make('Health Information')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Radio::make('health_status')
                                    ->options(HealthStatus::class)
                                    ->required()
                                    ->live()
                                    ->default(HealthStatus::Excellent)
                                    ->columnSpanFull(),
                                Section::make('Estado de salud del niño')
                                    ->relationship('health_status_record')
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                TextInput::make('especific_health_problems')
                                                    ->label('Mention in case the child has health problems')
                                                    ->columnSpanFull()
                                                    ->required(),
                                                TextInput::make('treatment')
                                                    ->label('Is the child following any treatment? (specify)')
                                                    ->columnSpanFull(),
                                            ])
                                            ->hidden(
                                                fn(Get $get, $state) => $state = HealthStatus::HasProblems !== $get('health_status')
                                            ),
                                        Repeater::make('discapacidad')
                                            ->relationship('disabilities')
                                            ->schema([
                                                Select::make('type')
                                                    ->options(Disability::class)
                                                    ->required()
                                                    ->native(false),
                                                TextInput::make('percent')
                                                    ->numeric()
                                                    ->required(),
                                            ])
                                            ->defaultItems(0)
                                            ->columns(2),
                                    ]),
                            ]),
                        Step::make('Baking Information')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make('Baking Information')
                                    ->schema([
                                        BankingInformationResource::getSchema(),
                                        Repeater::make('mobile_number')
                                            ->relationship('mobile_number')
                                            ->defaultItems(0)
                                            ->maxItems(1)
                                            ->schema([
                                                PhoneInput::make('number')
                                                    ->required()
                                                    ->unique(ignorable: fn ($record) => $record)
                                                    ->columnSpanFull(),
                                            ]),
                                    ])
                                    ->description('Fill out if and only if the child has his or her own bank account and is over 18, or has consent from the parent or representative.')
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->iconColor('danger'),

                            ]),
                        Step::make('Home information')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Select::make('family_nucleus_id')
                                    ->helperText('This information is shared by all affiliated children belonging to the same family nucleus.')
                                    ->relationship(
                                        'family_nucleus',
                                        'family_nuclei.id',
                                        fn($query) => $query->with('tutors')->select(
                                            'family_nuclei.id',
                                            DB::raw("GROUP_CONCAT(CONCAT(tutors.dni, ' - ', tutors.name) SEPARATOR ' : ') as full_name")
                                        )
                                            ->join('tutors', 'family_nuclei.id', '=', 'tutors.family_nucleus_id')
                                            ->groupBy('family_nuclei.id')
                                    )
                                    ->getOptionLabelFromRecordUsing(
                                        fn($record) => $record->full_name
                                    )
                                    ->searchable(['family_nuclei.id', 'tutors.name'])
                                    ->columnSpanFull()
                                    ->required()
                                    ->native(false)
                                    ->editOptionForm(fn(Form $form) => FamilyNucleusResource::form($form))
                                    ->createOptionForm(fn(Form $form) => FamilyNucleusResource::form($form)),
                                CheckboxList::make('expected_benefits')
                                    ->options(RisksChild::class),

                            ]),
                    ]
                )
                    ->startOnStep(fn($context) => 'create' === $context ? 1 : 2)
                    ->skippable(fn($context) => 'reate' !== $context)
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('case_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->badge(),
                TextColumn::make('birthdate')
                    ->formatStateUsing(
                        fn($state) => Carbon::parse($state)->age
                    )
                    ->badge()
                    ->label('Age'),
                TextColumn::make('affiliation_status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\Action::make('Family')
                    ->icon('heroicon-o-user-group')
                    ->color('gray')
                    ->url(fn(Child $record) => route('filament.admin.resources.family-nuclei.edit', $record->family_nucleus_id)),
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
                fn(Builder $query) => RecordBuilder::correspondingRecords($query)
            );
    }

    public static function getRelations(): array
    {
        return [

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
