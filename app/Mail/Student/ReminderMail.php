<?php

namespace App\Mail\Student;

use App\SmSchool;
use Carbon\Carbon;
use App\SmAdmissionQuery;
use Illuminate\Bus\Queueable;
use App\Models\SmAdmissionQueryReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $mail_subject;
    protected $get_mail_template;
    public function __construct(public SmAdmissionQueryReminder $smAdmissionQueryReminder)
    {
        $this->get_mail_template = DB::table('sms_templates')->where('type', 'email')->where('purpose', 'reminder_notification')->first();

        if (!empty($this->get_mail_template)) {
            $this->mail_subject = $this->get_mail_template->subject ?? 'Reminder Notification';
        } else {
            $this->mail_subject = 'Reminder Notification';
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '' . $this->mail_subject . '',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $get_admission_details = SmAdmissionQuery::where('id', $this->smAdmissionQueryReminder->admission_query_id)->first();
        $reminder_date = Carbon::parse($this->smAdmissionQueryReminder->reminder_at)->format('F j, Y');
        $reminder_time = Carbon::parse($this->smAdmissionQueryReminder->reminder_at)->format('g:iA');
        $get_school_details = SmSchool::where('id', $get_admission_details->school_id)->first();

        if (!empty($this->get_mail_template)) {
            $template = $this->get_mail_template->body;
        } else {
            $template = '';
        }

        $replacements = [
            '[name]' => $get_admission_details->name ?? '',
            '[reminder_subject]' => 'you',
            '[reminder_details]' => $this->smAdmissionQueryReminder->reminder_notes ?? '',
            '[reminder_date]' => $reminder_date ?? '',
            '[reminder_time]' => $reminder_time ?? '',
            '[school_name]' => $get_school_details->school_name ?? '',
        ];
        $content = strtr($template, $replacements);

        return new Content(
            view: 'emails.students.reminder',
            with: [
                'template' => $content,
                'template_subject' => $this->mail_subject
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
