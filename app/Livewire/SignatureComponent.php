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
