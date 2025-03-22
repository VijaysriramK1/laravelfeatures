<?php

namespace App\Jobs;

use App\Mail\ReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $admissionQuery;

    protected $reminder;

    public function __construct($admissionQuery, $reminder)
    {
        $this->admissionQuery = $admissionQuery;
        $this->reminder = $reminder;
    }

    public function handle()
    {
        Mail::to($this->admissionQuery->email)->send(new ReminderNotification($this->admissionQuery, $this->reminder));
    }
}
