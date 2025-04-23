<?php

namespace App\Helpers;

class NivelHelper
{
    public static function getNivel($pontos)
    {
        if ($pontos >= 0 && $pontos < 50) {
            return self::makeNivel('Novato', 'Dando os primeiros passos!', 'gray', 'fa-baby');
        } elseif ($pontos >= 50 && $pontos < 100) {
            return self::makeNivel('Iniciante', 'Começando sua jornada!', 'gray', 'fa-dumbbell');
        } elseif ($pontos >= 100 && $pontos < 200) {
            return self::makeNivel('Desafiante', 'Você está começando a ficar bom!', 'blue', 'fa-running');
        } elseif ($pontos >= 200 && $pontos < 300) {
            return self::makeNivel('Intermediário', 'Você está pegando o ritmo!', 'blue', 'fa-trophy');
        } elseif ($pontos >= 300 && $pontos < 500) {
            return self::makeNivel('Avançado', 'Você está indo muito bem!', 'purple', 'fa-bolt');
        } elseif ($pontos >= 500 && $pontos < 750) {
            return self::makeNivel('Especialista', 'Sua técnica é impressionante!', 'green', 'fa-medal');
        } elseif ($pontos >= 750 && $pontos < 1000) {
            return self::makeNivel('Pro', 'Já é referência!', 'orange', 'fa-fire');
        } elseif ($pontos >= 1000 && $pontos < 1500) {
            return self::makeNivel('Mestre', 'Você está dominando!', 'red', 'fa-trophy');
        } elseif ($pontos >= 1500 && $pontos < 2000) {
            return self::makeNivel('Lendário', 'Você inspira todos ao redor!', 'gold', 'fa-crown');
        } elseif ($pontos >= 2000 && $pontos < 3000) {
            return self::makeNivel('Deus do Fitness', 'Sua força é lendária!', 'silver', 'fa-gym');
        } else {
            return self::makeNivel('Imortal', 'Você é uma lenda viva!', 'platinum', 'fa-diamond');
        }
    }

    protected static function makeNivel($nome, $descricao, $cor, $icone)
    {
        return [
            'nome' => $nome,
            'descricao' => $descricao,
            'cor' => $cor,
            'icone' => $icone
        ];
    }
}
