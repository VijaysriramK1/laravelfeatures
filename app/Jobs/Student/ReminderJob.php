<?php

namespace App\Jobs\Student;

use App\SmAdmissionQuery;
use Illuminate\Bus\Queueable;
use App\Models\SmAdmissionQueryReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\ReminderMail;

class ReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $user_details;
    protected $set_mail_details;
    public function __construct(public SmAdmissionQueryReminder $smAdmissionQueryReminder, $get_status)
    {
        if ($get_status == 'remindercreated') {
            $get_details = SmAdmissionQuery::where('id', $smAdmissionQueryReminder->admission_query_id)->first();
            $this->user_details =  $get_details->email;
            $this->set_mail_details = new ReminderMail($smAdmissionQueryReminder);
        } else {
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->set_mail_details) {
            Mail::to($this->user_details)->queue($this->set_mail_details);
        }
    }
}
