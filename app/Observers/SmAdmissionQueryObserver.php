<?php

namespace App\Observers;

use Carbon\Carbon;
use App\SmAdmissionQuery;
use App\Jobs\Student\AdmissionJob;
use Illuminate\Support\Facades\Session;

class SmAdmissionQueryObserver
{
    /**
     * Handle the SmAdmissionQuery "created" event.
     */
    public function created(SmAdmissionQuery $smAdmissionQuery): void
    {
        try {

            AdmissionJob::dispatch($smAdmissionQuery, 'admissioncreated')->delay(Carbon::now()->addSeconds(10));
            Session::flash('success', 'Created Successfully. Please check your mail to see more details');
        } catch (\Exception $e) {

            Session::flash('success', 'Created Successfully. We will send you the Mail soon.');
        }
    }

    /**
     * Handle the SmAdmissionQuery "updated" event.
     */
    public function updated(SmAdmissionQuery $smAdmissionQuery): void
    {
        //
    }

    /**
     * Handle the SmAdmissionQuery "deleted" event.
     */
    public function deleted(SmAdmissionQuery $smAdmissionQuery): void
    {
        //
    }

    /**
     * Handle the SmAdmissionQuery "restored" event.
     */
    public function restored(SmAdmissionQuery $smAdmissionQuery): void
    {
        //
    }

    /**
     * Handle the SmAdmissionQuery "force deleted" event.
     */
    public function forceDeleted(SmAdmissionQuery $smAdmissionQuery): void
    {
        //
    }
}
