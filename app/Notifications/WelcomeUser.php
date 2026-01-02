<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeUser extends Notification
{
    public function __construct()
    {
        //
    }

    // Канали доставки: mail
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Як виглядає email
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ласкаво просимо в наш сервіс!')
            ->greeting('Привіт ' . $notifiable->name . '!')
            ->line('Дякуємо за реєстрацію. Ми раді бачити вас серед наших користувачів.')
            ->action('Перейти на сайт', url('/'))
            ->line('Якщо це не ви, просто ігноруйте цей лист.');
    }
}
