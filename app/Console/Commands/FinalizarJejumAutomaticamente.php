<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jejum;
use Carbon\Carbon;

class FinalizarJejumAutomaticamente extends Command
{
    protected $signature = 'jejum:finalizar';
    protected $description = 'Finaliza automaticamente jejuns cujo tempo terminou';

    public function handle()
    {
        $agora = Carbon::now();

        $jejunsAtivos = Jejum::where('status', 'ativo')
            ->where('fim', '<=', $agora)
            ->get();

        foreach ($jejunsAtivos as $jejum) {
            $jejum->update([
                'status' => 'concluido',
                'tempo_decorrido' => $this->calcularTempoDecorrido($jejum),
            ]);

            $this->info('Jejum ID ' . $jejum->id . ' finalizado.');
        }

        $this->info('Finalização de jejuns concluída.');
    }

    private function calcularTempoDecorrido($jejum)
    {
        $inicio = Carbon::parse($jejum->inicio);
        return Carbon::parse($jejum->fim)->diffInSeconds($inicio);
    }
}
