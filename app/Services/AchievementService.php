<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\AlimentoConsumido;
use App\Models\WorkoutProgress;
use App\Models\Alimentacao;
use App\Models\Hidratacao;
use Carbon\Carbon;

class AchievementService
{
    public function checkAchievements($user)
    {
        // Verificação para o treino
        if ($this->checkTreinoAchievements($user)) {
            $this->giveAchievementOnce($user, 'primeiro-treino', 'Primeiro Treino!', 'Você completou seu primeiro treino!', 10, 'treino');
        }

        // Verificação para a alimentação
        if ($this->checkAlimentacaoAchievements($user)) {
            $this->giveAchievementOnce($user, 'primeira-refeicao', 'Primeira Refeição!', 'Você registrou sua primeira refeição.', 10, 'alimentacao');
        }

        // Verificação para a hidratação
        if ($this->checkHidratacaoAchievements($user)) {
            $this->giveAchievementOnce($user, 'primeiro-copo', 'Primeiro Copo!', 'Você registrou sua primeira ingestão de água.', 10, 'hidratacao');
        }

        // Conquista de 14 dias seguidos de treino
        if ($this->checkTreino14DiasSeguidos($user)) {
            $this->giveAchievementOnce($user, '14-dias-seguidos', '14 Dias Seguidos!', 'Você completou 14 dias seguidos de treino!', 20, 'treino');
        }

        // Conquista de Alimentação Completa por 7 dias
        if ($this->checkAlimentacaoCompleta7Dias($user)) {
            $this->giveAchievementOnce($user, 'alimentacao-7-dias-completa', 'Alimentação Completa por 7 dias!', 'Você completou 7 dias seguidos com refeições completas!', 20, 'alimentacao');
        }

        // Conquista de hidratação perfeita por 30 dias
        if ($this->checkHidratacao30Dias($user)) {
            $this->giveAchievementOnce($user, 'hidratacao-30-dias', 'Hidratação Perfeita por 30 dias!', 'Você completou 30 dias seguidos de hidratação perfeita!', 30, 'hidratacao');
        }

        // Conquista de 100% de consistência em dieta por 7 dias
        if ($this->checkConsistenciaDieta7Dias($user)) {
            $this->giveAchievementOnce($user, '100-consistencia-dieta', '100% de Consistência em Dieta!', 'Você registrou todas as refeições durante 7 dias seguidos!', 40, 'alimentacao');
        }
    }

    private function checkTreinoAchievements($user)
    {
        // Verificar se já completou o primeiro treino
        $temPrimeiroTreino = WorkoutProgress::where('user_id', $user->id)->exists();
        if ($temPrimeiroTreino && !Achievement::where('user_id', $user->id)->where('slug', 'primeiro-treino')->exists()) {
            return true;
        }

        // Verificar se completou 7 dias seguidos de treino
        $diasSeguidosTreino = 0;
        for ($i = 0; $i < 7; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temTreino = WorkoutProgress::where('user_id', $user->id)
                ->whereDate('data_treino', $dia)
                ->exists();

            if ($temTreino) {
                $diasSeguidosTreino++;
            } else {
                break;
            }
        }
        if ($diasSeguidosTreino >= 7 && !Achievement::where('user_id', $user->id)->where('slug', '7-dias-seguidos')->exists()) {
            return true;
        }

        // Verificar se completou 30 treinos
        $totalTreinos = WorkoutProgress::where('user_id', $user->id)->count();
        if ($totalTreinos >= 30 && !Achievement::where('user_id', $user->id)->where('slug', '30-treinos')->exists()) {
            return true;
        }

        return false;
    }

    private function checkTreino14DiasSeguidos($user)
    {
        // Verificar se completou 14 dias seguidos de treino
        $diasSeguidosTreino = 0;
        for ($i = 0; $i < 14; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temTreino = WorkoutProgress::where('user_id', $user->id)
                ->whereDate('data_treino', $dia)
                ->exists();

            if ($temTreino) {
                $diasSeguidosTreino++;
            } else {
                break;
            }
        }

        if ($diasSeguidosTreino >= 14 && !Achievement::where('user_id', $user->id)->where('slug', '14-dias-seguidos')->exists()) {
            return true;
        }

        return false;
    }

    private function checkAlimentacaoAchievements($user)
    {
        // Verificar se registrou a primeira refeição
        $temPrimeiraRefeicao = AlimentoConsumido::where('user_id', $user->id)->exists();
        if ($temPrimeiraRefeicao && !Achievement::where('user_id', $user->id)->where('slug', 'primeira-refeicao')->exists()) {
            return true;
        }

        // Verificar se registrou 3 refeições no dia
        $hoje = Carbon::today();
        $refeicoesHoje = AlimentoConsumido::where('user_id', $user->id)
            ->whereDate('data', $hoje)
            ->count();
        if ($refeicoesHoje >= 3 && !Achievement::where('user_id', $user->id)->where('slug', '3-refeicoes-dia')->exists()) {
            return true;
        }

        // Verificar refeições seguidas por 7 dias
        $refeicoesSeguidas = 0;
        for ($i = 0; $i < 7; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temRefeicao = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->exists();

            if ($temRefeicao) {
                $refeicoesSeguidas++;
            } else {
                break;
            }
        }
        if ($refeicoesSeguidas >= 7 && !Achievement::where('user_id', $user->id)->where('slug', 'refeicoes-7-dias')->exists()) {
            return true;
        }

        return false;
    }

    private function checkAlimentacaoCompleta7Dias($user)
    {
        // Verificar refeições completas por 7 dias seguidos
        $refeicoesCompletasSeguidas = 0;
        for ($i = 0; $i < 7; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temRefeicaoCompleta = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->exists();

            if ($temRefeicaoCompleta) {
                $refeicoesCompletasSeguidas++;
            } else {
                break;
            }
        }
        if ($refeicoesCompletasSeguidas >= 7 && !Achievement::where('user_id', $user->id)->where('slug', 'alimentacao-7-dias-completa')->exists()) {
            return true;
        }

        return false;
    }

    private function checkHidratacaoAchievements($user)
    {
        // Verificar se registrou a primeira ingestão de água
        $temPrimeiroCopo = Hidratacao::where('user_id', $user->id)->exists();
        if ($temPrimeiroCopo && !Achievement::where('user_id', $user->id)->where('slug', 'primeiro-copo')->exists()) {
            return true;
        }

        // Verificar hidratação nos últimos 7 dias
        $aguaDiasSeguidos = 0;
        for ($i = 0; $i < 7; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temAgua = Hidratacao::where('user_id', $user->id)
                ->whereDate('registrado_em', $dia)
                ->exists();

            if ($temAgua) {
                $aguaDiasSeguidos++;
            } else {
                break;
            }
        }

        if ($aguaDiasSeguidos >= 7 && !Achievement::where('user_id', $user->id)->where('slug', 'hidratacao-7-dias')->exists()) {
            return true;
        }

        return false;
    }

    private function checkHidratacao30Dias($user)
    {
        // Verificar hidratação nos últimos 30 dias
        $aguaDiasSeguidos30 = 0;
        for ($i = 0; $i < 30; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temAgua = Hidratacao::where('user_id', $user->id)
                ->whereDate('registrado_em', $dia)
                ->exists();

            if ($temAgua) {
                $aguaDiasSeguidos30++;
            } else {
                break;
            }
        }

        if ($aguaDiasSeguidos30 >= 30 && !Achievement::where('user_id', $user->id)->where('slug', 'hidratacao-30-dias')->exists()) {
            return true;
        }

        return false;
    }

    private function checkConsistenciaDieta7Dias($user)
    {
        // Verificar se registrou todas as refeições no dia por 7 dias seguidos
        $refeicoesCompletasPor7Dias = 0;
        for ($i = 0; $i < 7; $i++) {
            $dia = now()->subDays($i)->toDateString();
            $temCafé = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->where('refeicao', 'café')
                ->exists();
            $temAlmoço = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->where('refeicao', 'almoço')
                ->exists();
            $temLanche = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->where('refeicao', 'lanche')
                ->exists();
            $temJantar = AlimentoConsumido::where('user_id', $user->id)
                ->whereDate('data', $dia)
                ->where('refeicao', 'jantar')
                ->exists();

            if ($temCafé && $temAlmoço && $temLanche && $temJantar) {
                $refeicoesCompletasPor7Dias++;
            } else {
                break;
            }
        }

        if ($refeicoesCompletasPor7Dias >= 7 && !Achievement::where('user_id', $user->id)->where('slug', '100-consistencia-dieta')->exists()) {
            return true;
        }

        return false;
    }

    protected function giveAchievementOnce($user, $slug, $titulo, $descricao, $pontos, $tipo)
    {
        // Verificar se a conquista já existe para o usuário
        $existingAchievement = Achievement::where('user_id', $user->id)
            ->where('slug', $slug)
            ->first();

        if (!$existingAchievement) {
            // Só cria a conquista se não existir
            Achievement::create([
                'user_id' => $user->id,
                'slug' => $slug,
                'titulo' => $titulo,
                'descricao' => $descricao,
                'pontos' => $pontos,
                'tipo' => $tipo
            ]);
        }
    }

}
