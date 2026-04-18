<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PublicInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $payload)
    {
    }

    public function envelope(): Envelope
    {
        $subject = $this->payload['form_type'] === 'quote'
            ? 'New Quote Request from ' . $this->payload['user_name']
            : 'New Contact Form Submission from ' . $this->payload['user_name'];

        return new Envelope(
            replyTo: [$this->payload['user_email']],
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.public-inquiry',
            with: ['payload' => $this->payload],
        );
    }
}