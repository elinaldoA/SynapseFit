<?php
namespace App\Services;

use App\Models\Bioimpedance;
use App\Models\User;
use App\Models\Bioimpedancia;

class BioimpedanceService
{
    public function calcularBioimpedancia(User $user)
    {
        $height = $user->height;
        $weight = $user->weight;
        $age = $user->age;
        $sex = $user->sex;

        $imc = $weight / ($height * $height);
        $massaMagra = $this->calcularMassaMagra($weight, $height, $sex);
        $percentualGordura = $this->calcularPercentualGordura($imc, $age, $sex);
        $massaGordura = $weight * ($percentualGordura / 100);
        $aguaCorporal = $this->calcularAguaCorporal($massaMagra);
        $visceralFat = $this->calcularGorduraVisceral($weight, $height, $sex);
        $pesoIdealInferior = 22 * ($height * $height) - 5;
        $pesoIdealSuperior = 22 * ($height * $height) + 5;
        $idadeCorporal = $this->calcularIdadeCorporal($age, $percentualGordura, $sex);
        $bmr = $this->calcularBMR($weight, $height, $age, $sex);
        $massaMuscular = $this->calcularMassaMuscular($weight, $height, $sex);
        $massaOssea = $this->calcularMassaOssea($weight, $height, $sex);

        Bioimpedance::create([
            'user_id' => $user->id,
            'imc' => round($imc, 2),
            'peso_ideal_inferior' => round($pesoIdealInferior, 2),
            'peso_ideal_superior' => round($pesoIdealSuperior, 2),
            'massa_magra' => round($massaMagra, 2),
            'percentual_gordura' => round($percentualGordura, 2),
            'massa_gordura' => round($massaGordura, 2),
            'agua_corporal' => round($aguaCorporal, 2),
            'visceral_fat' => round($visceralFat, 2),
            'idade_corporal' => round($idadeCorporal, 2),
            'bmr' => round($bmr, 2),
            'massa_muscular' => round($massaMuscular, 2),
            'massa_ossea' => round($massaOssea, 2),
            'data_medicao' => now(),
        ]);

        return [
            'imc' => round($imc, 2),
            'peso_ideal_inferior' => round($pesoIdealInferior, 2),
            'peso_ideal_superior' => round($pesoIdealSuperior, 2),
            'massa_magra' => round($massaMagra, 2),
            'percentual_gordura' => round($percentualGordura, 2),
            'massa_gordura' => round($massaGordura, 2),
            'agua_corporal' => round($aguaCorporal, 2),
            'visceral_fat' => round($visceralFat, 2),
            'idade_corporal' => round($idadeCorporal, 2),
            'bmr' => round($bmr, 2),
            'massa_muscular' => round($massaMuscular, 2),
            'massa_ossea' => round($massaOssea, 2),
        ];
    }

    private function calcularMassaMuscular($weight, $height, $sex)
    {
        if ($sex == 'male') {
            return (0.407 * $weight) + (0.267 * $height) - 19.2;
        } else {
            return (0.252 * $weight) + (0.473 * $height) - 48.3;
        }
    }

    private function calcularMassaOssea($weight, $height, $sex)
    {
        if ($sex == 'male') {
            return (0.174 * $weight) + (0.242 * $height) - 24.2;
        } else {
            return (0.103 * $weight) + (0.375 * $height) - 50.4;
        }
    }

    private function calcularMassaMagra($weight, $height, $sex)
    {
        return ($sex == 'male') ? (0.407 * $weight) + (0.267 * $height) - 19.2 : (0.252 * $weight) + (0.473 * $height) - 48.3;
    }

    private function calcularPercentualGordura($imc, $age, $sex)
    {
        return ($sex == 'male') ? (1.20 * $imc) + (0.23 * $age) - 16.2 : (1.20 * $imc) + (0.23 * $age) - 5.4;
    }

    private function calcularAguaCorporal($massaMagra)
    {
        return round($massaMagra * 0.70, 2);
    }

    private function calcularGorduraVisceral($weight, $height, $sex)
    {
        return ($sex == 'male') ? ($weight * 0.10) : ($weight * 0.07);
    }

    private function calcularIdadeCorporal($age, $percentualGordura, $sex)
    {
        return ($sex == 'male') ? $age - ($percentualGordura / 5) : $age - ($percentualGordura / 4);
    }

    private function calcularBMR($weight, $height, $age, $sex)
    {
        return ($sex == 'male') ? (88.362 + (13.397 * $weight) + (4.799 * $height * 100) - (5.677 * $age)) : (447.593 + (9.247 * $weight) + (3.098 * $height * 100) - (4.330 * $age));
    }
}
