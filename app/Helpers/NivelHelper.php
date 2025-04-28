<?php

namespace App\Helpers;

class NivelHelper
{
    public static function getNivel($pontos)
    {
        if ($pontos >= 0 && $pontos < 50) {
            return self::makeNivel('Novato', 'Dando os primeiros passos!', 'gray', 'fa-baby', 0, [
                'nome' => 'Iniciante', 'pontos_minimos' => 50
            ]);
        } elseif ($pontos >= 50 && $pontos < 100) {
            return self::makeNivel('Iniciante', 'Começando sua jornada!', 'gray', 'fa-dumbbell', 50, [
                'nome' => 'Desafiante', 'pontos_minimos' => 100
            ]);
        } elseif ($pontos >= 100 && $pontos < 200) {
            return self::makeNivel('Desafiante', 'Você está começando a ficar bom!', 'blue', 'fa-running', 100, [
                'nome' => 'Intermediário', 'pontos_minimos' => 200
            ]);
        } elseif ($pontos >= 200 && $pontos < 300) {
            return self::makeNivel('Intermediário', 'Você está pegando o ritmo!', 'blue', 'fa-trophy', 200, [
                'nome' => 'Avançado', 'pontos_minimos' => 300
            ]);
        } elseif ($pontos >= 300 && $pontos < 500) {
            return self::makeNivel('Avançado', 'Você está indo muito bem!', 'purple', 'fa-bolt', 300, [
                'nome' => 'Especialista', 'pontos_minimos' => 500
            ]);
        } elseif ($pontos >= 500 && $pontos < 750) {
            return self::makeNivel('Especialista', 'Sua técnica é impressionante!', 'green', 'fa-medal', 500, [
                'nome' => 'Pro', 'pontos_minimos' => 750
            ]);
        } elseif ($pontos >= 750 && $pontos < 1000) {
            return self::makeNivel('Pro', 'Já é referência!', 'orange', 'fa-fire', 750, [
                'nome' => 'Mestre', 'pontos_minimos' => 1000
            ]);
        } elseif ($pontos >= 1000 && $pontos < 1500) {
            return self::makeNivel('Mestre', 'Você está dominando!', 'red', 'fa-trophy', 1000, [
                'nome' => 'Lendário', 'pontos_minimos' => 1500
            ]);
        } elseif ($pontos >= 1500 && $pontos < 2000) {
            return self::makeNivel('Lendário', 'Você inspira todos ao redor!', 'gold', 'fa-crown', 1500, [
                'nome' => 'Deus do Fitness', 'pontos_minimos' => 2000
            ]);
        } elseif ($pontos >= 2000 && $pontos < 3000) {
            return self::makeNivel('Deus do Fitness', 'Sua força é lendária!', 'silver', 'fa-gym', 2000, [
                'nome' => 'Imortal', 'pontos_minimos' => 3000
            ]);
        } else {
            return self::makeNivel('Imortal', 'Você é uma lenda viva!', 'platinum', 'fa-diamond', 3000);
        }
    }

    protected static function makeNivel($nome, $descricao, $cor, $icone, $pontosMinimos = 0, $proximo = null)
    {
        return [
            'nome' => $nome,
            'descricao' => $descricao,
            'cor' => $cor,
            'icone' => $icone,
            'pontos_minimos' => $pontosMinimos,
            'proximo' => $proximo
        ];
    }
}
