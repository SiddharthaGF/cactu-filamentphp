<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailBoxResource\RelationManagers;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Models\Mail;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class MailInRelationManager extends RelationManager
{
    protected static string $relationship = 'mails';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Incoming');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns([
                'sm' => 3,
            ])
            ->schema([
                Select::make('reply_mail_id')
                    ->translateLabel()
                    ->relationship(
                        'mails',
                        'id',
                        fn (Builder $query) => $query
                            ->where('mailbox_id', $this->getOwnerRecord()->id)
                            ->where('status', '!=', MailStatus::Response)
                            ->where('status', '!=', MailStatus::Replied)
                            ->whereNull('reply_mail_id'),
                    )
                    ->disabled(
                        fn (Get $get) => $get('reply_mail_id') != null
                    )
                    ->native(false),
                Select::make('type')
                    ->translateLabel()
                    ->disabled(function (?Mail $record, string $context) {
                        $status = $record ? $record->status : null;

                        return $status === MailStatus::Response && $context == 'edit';
                    })
                    ->required()
                    ->native(false)
                    ->options(MailsTypes::class)
                    ->default(MailsTypes::Thanks),
                Select::make('status')
                    ->disabled()
                    ->dehydrated()
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->options(MailStatus::class)
                    ->default(MailStatus::Response),
                Repeater::make('Answers')
                    ->translateLabel()
                    ->relationship('answers')
                    ->required()
                    ->minItems(1)
                    ->maxItems(
                        function (?Mail $record, string $context) {
                            $status = $record ? $record->status : null;

                            return match ($status) {
                                MailStatus::Response => 1,
                                default => 10,
                            };
                        })
                    ->deletable(
                        function (?Mail $record, string $context) {
                            $status = $record ? $record->status : null;
                            if ($context == 'create') {
                                return true;
                            }

                            return $status !== MailStatus::Response;
                        })
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 3,
                    ])
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('attached_file_path')
                            ->image()
                            ->translateLabel()
                            ->imageEditor()
                            ->downloadable()
                            ->required()
                            ->maxFiles(1)
                            ->collection('answers'),
                        Textarea::make('content')
                            ->columnSpan(2)
                            ->translateLabel()
                            ->dehydrated()
                            ->rows(10)
                            ->required(),

                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->badge(),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make()
                    ->name('Download')
                    ->translateLabel()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Mail $record) => route('letter1', $record->answers->first()), true),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

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
                fn (Builder $query) => $query->with('answers')->whereNotNull('reply_mail_id')->orderBy('id', 'desc')
            );
    }

    protected static function getPluralModelLabel(): ?string
    {
        return __('Mails');
    }
}
