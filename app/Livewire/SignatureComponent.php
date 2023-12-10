<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Throwable;

final class SignatureComponent extends MyProfileComponent
{
    public ?array $data = [];
    protected string $view = 'livewire.signature-component';

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                SignaturePad::make('signature')
                    ->label(__('Sign here'))
                    ->dotSize(env('SIGNATURE_DOT_SIZE', 0.1))
                    ->lineMinWidth(env('SIGNATURE_LINE_MIN_WIDTH', 0.1))
                    ->lineMaxWidth(env('SIGNATURE_LINE_MAX_WIDTH', 2.5))
                    ->throttle(env('SIGNATURE_THROTTLE', 16))
                    ->minDistance(env('SIGNATURE_MIN_DISTANCE', 5))
                    ->velocityFilterWeight(env('SIGNATURE_VELOCITY_FILTER_WEIGHT', 0.7))
                    ->penColor(env('SIGNATURE_HEX_PEN_COLOR', '#000000'))
                    ->penColorOnDark(env('SIGNATURE_HEX_DARK_PEN_COLOR', env('SIGNATURE_HEX_PEN_COLOR', '#FFFFFF')))
                    ->downloadActionDropdownPlacement('center-end')
                    ->clearAction(fn (Action $action) => $action->button()->iconButton('heroicon-o-trash')
                        ->color('danger'))
                    ->downloadAction(fn (Action $action) => $action->color('primary'))
                    ->undoAction(fn (Action $action) => $action->icon('heroicon-o-arrow-uturn-left'))
                    ->doneAction(fn (Action $action) => $action->iconButton()->icon('heroicon-o-thumbs-up'))
                    ->required(),
            ])
            ->statePath('data');
    }

    public function mount(): void
    {
        $user = User::find(auth()->user()->id);
        $this->form->fill($user->toArray());
    }

    public function submit(): void
    {
        $user = User::find(auth()->user()->id);
        $user->signature = $this->form->getState()['signature'];
        try {
            $user->save();
            Notification::make()
                ->title('Signature saved')
                ->success()
                ->send();
        } catch (Throwable $th) {
            Notification::make()
                ->title('Error saving signature')
                ->error()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.signature-component');
    }
}
