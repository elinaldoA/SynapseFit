<?php

namespace App\Services;

use App\Models\User;

class DietaService
{
    public function gerarDieta(User $user)
    {
        $calorias = $this->calcularCalorias($user);
        $proteinas = round($calorias * 0.3 / 4);
        $carboidratos = round($calorias * 0.4 / 4);
        $gorduras = round($calorias * 0.3 / 9);

        $suplementos = $this->obterSuplementos($user->objetivo);
        $agua = round($user->agua_corporal * 0.75, 2);

        return [
            'calorias' => $calorias,
            'proteinas' => $proteinas,
            'carboidratos' => $carboidratos,
            'gorduras' => $gorduras,
            'suplementos' => implode(', ', $suplementos),
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

    private function obterSuplementos($objetivo)
    {
        $suplementos = [];
        if ($objetivo == 'hipertrofia') {
            $suplementos = ['Whey Protein', 'Creatina'];
        } elseif ($objetivo == 'emagrecimento') {
            $suplementos = ['Termogênico', 'Whey Protein'];
        } elseif ($objetivo == 'resistencia') {
            $suplementos = ['BCAA', 'Whey Protein'];
        }
        return $suplementos;
    }
}
