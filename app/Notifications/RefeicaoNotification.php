<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefeicaoNotification extends Notification
{
    private $refeicao;

    /**
     * Cria uma nova instância de notificação.
     *
     * @param string $refeicao Tipo da refeição (exemplo: café, almoço, lanche, jantar)
     */
    public function __construct($refeicao)
    {
        $this->refeicao = $refeicao;
    }

    /**
     * Determine os canais pelos quais a notificação será entregue.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Definindo os canais de envio (banco de dados e e-mail)
        return ['database', 'mail'];
    }

    /**
     * Preparar a notificação para o envio por e-mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Aqui você pode personalizar as mensagens dependendo do tipo de refeição
        $message = 'É hora de ' . ucfirst($this->refeicao) . '! Não se esqueça de se alimentar.';
        $line = 'Lembre-se de cuidar da sua alimentação para manter-se saudável.';

        // Se você quiser personalizar mais, pode adicionar condições para diferentes tipos de refeição
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
                    ->action('Veja mais', url('/')) // Caso queira adicionar um link na mensagem
                    ->line($line);
    }

    /**
     * Preparar a notificação para o envio para o banco de dados.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'É hora de ' . ucfirst($this->refeicao) . '! Não se esqueça de se alimentar.',
            'type' => 'reminder', // Definindo um tipo para a notificação (pode ser útil para categorizar)
            'refeicao' => $this->refeicao, // Incluindo a refeição como um dado adicional
        ];
    }
}
