<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public object $user;
    public string $verifyUrl;

    public function __construct(object $user)
    {
        $this->user = $user;

        // Генеруємо кастомне посилання
        $token = bin2hex(random_bytes(32)); // токен для підтвердження
        $this->verifyUrl = url("/verify-email/{$user->id}/{$token}");

        // Зберігаємо токен у таблиці (можеш створити окрему таблицю email_verifications)
        \DB::table('email_verifications')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
        ]);
    }

    public function build()
    {
        return $this->subject('Підтвердження електронної пошти')
            ->view('emails.verify-email')
            ->with([
                'name' => $this->user->name,
                'verifyUrl' => $this->verifyUrl
            ]);
    }
}
