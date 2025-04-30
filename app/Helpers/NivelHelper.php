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
            return self::makeNivel('Intermediário', 'Você está pegando o ritmo!', 'blue', 'fa-person-running', 200, [
                'nome' => 'Ativo', 'pontos_minimos' => 300
            ]);
        } elseif ($pontos >= 300 && $pontos < 400) {
            return self::makeNivel('Ativo', 'Sua energia é contagiante!', 'blue', 'fa-heartbeat', 300, [
                'nome' => 'Focado', 'pontos_minimos' => 400
            ]);
        } elseif ($pontos >= 400 && $pontos < 500) {
            return self::makeNivel('Focado', 'Você está focado no seu objetivo!', 'blue', 'fa-bullseye', 400, [
                'nome' => 'Avançado', 'pontos_minimos' => 500
            ]);
        } elseif ($pontos >= 500 && $pontos < 650) {
            return self::makeNivel('Avançado', 'Você está indo muito bem!', 'purple', 'fa-bolt', 500, [
                'nome' => 'Veterano', 'pontos_minimos' => 650
            ]);
        } elseif ($pontos >= 650 && $pontos < 800) {
            return self::makeNivel('Veterano', 'Experiência faz diferença!', 'purple', 'fa-shield-alt', 650, [
                'nome' => 'Especialista', 'pontos_minimos' => 800
            ]);
        } elseif ($pontos >= 800 && $pontos < 1000) {
            return self::makeNivel('Especialista', 'Sua técnica é impressionante!', 'green', 'fa-medal', 800, [
                'nome' => 'Pro', 'pontos_minimos' => 1000
            ]);
        } elseif ($pontos >= 1000 && $pontos < 1250) {
            return self::makeNivel('Pro', 'Já é referência!', 'orange', 'fa-fire', 1000, [
                'nome' => 'Elite', 'pontos_minimos' => 1250
            ]);
        } elseif ($pontos >= 1250 && $pontos < 1500) {
            return self::makeNivel('Elite', 'Entre os melhores!', 'orange', 'fa-award', 1250, [
                'nome' => 'Mestre', 'pontos_minimos' => 1500
            ]);
        } elseif ($pontos >= 1500 && $pontos < 2000) {
            return self::makeNivel('Mestre', 'Você está dominando!', 'red', 'fa-trophy', 1500, [
                'nome' => 'Lendário', 'pontos_minimos' => 2000
            ]);
        } elseif ($pontos >= 2000 && $pontos < 2500) {
            return self::makeNivel('Lendário', 'Você inspira todos ao redor!', 'gold', 'fa-crown', 2000, [
                'nome' => 'Deus do Fitness', 'pontos_minimos' => 2500
            ]);
        } elseif ($pontos >= 2500 && $pontos < 3000) {
            return self::makeNivel('Deus do Fitness', 'Sua força é lendária!', 'silver', 'fa-dumbbell', 2500, [
                'nome' => 'Imortal', 'pontos_minimos' => 3000
            ]);
        } elseif ($pontos >= 3000 && $pontos < 4000) {
            return self::makeNivel('Imortal', 'Você é uma lenda viva!', 'platinum', 'fa-diamond', 3000, [
                'nome' => 'Titan', 'pontos_minimos' => 4000
            ]);
        } elseif ($pontos >= 4000 && $pontos < 5000) {
            return self::makeNivel('Titan', 'Sua força desafia limites!', 'teal', 'fa-bicep', 4000, [
                'nome' => 'Colossal', 'pontos_minimos' => 5000
            ]);
        } elseif ($pontos >= 5000 && $pontos < 6000) {
            return self::makeNivel('Colossal', 'Você é praticamente indestrutível!', 'indigo', 'fa-rocket', 5000, [
                'nome' => 'Supremo', 'pontos_minimos' => 6000
            ]);
        } elseif ($pontos >= 6000 && $pontos < 8000) {
            return self::makeNivel('Supremo', 'Você transcendeu os limites!', 'black', 'fa-asterisk', 6000, [
                'nome' => 'Deus Supremo', 'pontos_minimos' => 8000
            ]);
        } elseif ($pontos >= 8000 && $pontos < 10000) {
            return self::makeNivel('Deus Supremo', 'Você é uma lenda imortal!', 'white', 'fa-cogs', 8000, [
                'nome' => 'Eterno', 'pontos_minimos' => 10000
            ]);
        } elseif ($pontos >= 10000 && $pontos < 15000) {
            return self::makeNivel('Eterno', 'Sua jornada nunca terá fim!', 'violet', 'fa-ghost', 10000, [
                'nome' => 'Imortalizado', 'pontos_minimos' => 15000
            ]);
        } elseif ($pontos >= 15000 && $pontos < 20000) {
            return self::makeNivel('Imortalizado', 'Você é um ícone eterno!', 'crimson', 'fa-sun', 15000, [
                'nome' => 'Lenda Absoluta', 'pontos_minimos' => 20000
            ]);
        } else {
            return self::makeNivel('Lenda Absoluta', 'Seu nome será lembrado para sempre!', 'rainbow', 'fa-infinity', 20000);
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
