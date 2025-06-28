<?php

namespace App\Mail;

use App\Models\FormEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class FormEntryRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formEntry;

    /**
     * Create a new message instance.
     */
    public function __construct(FormEntry $formEntry)
    {
        $this->formEntry = $formEntry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('sample@sample.jp', '株式会社◯◯◯'),
            subject: '【株式会社◯◯◯】エントリーありがとうございます',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.form_entry_registered',
            with: ['formEntry' => $this->formEntry]
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
