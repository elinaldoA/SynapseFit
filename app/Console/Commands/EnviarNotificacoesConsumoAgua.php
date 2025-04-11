<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\ConsumoAguaNotification;
use App\Services\AguaService;
use Illuminate\Support\Facades\Log;

class EnviarNotificacoesConsumoAgua extends Command
{
    protected $signature = 'notificar:consumo-agua';
    protected $description = 'Envia notificações sobre o consumo de água para os usuários';
    protected $aguaService;

    public function __construct(AguaService $aguaService)
    {
        parent::__construct();
        $this->aguaService = $aguaService;
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $status = $this->aguaService->verificarMetaDiaria($user);

            Log::info("Usuário {$user->id}: {$status['consumido_ml']}ml / {$status['meta_ml']}ml");

            if ($status['consumido_ml'] < $status['meta_ml']) {
                Log::info("Enviando notificação para usuário {$user->id}");
                $user->notify(new ConsumoAguaNotification());
            }
        }

        $this->info('Notificações de consumo de água enviadas com sucesso!');
    }
}
