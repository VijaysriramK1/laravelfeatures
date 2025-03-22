<?php

namespace App\Jobs\Student;

use App\SmAdmissionQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\AdmissionMail;

class AdmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $set_mail_details;
    public function __construct(public SmAdmissionQuery $smAdmissionQuery, $get_status)
    {
        if ($get_status == 'admissioncreated') {
            $this->set_mail_details = new AdmissionMail($smAdmissionQuery);
        } else {
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->set_mail_details) {
            Mail::to($this->smAdmissionQuery->email)->queue($this->set_mail_details);
        }
    }
}
