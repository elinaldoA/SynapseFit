<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\SubscriptionService;

class NotificarAssinaturas extends Command
{
    protected $signature = 'notificar:assinaturas';

    protected $description = 'Notifica usuários com assinaturas vencidas ou prestes a vencer';

    public function handle()
    {
        $this->info('Verificando assinaturas...');

        $service = new SubscriptionService();

        $users = User::whereHas('subscriptions', function ($query) {
            $query->where('is_active', true);
        })->get();

        foreach ($users as $user) {
            $service->checkAndNotifySubscriptionExpiry($user->id);
        }

        $this->info('Notificações de assinaturas enviadas com sucesso!');
    }
}
