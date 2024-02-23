<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App;
use App\Builder\RecordBuilder;
use App\Enums\ActivityForFamilySupport;
use App\Enums\ActivityForRecreation;
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
use App\Models\User;
use Blade;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Pdf;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

final class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 3;

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'dni', 'children_number', 'case_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('Dni') => $record->dni,
            __('Affiliation status') => $record->affiliation_status->getLabel(),
            __('Children number') => $record->children_number,
            __('Case number') => $record->case_number,
        ];
    }

    public static function getLabel(): ?string
    {
        return __("Child");
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return ChildResource::getUrl('edit', ['record' => $record]);
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            \Filament\GlobalSearch\Actions\Action::make('edit')
                ->icon('heroicon-o-pencil-square')
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make(
                    [
                        Step::make(__('General information'))
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make(__('Sponsor Information'))
                                    ->description(__('This information is provided by ChildFund.'))
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->aside()
                                    ->compact()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('children_number')
                                            ->translateLabel()
                                            ->minValue(0)
                                            ->placeholder(__('Assigned by coordinator'))
                                            ->numeric(),
                                        TextInput::make('case_number')
                                            ->translateLabel()
                                            ->placeholder(__('Assigned by coordinator'))
                                            ->minValue(0)
                                            ->numeric(),
                                        Select::make('affiliation_status')
                                            ->translateLabel()
                                            ->options(AffiliationStatus::class)
                                            ->default(AffiliationStatus::Pending)
                                            ->native(false)
                                            ->dehydrated()
                                            ->required(),
                                        Select::make('manager_id')
                                            ->label('Manager in charge')
                                            ->required()
                                            ->translateLabel()
                                            ->native(false)
                                            ->default(auth()->user()->id)
                                            ->dehydrated()
                                            ->options(fn () => User::byRole('gestor')->pluck('name', 'id')),
                                    ])
                                    ->disabled(fn () => !auth()->user()->hasRole('super_admin')),
                                Section::make(__('Personal Information'))
                                    ->description(__('Fill out the information of the child.'))
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->aside()
                                    ->compact()
                                    ->schema([
                                        FileUpload::make('child_photo_path')
                                            ->label('Child photo')
                                            ->translateLabel()
                                            ->imageEditor()
                                            ->imageCropAspectRatio("3.5:4")
                                            ->image(),
                                        TextInput::make('name')
                                            ->translateLabel()
                                            ->prefixIcon('heroicon-o-user')
                                            ->required(),
                                        TextInput::make('dni')
                                            ->translateLabel()
                                            ->required()
                                            ->prefixIcon('heroicon-o-identification')
                                            ->disabledOn('edit'),
                                        TextInput::make('pseudonym')
                                            ->translateLabel()
                                            ->prefixIcon('heroicon-o-bug-ant')
                                            ->required(),
                                        DatePicker::make('birthdate')
                                            ->translateLabel()
                                            ->required()
                                            ->reactive()
                                            ->prefixIcon('heroicon-o-calendar')
                                            ->closeOnDateSelection()
                                            ->maxDate(Carbon::now()),
                                        Select::make('gender')
                                            ->translateLabel()
                                            ->options(Gender::class)
                                            ->native(false)
                                            ->required()
                                            ->prefixIcon('heroicon-o-sparkles'),
                                        Select::make('sexual_identity')
                                            ->translateLabel()
                                            ->options(SexualIdentity::class)
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-heart')
                                            ->required(),
                                    ]),
                            ]),
                        Step::make(__('Educational Information'))
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Select::make('literacy')
                                    ->columnSpanFull()
                                    ->label(__('Literacy (It was detected that the child is older than 5 years)'))
                                    ->selectablePlaceholder(false)
                                    ->options(Literacy::class)
                                    ->default(Literacy::None)
                                    ->native(false)
                                    ->hidden(fn (Get $get) => Carbon::parse($get('birthdate'))->age <= 5)
                                    ->required(),
                                Group::make()
                                    ->schema([
                                        Repeater::make('educational_record')
                                            ->translateLabel()
                                            ->relationship('educational_record')
                                            ->schema([
                                                Radio::make('status')
                                                    ->translateLabel()
                                                    ->options(EducationalStatus::class)
                                                    ->columnSpanFull()
                                                    ->disableOptionWhen(fn (string $value): bool => 'published' === $value)
                                                    ->required(),
                                                Select::make('educational_institution_id')
                                                    ->prefixIcon('heroicon-o-academic-cap')
                                                    ->label('Educational Institution')
                                                    ->translateLabel()
                                                    ->options(
                                                        fn () => EducationalInstitution::select([
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
                                                    ->prefixIcon('heroicon-o-hashtag')
                                                    ->translateLabel()
                                                    ->datalist(SchoolLevel::getTranslatedLevels())
                                                    ->required(),
                                                TextInput::make('fovorite_subject')
                                                    ->translateLabel()
                                                    ->required()
                                                    ->datalist(SchoolSuject::getTranslatedLevels())
                                                    ->prefixIcon('heroicon-o-star')
                                                    ->suffixAction(
                                                        Action::make('Clean field')
                                                            ->icon('heroicon-o-x-circle')
                                                            ->action(fn (Set $set) => $set('fovorite_subject', '')),
                                                    ),

                                            ])
                                            ->hidden(fn (Get $get, $state) => count($get('reasons_leaving_study')) > 0)
                                            ->maxItems(1)
                                            ->columns()
                                            ->defaultItems(0),
                                        Repeater::make('reasons_leaving_study')
                                            ->translateLabel()
                                            ->relationship('reasons_leaving_study')
                                            ->schema([
                                                TextInput::make('reason')
                                                    ->translateLabel()
                                                    ->columnSpanFull()
                                                    ->required(),
                                            ])
                                            ->hidden(fn (Get $get, $state) => count($get('educational_record')) > 0)
                                            ->maxItems(1)
                                            ->defaultItems(0),
                                    ])
                            ]),
                        Step::make('Health Information')
                            ->translateLabel()
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Radio::make('health_status')
                                    ->translateLabel()
                                    ->options(HealthStatus::class)
                                    ->required()
                                    ->reactive()
                                    ->default(HealthStatus::Excellent)
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 4,
                                    ])
                                    ->columnSpanFull(),
                                Group::make()
                                    ->relationship('health_status_record')
                                    ->schema([
                                        TextInput::make('especific_health_problems')
                                            ->label('Mention in case the child has health problems')
                                            ->translateLabel()
                                            ->columnSpanFull()
                                            ->required(),
                                        TextInput::make('treatment')
                                            ->label('Is the child following any treatment? (specify)')
                                            ->translateLabel()
                                            ->columnSpanFull(),
                                    ])
                                    ->hidden(
                                        fn (Get $get, $state) => $state = HealthStatus::HasProblems !== $get('health_status')
                                    ),
                                Repeater::make('disabilities')
                                    ->translateLabel()
                                    ->relationship('disabilities')
                                    ->schema([
                                        Select::make('type')
                                            ->translateLabel()
                                            ->options(Disability::class)
                                            ->required()
                                            ->native(false),
                                        TextInput::make('percent')
                                            ->numeric()
                                            ->translateLabel()
                                            ->required(),
                                    ])
                                    ->defaultItems(0)
                                    ->columns(2),

                            ]),
                        Step::make('Baking Information')
                            ->translateLabel()
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make(__('Baking Information'))
                                    ->schema([
                                        BankingInformationResource::getSchema(),
                                        Repeater::make('mobile_number')
                                            ->relationship('mobile_number')
                                            ->translateLabel()
                                            ->defaultItems(0)
                                            ->maxItems(1)
                                            ->schema([
                                                PhoneInput::make('number')
                                                    ->required()
                                                    ->translateLabel()
                                                    ->unique(ignorable: fn ($record) => $record)
                                                    ->columnSpanFull(),
                                            ]),
                                    ])
                                    ->description(__('Fill out if and only if the child has his or her own bank account and is over 18, or has consent from the parent or representative.'))
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->iconColor('danger'),

                            ]),
                        Step::make('Home information')
                            ->translateLabel()
                            ->icon('heroicon-o-home')
                            ->schema([
                                Select::make('family_nucleus_id')
                                    ->label('Family')
                                    ->translateLabel()
                                    ->helperText(__('This information is shared by all affiliated children belonging to the same family.'))
                                    ->relationship(
                                        'family_nucleus',
                                        'family_nuclei.id',
                                        fn ($query) => RecordBuilder::correspondingRecords($query)->with('tutors')->select(
                                            'family_nuclei.id',
                                            DB::raw("GROUP_CONCAT(CONCAT(tutors.dni, ' - ', tutors.name) SEPARATOR ' : ') as full_name")
                                        )
                                            ->join('tutors', 'family_nuclei.id', '=', 'tutors.family_nucleus_id')
                                            ->groupBy('family_nuclei.id')
                                    )
                                    ->getOptionLabelFromRecordUsing(
                                        fn ($record) => $record->full_name
                                    )
                                    ->searchable(['family_nuclei.id', 'tutors.name'])
                                    ->columnSpanFull()
                                    ->required()
                                    ->native(false)
                                    ->editOptionForm(fn (Form $form) => FamilyNucleusResource::form($form))
                                    ->editOptionAction(
                                        fn (Action $action) => $action->modalWidth('5xl')
                                            ->slideOver()
                                    )
                                    ->createOptionForm(fn (Form $form) => FamilyNucleusResource::form($form))
                                    ->createOptionAction(
                                        fn (Action $action) => $action->modalWidth('5xl')
                                            ->slideOver()
                                    ),
                                CheckboxList::make('risks_child')
                                    ->label('¿What are the main reasons why the boy or girl will benefit from being enrolled in ChildFund? (under 15 years old)')
                                    ->translateLabel()
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 5,
                                    ])
                                    ->bulkToggleable()
                                    ->options(RisksChild::class),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('language')
                                            ->translateLabel()
                                            ->options(Language::class)
                                            ->default(Language::Spanish)
                                            ->reactive()
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-language')
                                            ->required(),
                                        TextInput::make('specific_language')
                                            ->translateLabel()
                                            ->hidden(
                                                fn (Get $get) => Language::Other !== $get('language')
                                            )
                                            ->required(),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('ethnic_group')
                                            ->translateLabel()
                                            ->options(EthnicGroup::class)
                                            ->native(false)
                                            ->required()
                                            ->prefixIcon('heroicon-o-user-group')
                                            ->live(),
                                        TextInput::make('specific_ethnic_group')
                                            ->translateLabel()
                                            ->hidden(
                                                fn (Get $get) => EthnicGroup::Other !== $get('ethnic_group')
                                            )
                                            ->required(),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        Select::make('nationality')
                                            ->translateLabel()
                                            ->reactive()
                                            ->options(Nationality::class)
                                            ->default(Nationality::Ecuadorian)
                                            ->native(false)
                                            ->prefixIcon('heroicon-o-globe-americas')
                                            ->required(),
                                        TextInput::make('specific_nationality')
                                            ->translateLabel()
                                            ->hidden(
                                                fn (Get $get) => Nationality::Other !== $get('nationality')
                                            )
                                            ->required(),
                                    ]),
                                TextInput::make('religious')
                                    ->translateLabel()
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
                                            ->action(fn (Set $set) => $set('religious', '')),
                                    ),
                                Select::make('migratory_status')
                                    ->translateLabel()
                                    ->options(MigratoryStatus::class)
                                    ->default(MigratoryStatus::None)
                                    ->native(false)
                                    ->prefixIcon('heroicon-o-globe-americas')
                                    ->required(),
                                CheckboxList::make('activities_for_family_support')
                                    ->translateLabel()
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 5,
                                    ])
                                    ->bulkToggleable()
                                    ->options(ActivityForFamilySupport::class)
                                    ->columns(5)
                                    ->columnSpanFull(),
                                TextInput::make('specific_activities_for_family_support')
                                    ->translateLabel()
                                    ->columnSpanFull(),
                                CheckboxList::make('recreation_activities')
                                    ->translateLabel()
                                    ->columns([
                                        'sm' => 2,
                                        'md' => 5,
                                    ])
                                    ->bulkToggleable()
                                    ->options(ActivityForRecreation::class)
                                    ->columns(5)
                                    ->columnSpanFull(),
                                TextInput::make('specific_recreation_activities')
                                    ->translateLabel()
                                    ->columnSpanFull(),
                                Group::make()
                                    ->schema([
                                        Textarea::make('physical_description')
                                            ->translateLabel()
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->required(),
                                        Textarea::make('aspirations')
                                            ->required()
                                            ->columnSpanFull()
                                            ->label("What are your future aspirations? (in the case of children under 3 years old, what are the family's aspirations)")->translateLabel()
                                            ->rows(3),
                                        Textarea::make('personality')
                                            ->label("List 3 personality traits [happy, serious, playful, etc]")
                                            ->translateLabel()
                                            ->required()
                                            ->rows(3),
                                        Textarea::make('skills')
                                            ->label("List 3 skills and aptitudes [psychomotor development, memorizing, reasoning, etc]")
                                            ->translateLabel()
                                            ->rows(3),
                                        Textarea::make('likes')
                                            ->label("What do you like? (food, music, colors, pets)")
                                            ->translateLabel()
                                            ->rows(3),
                                        Textarea::make('dislikes')
                                            ->label("What doesn't the boy or girl like? (eat, play, be told, from school or the community)")
                                            ->translateLabel()
                                            ->rows(3),
                                    ])
                                    ->columns([
                                        'sm' => 2,
                                        'lg' => 3,
                                    ]),
                                SignaturePad::make('signature')
                                    ->label(__('Sign here'))
                                    ->dotSize(config('signature.dot-size'))
                                    ->lineMinWidth(config('signature.line-min-width'))
                                    ->lineMaxWidth(config('signature.line-max-width'))
                                    ->throttle(config('signature.throttle'))
                                    ->minDistance(config('signature.min-distance'))
                                    ->velocityFilterWeight(config('signature.velocity-filter-weight'))
                                    ->penColor(config('signature.hex-pen-color'))
                                    ->penColorOnDark(config('signature.hex-dark-pen-color'))
                                    ->downloadActionDropdownPlacement('center-end')
                                    ->clearAction(
                                        fn (Action $action) => $action->button()->iconButton()
                                            ->color('danger')
                                    )
                                    ->downloadAction(fn (Action $action) => $action->color('primary'))
                                    ->undoAction(fn (Action $action) => $action->icon('heroicon-o-arrow-uturn-left'))
                                    ->doneAction(fn (Action $action) => $action->iconButton()->icon('heroicon-o-thumbs-up'))
                                    ->required()
                            ]),

                    ]
                )
                    ->startOnStep(fn ($context) => 'create' === $context ? 1 : 2)
                    ->skippable(fn ($context) => 'create' !== $context)
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('child_photo_path')
                        ->defaultImageUrl(fn (Model $record) => $record->getFilamentAvatarUrl())
                        ->circular()
                        ->grow(false)
                        ->alignEnd()
                        ->visibleFrom('md'),
                    Tables\Columns\Layout\Stack::make([
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
                        Tables\Columns\Layout\Split::make([
                            TextColumn::make('gender')
                                ->translateLabel()
                                ->badge(),
                            TextColumn::make('birthdate')
                                ->translateLabel()
                                ->formatStateUsing(
                                    fn ($state) => Carbon::parse($state)->age . ' ' . __('years')
                                )
                                ->badge()
                                ->label('Age'),
                            TextColumn::make('affiliation_status')
                                ->translateLabel()
                                ->badge(),
                        ]),
                    ])
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('Sheet')
                    ->translateLabel()
                    ->icon('heroicon-o-document-text')
                    ->color(Color::Stone)
                    ->url(fn (Child $record) => route('sheet', $record->id)),
                Tables\Actions\Action::make('Family')
                    ->translateLabel()
                    ->icon('heroicon-o-user-group')
                    ->color(Color::Amber)
                    ->disabled(fn (Child $record) => is_null($record->family_nucleus_id))
                    ->url(fn (Child $record) => FamilyNucleusResource::getUrl('edit', [$record->family_nucleus_id ?? 0])),
                Tables\Actions\Action::make('Mailbox')
                    ->translateLabel()
                    ->icon('heroicon-o-envelope')
                    ->color('success')
                    ->url(fn (Child $record) => MailboxResource::getUrl('edit', [$record->id])),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exports([
                    ExcelExport::make('All the information')->fromModel(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->modifyQueryUsing(
                fn (Builder $query) => RecordBuilder::correspondingRecords($query)
            );
    }

    public static function getRelations(): array
    {
        return [];
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
