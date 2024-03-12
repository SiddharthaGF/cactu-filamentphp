<?php

namespace App\Observers;

use App\Enums\AffiliationStatus;
use App\Enums\StatusVigency;
use App\Models\Child;
use App\Models\Mailbox;

class ChildObserver
{
    /**
     * Handle the Child "created" event.
     */
    public function created(Child $child): void
    {
        Mailbox::create([
            'id' => $child->id,
            'vigency' => $child->affiliation_status == AffiliationStatus::Affiliated ? StatusVigency::Active : StatusVigency::Inactive,
        ]);
    }

    /**
     * Handle the Child "updated" event.
     */
    public function updated(Child $child): void
    {
        $mailbox = $child->mailbox;
        $mailbox->vigency = $child->affiliation_status == AffiliationStatus::Affiliated ? StatusVigency::Active : StatusVigency::Inactive;
        $mailbox->save();
    }

    /**
     * Handle the Child "deleted" event.
     */
    public function deleted(Child $child): void
    {
        //
    }
}
