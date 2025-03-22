<?php

namespace App\Jobs\Student;

use App\SmStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\CreatedMail;


class CreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $set_mail_details;
    public function __construct(public SmStudent $smStudent, $get_status)
    {
        if ($get_status == 'studentcreated') {
            $this->set_mail_details = new CreatedMail($smStudent);
        } else {
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->set_mail_details) {
            Mail::to($this->smStudent->email)->queue($this->set_mail_details);
        }
    }
}
