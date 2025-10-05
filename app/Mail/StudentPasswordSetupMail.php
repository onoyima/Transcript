<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentPasswordSetupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $token;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, $token)
    {
        $this->student = $student;
        $this->token = $token;
        $this->resetUrl = url('/student/password/reset/' . $token);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Setup - Transcript System',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student_password_setup',
            with: [
                'student' => $this->student,
                'resetUrl' => $this->resetUrl,
                'username' => $this->student->username ?: $this->student->email
            ]
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