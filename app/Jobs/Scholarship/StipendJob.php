<?php

namespace App\Jobs\Scholarship;

use Illuminate\Bus\Queueable;
use App\Models\StipendPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Scholarship\StipendMail;

class StipendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tries = 5;

    /**
     * Create a new job instance.
     */

    protected $user_mail_details;
    protected $set_mail_details;
    public function __construct(public StipendPayment $stipendPayment, $get_status)
    {
        if ($get_status == 'paymentcredited') {
            $this->user_mail_details =  $stipendPayment->student;
            $this->set_mail_details = new StipendMail($stipendPayment);
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
