<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public object $user;

    public function __construct(object $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Ласкаво просимо в наш сервіс!')
            ->view('emails.welcome-user') // створимо шаблон
            ->with(['user' => $this->user]);
    }
}
