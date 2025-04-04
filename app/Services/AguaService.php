<?php

namespace App\Services;

use App\Models\User;
use App\Models\ConsumoAgua;
use App\Services\DietaService;
use Carbon\Carbon;

class AguaService
{
    protected $dietaService;

    public function __construct(DietaService $dietaService)
    {
        $this->dietaService = $dietaService;
    }

    public function verificarMetaDiaria(User $user)
    {
        $hoje = Carbon::today();

        $aguaConsumida = ConsumoAgua::where('user_id', $user->id)
            ->whereDate('registrado_em', $hoje)
            ->sum('quantidade');

        $metaLitros = $this->dietaService->gerarDieta($user)['agua'] ?? 2;
        $metaMl = round($metaLitros * 1000);

        $resultado = [
            'consumido_ml' => $aguaConsumida,
            'meta_ml' => $metaMl,
        ];

        if ($aguaConsumida >= $metaMl) {
            $resultado['status'] = 'ok';
            $resultado['mensagem'] = 'Meta de hidratação atingida! 💧';
        } else {
            $resultado['status'] = 'pendente';
            $resultado['mensagem'] = 'Beba mais água! 💦';
            $resultado['faltando_ml'] = max(0, $metaMl - $aguaConsumida);
        }

        return $resultado;
    }
}
