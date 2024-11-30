<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;
    public $student;
    public $total_amount;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, $total_amount)
    {
        $this->student = $student;
        $this->total_amount = $total_amount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Success Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.payment',
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

    public function build()
    {
        return $this->subject('Thông báo thanh toán học phí thành công')
                    ->view('email.payment')
                    ->with([
                        'student' => $this->student,
                        'total_amount' => $this->total_amount,
                    ]);
    }
}
