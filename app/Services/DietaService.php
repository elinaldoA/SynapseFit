<?php

namespace App\Services;

use App\Models\User;

class DietaService
{
    public function validarDieta(User $user, $alimentos_consumidos)
    {
        $dieta = $this->gerarDieta($user);

        $totalCalorias = 0;
        $totalProteinas = 0;
        $totalCarboidratos = 0;
        $totalGorduras = 0;
        $totalFibras = 0;
        $totalSodio = 0;

        foreach ($alimentos_consumidos as $AlimentoConsumido) {
            $totalCalorias += $AlimentoConsumido['calorias'];
            $totalProteinas += $AlimentoConsumido['proteinas'];
            $totalCarboidratos += $AlimentoConsumido['carboidratos'];
            $totalGorduras += $AlimentoConsumido['gorduras'];
            $totalFibras += $AlimentoConsumido['fibras'];
            $totalSodio += $AlimentoConsumido['sodio'];
        }

        $mensagensDeErro = [];

        if ($totalCalorias > $dieta['calorias']) {
            $mensagensDeErro[] = 'Limite de calorias excedido!';
        }
        if ($totalProteinas > $dieta['proteinas']) {
            $mensagensDeErro[] = 'Limite de proteínas excedido!';
        }
        if ($totalCarboidratos > $dieta['carboidratos']) {
            $mensagensDeErro[] = 'Limite de carboidratos excedido!';
        }
        if ($totalGorduras > $dieta['gorduras']) {
            $mensagensDeErro[] = 'Limite de gorduras excedido!';
        }
        if ($totalFibras > $dieta['fibras']) {
            $mensagensDeErro[] = 'Limite de fibras excedido!';
        }
        if ($totalSodio > $dieta['sodio']) {
            $mensagensDeErro[] = 'Limite de sódio excedido!';
        }

        return count($mensagensDeErro) > 0 ? $mensagensDeErro : ['Dieta dentro dos limites.'];
    }

    public function gerarDieta(User $user)
    {
        $calorias = $this->calcularCalorias($user);
        $proteinas = round($calorias * 0.3 / 4);
        $carboidratos = round($calorias * 0.4 / 4);
        $gorduras = round($calorias * 0.3 / 9);

        if ($user->objetivo === 'hipertrofia') {
            $agua = round($user->weight * 0.04, 2);
        } elseif ($user->objetivo === 'emagrecimento') {
            $agua = round($user->weight * 0.03, 2);
        } else {
            $agua = round($user->weight * 0.035, 2);
        }

        $fibras = $user->sex === 'male' ? 35 : 25;
        $sodio = 2300;

        return [
            'calorias' => $calorias,
            'proteinas' => $proteinas,
            'carboidratos' => $carboidratos,
            'gorduras' => $gorduras,
            'agua' => $agua,
            'fibras' => $fibras,
            'sodio' => $sodio,
        ];
    }

    public function atualizarDieta(User $user)
    {
        $dieta = $this->gerarDieta($user);
        $user->dieta()->update($dieta);
    }

    private function calcularCalorias(User $user)
    {
        if ($user->sex === 'male') {
            return round((10 * $user->weight) + (6.25 * $user->height * 100) - (5 * $user->age) + 5 * 1.55);
        }

        return round((10 * $user->weight) + (6.25 * $user->height * 100) - (5 * $user->age) - 161 * 1.55);
    }
}
