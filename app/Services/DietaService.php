<?php

namespace App\Services;

use App\Models\Alimentacao;
use App\Models\User;

class DietaService
{
    public function validarDieta(User $user, $alimentacoes)
    {
        // Calcular as metas da dieta para o usuário
        $dieta = $this->gerarDieta($user);

        // Inicializar os totais consumidos
        $totalCalorias = 0;
        $totalProteinas = 0;
        $totalCarboidratos = 0;
        $totalGorduras = 0;
        $totalAgua = 0;

        // Loop através dos alimentos consumidos
        foreach ($alimentacoes as $alimentacao) {
            $totalCalorias += $alimentacao['calorias'];
            $totalProteinas += $alimentacao['proteinas'];
            $totalCarboidratos += $alimentacao['carboidratos'];
            $totalGorduras += $alimentacao['gorduras'];
            $totalAgua += $alimentacao['agua'];
        }

        // Inicializar o array de mensagens de erro
        $mensagensDeErro = [];

        // Verificar se os limites da dieta foram ultrapassados
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
        if ($totalAgua > $dieta['agua']) {
            $mensagensDeErro[] = 'Limite de água excedido!';
        }

        // Retorna as mensagens de erro, se houver
        if (count($mensagensDeErro) > 0) {
            return $mensagensDeErro;
        }

        return ['Dieta dentro dos limites.'];
    }


    public function gerarDieta(User $user)
    {
        // Calcula as metas da dieta com base nos dados do usuário
        $calorias = $this->calcularCalorias($user);
        $proteinas = round($calorias * 0.3 / 4);
        $carboidratos = round($calorias * 0.4 / 4);
        $gorduras = round($calorias * 0.3 / 9);

        if ($user->objetivo == 'hipertrofia') {
            $agua = round($user->weight * 0.04, 2);  // 40 ml por kg para hipertrofia
        } elseif ($user->objetivo == 'emagrecimento') {
            $agua = round($user->weight * 0.03, 2);  // 30 ml por kg para emagrecimento
        } else {
            $agua = round($user->weight * 0.035, 2);  // 35 ml por kg para manutenção
        }

        return [
            'calorias' => $calorias,
            'proteinas' => $proteinas,
            'carboidratos' => $carboidratos,
            'gorduras' => $gorduras,
            'agua' => $agua,
        ];
    }

    private function calcularCalorias(User $user)
    {
        if ($user->sex == 'male') {
            return round(10 * $user->weight + 6.25 * $user->height * 100 - 5 * $user->age + 5 * 1.55);
        }
        return round(10 * $user->weight + 6.25 * $user->height * 100 - 5 * $user->age - 161 * 1.55);
    }
}
