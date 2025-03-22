<?php

namespace App\Mail\Staff;

use App\SmAssignSubject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarkLockRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $mail_subject;
    protected $get_mail_template;
    public function __construct(public SmAssignSubject $smAssignSubject)
    {
        $this->get_mail_template = DB::table('sms_templates')->where('type', 'email')->where('purpose', 'mark_lock_request')->where('school_id', $smAssignSubject->school_id)->first();

        if (!empty($this->get_mail_template)) {
            $this->mail_subject = $this->get_mail_template->subject ?? 'Mark Lock Request';
        } else {
            $this->mail_subject = 'Mark Lock Request';
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->smAssignSubject->teacher->email, $this->smAssignSubject->teacher->first_name ?? '' . ' ' . $this->smAssignSubject->teacher->last_name ?? '' ?? 'staff'),
            subject: '' . $this->mail_subject . '',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if (!empty($this->get_mail_template)) {
            $template = $this->get_mail_template->body;
        } else {
            $template = '';
        }

        $replacements = [
            '[competency_unit]' => $this->smAssignSubject->subject->subject_name ?? '',
            '[staff_name]' => $this->smAssignSubject->teacher->first_name ?? '' . ' ' . $this->smAssignSubject->teacher->last_name ?? '' ?? '',
            '[request_note]' => $this->smAssignSubject->marks_notes ?? '',
            '[staff_position]' => 'Teacher',
            '[staff_contact_no]' => $this->smAssignSubject->teacher->mobile ?? '',
        ];

        $content = strtr($template, $replacements);


        return new Content(
            view: 'emails.staff.marklockrequest',
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
