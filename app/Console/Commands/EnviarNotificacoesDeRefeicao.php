<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\RefeicaoNotification; // Supondo que você tenha uma notificação personalizada

class EnviarNotificacoesDeRefeicao extends Command
{
    protected $signature = 'notificar:refeicao {--tipo=}';  // Recebe o tipo de refeição como parâmetro
    protected $description = 'Envia notificações sobre a refeição do dia para os usuários';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tipoRefeicao = $this->option('tipo'); // Recebe o tipo de refeição do comando agendado

        if (!$tipoRefeicao) {
            $this->error('O tipo de refeição é obrigatório!');
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            // Enviar a notificação para o tipo específico de refeição
            $user->notify(new RefeicaoNotification($tipoRefeicao));
        }

        $this->info('Notificações de ' . $tipoRefeicao . ' enviadas com sucesso!');
    }
}
