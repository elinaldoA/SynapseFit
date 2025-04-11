<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ConsumoAguaNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Lembre-se de beber água! Não deixe de se hidratar ao longo do dia.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Lembre-se de beber água! Não deixe de se hidratar ao longo do dia.',
            'type' => 'reminder',
        ];
    }
}
