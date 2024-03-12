<?php

namespace App\Observers;

use App\Models\ReasonsLeavingStudy;

class ReasonsLeavingStudyObserver
{
    /**
     * Handle the ReasonsLeavingStudy "created" event.
     */
    public function created(ReasonsLeavingStudy $reasonsLeavingStudy): void
    {
        $reasonsLeavingStudy->child->educational_record?->delete();
    }

    /**
     * Handle the ReasonsLeavingStudy "updated" event.
     */
    public function updated(ReasonsLeavingStudy $reasonsLeavingStudy): void
    {
        $reasonsLeavingStudy->child->educational_record?->delete();
    }

    /**
     * Handle the ReasonsLeavingStudy "deleted" event.
     */
    public function deleted(ReasonsLeavingStudy $reasonsLeavingStudy): void
    {
        //
    }

    /**
     * Handle the ReasonsLeavingStudy "restored" event.
     */
    public function restored(ReasonsLeavingStudy $reasonsLeavingStudy): void
    {
        //
    }

    /**
     * Handle the ReasonsLeavingStudy "force deleted" event.
     */
    public function forceDeleted(ReasonsLeavingStudy $reasonsLeavingStudy): void
    {
        //
    }
}
