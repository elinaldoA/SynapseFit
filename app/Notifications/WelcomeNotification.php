<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        // Pode receber dados aqui se precisar
    }

    public function via($notifiable)
    {
        return ['database','mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bem-vindo ao SynapseFit!')
            ->view('emails.welcome', ['user' => $notifiable]);
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Bem-vindo ao SynapseFit, ' . $notifiable->name . '!',
            'user_id' => $notifiable->id,
        ];
    }
}
