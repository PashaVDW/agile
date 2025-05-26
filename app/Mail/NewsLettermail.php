<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsLettermail extends Mailable
{
    use Queueable, SerializesModels;



    public array $data;
    public string $pdf;
    public function __construct(array $data, string $pdf)
    {
        $this->data = $data;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Concat nieuwsbrief')
            ->markdown('emails.newsletter')
            ->with('data', $this->data)
            ->attachData($this->pdf, 'newsletter.pdf', [
                'mime' => 'application/pdf',
            ]);
    }


}
