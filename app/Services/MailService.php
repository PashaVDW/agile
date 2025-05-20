<?php

namespace App\Services;

use App\Mail\TestMailableMail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendTestMail(string $toEmail, string $message): void
    {
        Mail::to($toEmail)->send(new TestMailableMail($message));
    }
}
