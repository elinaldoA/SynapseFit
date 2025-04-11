<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Carbon\Carbon;
use App\Services\DietaService;
use App\Services\TreinoService;

class AtualizarTreinoEDieta extends Command
{
    protected $signature = 'atualizar:treino-dieta';
    protected $description = 'Atualiza a dieta e o treino do usuário após 30 dias de registro';

    protected $dietaService;
    protected $treinoService;

    public function __construct(DietaService $dietaService, TreinoService $treinoService)
    {
        parent::__construct();
        $this->dietaService = $dietaService;
        $this->treinoService = $treinoService;
    }

    public function handle()
    {
        $subscriptions = UserSubscription::where('end_date', '<', Carbon::now())
            ->where('is_active', true)
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;

            $dieta = $this->dietaService->gerarDieta($user);
            $user->dieta()->update($dieta);

            $this->treinoService->atualizarTreino($user);

            $subscription->update([
                'end_date' => Carbon::now()->addDays(30),
            ]);

            $this->info("Treino e dieta do usuário {$user->name} atualizados.");
        }
    }
}
