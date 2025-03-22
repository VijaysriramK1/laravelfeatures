<?php

namespace App\Jobs\Scholarship;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\StudentScholarship;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Scholarship\ScholarshipMail;

class ScholarshipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $user_mail_details;
    protected $set_mail_details;
    public function __construct(public StudentScholarship $studentScholarship, $get_status)
    {
        if ($get_status == 'studentassigned') {
            $this->user_mail_details =  User::where('role_id', 1)->first();
            $this->set_mail_details = new ScholarshipMail($studentScholarship);
        } else {}
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->set_mail_details) {
            Mail::to($this->user_mail_details->email)->queue($this->set_mail_details);
        }
    }
}
