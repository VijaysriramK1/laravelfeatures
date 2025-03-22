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
use App\Mail\Staff\MarkLockMail;
use App\Mail\Staff\MarkUnlockMail;
use App\Mail\Staff\MarkLockRequestMail;
use App\Mail\Staff\MarkUnlockRequestMail;
use App\Mail\Staff\MarkRejectedMail;

class MarkJob implements ShouldQueue
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

        if ($get_status == 'unlock') {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new MarkUnlockMail($smAssignSubject);
        } else if ($get_status == 'lock') {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new MarkLockMail($smAssignSubject);
        } else if ($get_status == 'lock request') {
            $this->user_mail_details =  User::where('role_id', 1)->where('school_id', $smAssignSubject->school_id)->first();
            $this->set_mail_details = new MarkLockRequestMail($smAssignSubject);
        } else if ($get_status == 'unlock request') {
            $this->user_mail_details =  User::where('role_id', 1)->where('school_id', $smAssignSubject->school_id)->first();
            $this->set_mail_details = new MarkUnlockRequestMail($smAssignSubject);
        } else if ($get_status == 'reject') {
            $this->user_mail_details =  $smAssignSubject->teacher;
            $this->set_mail_details = new MarkRejectedMail($smAssignSubject);
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
