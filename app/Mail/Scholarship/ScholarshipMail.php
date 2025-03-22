<?php

namespace App\Mail\Scholarship;

use App\SmSchool;
use Illuminate\Bus\Queueable;
use App\Models\StudentScholarship;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ScholarshipMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $mail_subject;
    protected $get_mail_template;
    public function __construct(public StudentScholarship $studentScholarship)
    {
        $this->get_mail_template = DB::table('sms_templates')->where('type', 'email')->where('purpose', 'student_assigned_scholarship')->first();

        if (!empty($this->get_mail_template)) {
            $this->mail_subject = $this->get_mail_template->subject ?? 'Student Assigned Scholarship';
        } else {
            $this->mail_subject = 'Student Assigned Scholarship';
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
        $get_school_details = SmSchool::orderBy('id', 'asc')->first();

        if (!empty($this->get_mail_template)) {
            $template = $this->get_mail_template->body;
        } else {
            $template = '';
        }

        $replacements = [
            '[school_name]' => $get_school_details->school_name ?? '',
            '[student_name]' => $this->studentScholarship->student->first_name ?? '' . ' ' . $this->studentScholarship->student->last_name ?? '' ?? '',
            '[assigned_scholarship]' => $this->studentScholarship->Scholarship->name ?? '',
        ];

        $content = strtr($template, $replacements);


        return new Content(
            view: 'emails.scholarships.scholarship',
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
