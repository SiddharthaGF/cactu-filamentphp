<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\MailStatus;
use App\Models\Mail;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

final class MailChangeStatusObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Mail "created" event.
     */
    public function created(Mail $mail): void
    {

    }

    /**
     * Handle the Mail "updated" event.
     */
    public function updated(Mail $mail): void
    {
        if ($mail->status->value === MailStatus::View->value) {
            $user = $mail->updater;
            Notification::make()
                ->title('Mail Viewed')
                ->info()
                ->body('Mail has been viewed')
                ->sendToDatabase($user);
        }
    }

    /**
     * Handle the Mail "deleted" event.
     */
    public function deleted(Mail $mail): void
    {

    }

    /**
     * Handle the Mail "restored" event.
     */
    public function restored(Mail $mail): void
    {

    }

    /**
     * Handle the Mail "force deleted" event.
     */
    public function forceDeleted(Mail $mail): void
    {

    }
}
