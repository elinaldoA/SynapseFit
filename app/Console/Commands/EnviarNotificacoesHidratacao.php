<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\HidratacaoNotification;
use App\Services\HidratacaoService;
use Illuminate\Support\Facades\Log;

class EnviarNotificacoesHidratacao extends Command
{
    protected $signature = 'notificar:consumo-agua';
    protected $description = 'Envia notificações sobre o consumo de água para os usuários';
    protected $HidratacaoService;

    public function __construct(HidratacaoService $HidratacaoService)
    {
        parent::__construct();
        $this->HidratacaoService = $HidratacaoService;
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $status = $this->HidratacaoService->verificarMetaDiaria($user);

            /*Log::info("Usuário {$user->id}: {$status['consumido_ml']}ml / {$status['meta_ml']}ml");*/

            if ($status['consumido_ml'] < $status['meta_ml']) {
                /*Log::info("Enviando notificação para usuário {$user->id}");*/
                $user->notify(new HidratacaoNotification());
            }
        }

        $this->info('Notificações de consumo de água enviadas com sucesso!');
    }
}
