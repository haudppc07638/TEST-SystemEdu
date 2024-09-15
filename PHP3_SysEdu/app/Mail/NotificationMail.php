<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $content;
    public $senderEmail;
    public $senderName;

    /**
     * Create a new message instance.
     *
     * @param string $title
     * @param string $content
     * @param string|null $senderEmail
     * @param string|null $senderName
     * @return void
     */
    public function __construct($title, $content, $senderEmail = null, $senderName = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
            from: new Address($this->senderEmail ?? config('mail.from.address'), $this->senderName ?? config('mail.from.name'))
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notification',
            with: [
                'title' => $this->title,
                'content' => $this->content,
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
