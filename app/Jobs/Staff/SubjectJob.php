<?php

namespace App\Jobs\Staff;

use App\Models\User;
use App\SmAssignSubject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Staff\SubjectLockMail;
use App\Mail\Staff\SubjectUnlockMail;
use App\Mail\Staff\SubjectLockRequestMail;
use App\Mail\Staff\SubjectUnlockRequestMail;
use App\Mail\Staff\SubjectLockRejectMail;
use App\Mail\Staff\SubjectUnlockRejectMail;

class SubjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $user_mail_details;
    protected $set_mail_details;
    public function __construct(public SmAssignSubject $smAssignSubject, $get_status)
    {
        if ($get_status == 1) {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new SubjectUnlockMail($smAssignSubject);
        } else if ($get_status == 2) {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new SubjectLockMail($smAssignSubject);
        } else if ($get_status == 3) {
            $this->user_mail_details =  User::where('role_id', 1)->where('school_id', $smAssignSubject->school_id)->first();
            $this->set_mail_details = new SubjectLockRequestMail($smAssignSubject);
        } else if ($get_status == 4) {
            $this->user_mail_details =  User::where('role_id', 1)->where('school_id', $smAssignSubject->school_id)->first();
            $this->set_mail_details = new SubjectUnlockRequestMail($smAssignSubject);
        } else if ($get_status == 5) {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new SubjectUnlockRejectMail($smAssignSubject);
        } else if ($get_status == 6) {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new SubjectLockRejectMail($smAssignSubject);
        } else {
        }
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
