<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifactionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public array $payload;
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->markdown('emails.notifaction')->subject($this->payload['subject']);
    }
}
