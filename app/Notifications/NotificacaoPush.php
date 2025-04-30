<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Minishlink\WebPush\WebPushMessage;
use Minishlink\WebPush\Subscription;

class NotificacaoPush extends Notification
{
    public $mensagem;

    public function __construct($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    public function via($notifiable)
    {
        return ['webpush'];
    }

    public function toWebPush($notifiable)
    {
        $subscription = json_decode($notifiable->pushSubscription->subscription, true);
        $subscription = Subscription::create([
            'endpoint' => $subscription['endpoint'],
            'publicKey' => $subscription['keys']['p256dh'],
            'authToken' => $subscription['keys']['auth'],
        ]);

        return (new WebPushMessage)
            ->title('Nova notificação')
            ->body($this->mensagem)
            ->icon('/icone.png');
    }
}
