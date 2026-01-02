<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public object $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Скидання пароля')
            ->view('emails.reset-password')
            ->with(['data' => $this->data]);
    }
}
