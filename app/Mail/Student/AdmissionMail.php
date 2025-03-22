<?php

namespace App\Mail\Student;

use App\SmSchool;
use Carbon\Carbon;
use App\SmAdmissionQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $mail_subject;
    protected $get_mail_template;
    public function __construct(public SmAdmissionQuery $smAdmissionQuery)
    {
        $this->get_mail_template = DB::table('sms_templates')->where('type', 'email')->where('purpose', 'student_registration_payments')->where('school_id', $smAdmissionQuery->school_id)->first();

        if (!empty($this->get_mail_template)) {
            $this->mail_subject = $this->get_mail_template->subject ?? 'Welcome to SG Academy';
        } else {
            $this->mail_subject = 'Welcome to SG Academy';
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
        $get_school_details = SmSchool::where('id', $this->smAdmissionQuery->school_id)->first();
        $invoice_info = DB::table('admission_fees_invoices')->where('student_id', $this->smAdmissionQuery->id)->first();
        $invoice_details = DB::table('admission_fees_invoice_chields')->where('admission_fees_invoice_id', $invoice_info->id)->first();


        if (!empty($this->get_mail_template)) {
            $template = $this->get_mail_template->body;
        } else {
            $template = '';
        }

        $replacements = [
            '[student_name]' => $this->smAdmissionQuery->name ?? '',
            '[amount]' => $invoice_details->amount ?? '',
            '[fine]' => $invoice_details->fine ?? '--',
            '[status]' => $invoice_info->payment_status ?? '',
            '[school_email]' => $get_school_details->email ?? '',
            '[school_name]' => $get_school_details->school_name ?? '',
        ];

        $content = strtr($template, $replacements);
        return new Content(
            view: 'emails.students.admission',
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
