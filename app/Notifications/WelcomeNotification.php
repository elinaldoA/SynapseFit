<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        // Você pode passar parâmetros ao construtor, se necessário
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bem-vindo ao SynapseFit!')
            ->greeting('Olá ' . $notifiable->name)
            ->line('Estamos felizes em tê-lo conosco.')
            ->action('Acessar o Sistema', url('/'))
            ->line('Obrigado por se registrar!')
            ->salutation('Atenciosamente, equipe SynapseFit.');
    }
}
