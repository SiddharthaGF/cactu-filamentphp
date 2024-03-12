<?php

namespace App\Observers;

use App\Models\EducationalRecord;

class EducationalRecordObserver
{
    /**
     * Handle the EducationalRecord "created" event.
     */
    public function created(EducationalRecord $educationalRecord): void
    {
        $educationalRecord->child->reasons_leaving_study->delete();
    }

    /**
     * Handle the EducationalRecord "updated" event.
     */
    public function updated(EducationalRecord $educationalRecord): void
    {
        $educationalRecord->child->reasons_leaving_study->delete();
    }

    /**
     * Handle the EducationalRecord "deleted" event.
     */
    public function deleted(EducationalRecord $educationalRecord): void
    {
        //
    }

    /**
     * Handle the EducationalRecord "restored" event.
     */
    public function restored(EducationalRecord $educationalRecord): void
    {
        //
    }

    /**
     * Handle the EducationalRecord "force deleted" event.
     */
    public function forceDeleted(EducationalRecord $educationalRecord): void
    {
        //
    }
}
