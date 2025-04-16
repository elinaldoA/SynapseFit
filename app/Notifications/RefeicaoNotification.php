<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefeicaoNotification extends Notification
{
    private $refeicao;

    public function __construct($refeicao)
    {
        $this->refeicao = $refeicao;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $message = 'É hora de ' . ucfirst($this->refeicao) . '! Não se esqueça de se alimentar.';
        $line = 'Lembre-se de cuidar da sua alimentação para manter-se saudável.';

        if ($this->refeicao == 'café') {
            $line = 'Comece o dia com um bom café da manhã!';
        } elseif ($this->refeicao == 'almoço') {
            $line = 'Almoce bem para continuar o dia com energia!';
        } elseif ($this->refeicao == 'lanche') {
            $line = 'Faça um lanche para não ficar sem energia!';
        } elseif ($this->refeicao == 'jantar') {
            $line = 'Um jantar leve ajuda no seu descanso!';
        }

        return (new MailMessage)
                    ->line($message)
                    ->action('Veja mais', url('/'))
                    ->line($line);
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'É hora de ' . ucfirst($this->refeicao) . '! Não se esqueça de se alimentar.',
            'type' => 'reminder',
            'refeicao' => $this->refeicao,
        ];
    }
}
