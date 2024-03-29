<?php

declare(strict_types=1);

namespace App\Filament\Resources\MailBoxResource\RelationManagers;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Models\Mail;
use Exception;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class MailRelationManager extends RelationManager
{
    protected static string $relationship = 'mails';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Outgoing');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->translateLabel()
                    ->disabled(function (?Mail $record, string $context) {
                        $status = $record ? $record->status : null;

                        return $status === MailStatus::Response && $context == 'edit';
                    })
                    ->required()
                    ->native(false)
                    ->options(MailsTypes::class)
                    ->default(MailsTypes::Response),
                Select::make('status')
                    ->disabled(function (?Mail $record, string $context) {
                        $status = $record ? $record->status : null;

                        return $status === MailStatus::Response && $context == 'edit';
                    })
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->options(MailStatus::class)
                    ->default(MailStatus::Created),
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
                        'sm' => 2,
                    ])
                    ->schema([
                        FileUpload::make('letter')
                            ->translateLabel()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxFiles(1)
                            ->afterStateUpdated(
                                function (Get $get, Set $set) {
                                    $temp = array_key_first($get('letter'));
                                    $path = $get('letter')[$temp]->getRealPath();
                                    $parser = new \Smalot\PdfParser\Parser();
                                    $content = $parser->parseFile($path);
                                    $set('content', $content->getText());
                                }
                            )
                            ->storeFiles(false),
                        SpatieMediaLibraryFileUpload::make('attached_file_path')
                            ->image()
                            ->translateLabel()
                            ->imageEditor()
                            ->downloadable()
                            ->required()
                            ->maxFiles(1)
                            ->collection('answers'),
                        Textarea::make('content')
                            ->helperText(__("The content can be filled by writing directly in this field or by uploading the letter in pdf format in the 'Letter' field"))
                            ->translateLabel()
                            ->dehydrated()
                            ->columnSpanFull()
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
                Tables\Columns\TextColumn::make('status')
                    ->translateLabel()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make()
                    ->name('Notify')
                    ->color(Color::Green)
                    ->translateLabel()
                    //->hidden(fn (Mail $record) => $record->status === MailStatus::Response)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->action(function (Mail $record): void {
                        try {
                            $record->mailbox->child->NotifyMails($record->id);
                            Notification::make()
                                ->title(__('Sent to whatsapp successfully'))
                                ->success()
                                ->send();
                            $record->update(['status' => MailStatus::Sent]);
                        } catch (Exception $e) {
                            Notification::make()
                                ->title(__('Error sending to whatsapp'))
                                ->danger()
                                ->send();
                        }
                    }),
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
                fn (Builder $query) => $query->whereReplyMailId(null)->orderBy('id', 'desc')
            );
    }

    protected static function getPluralModelLabel(): ?string
    {
        return __('Mails');
    }
}
