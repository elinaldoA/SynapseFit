<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\RefeicaoNotification;

class EnviarNotificacoesDeRefeicao extends Command
{
    protected $signature = 'notificar:refeicao {--tipo=}';
    protected $description = 'Envia notificações sobre a refeição do dia para os usuários';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tipoRefeicao = $this->option('tipo');

        if (!$tipoRefeicao) {
            $this->error('O tipo de refeição é obrigatório!');
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new RefeicaoNotification($tipoRefeicao));
        }

        $this->info('Notificações de ' . $tipoRefeicao . ' enviadas com sucesso!');
    }
}
