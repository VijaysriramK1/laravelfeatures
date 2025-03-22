<?php

namespace App\Observers;

use Carbon\Carbon;
use App\SmStudent;
use App\Jobs\Student\CreatedJob;


class SmStudentObserver
{
    /**
     * Handle the SmStudent "created" event.
     */
    public function created(SmStudent $smStudent): void
    {
        CreatedJob::dispatch($smStudent, 'studentcreated')->delay(Carbon::now()->addSeconds(10));
    }

    /**
     * Handle the SmStudent "updated" event.
     */
    public function updated(SmStudent $smStudent): void
    {
        //
    }

    /**
     * Handle the SmStudent "deleted" event.
     */
    public function deleted(SmStudent $smStudent): void
    {
        //
    }

    /**
     * Handle the SmStudent "restored" event.
     */
    public function restored(SmStudent $smStudent): void
    {
        //
    }

    /**
     * Handle the SmStudent "force deleted" event.
     */
    public function forceDeleted(SmStudent $smStudent): void
    {
        //
    }
}
