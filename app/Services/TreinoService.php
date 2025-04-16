<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workout;
use App\Models\Exercise;
use App\Models\UserSubscription;
use Carbon\Carbon;

class TreinoService
{
    public function criarTreino(User $user)
    {
        $objetivo = $user->objetivo;
        $tipoPlano = $this->getTipoPlano($user->id);

        $query = Exercise::query();

        if ($tipoPlano === 'Grátis') {
            $query->where('level', 'Iniciante');
        }

        switch ($objetivo) {
            case 'Hipertrofia':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Hipertrofia')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Hipertrofia')->get();
                break;

            case 'Emagrecimento':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Emagrecimento')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Emagrecimento')->get();
                break;

            case 'Resistência':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Resistência')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Resistência')->get();
                break;

            default:
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])->get();
                break;
        }

        $limiteExercicios = $tipoPlano === 'Grátis' ? 6 : 10;

        $this->createWorkout($user, 'A', $upperBodyExercises->random(min($limiteExercicios, $upperBodyExercises->count())), $tipoPlano, $objetivo);
        $this->createWorkout($user, 'B', $upperBodyExercises->random(min($limiteExercicios, $upperBodyExercises->count())), $tipoPlano, $objetivo);
        $this->createWorkout($user, 'C', $lowerBodyExercises->random(min($limiteExercicios, $lowerBodyExercises->count())), $tipoPlano, $objetivo);
    }

    private function createWorkout(User $user, $type, $exercises, $tipoPlano, $objetivo)
    {
        foreach ($exercises as $exercise) {
            Workout::create([
                'user_id' => $user->id,
                'type' => $type,
                'exercise_id' => $exercise->id,
                'series' => $this->getSeries($tipoPlano, $objetivo),
                'repeticoes' => $this->getRepeticoes($tipoPlano, $objetivo),
                'descanso' => $this->getDescanso($tipoPlano, $objetivo),
                'carga' => null,
            ]);
        }
    }

    public function atualizarTreino(User $user)
    {
        $objetivo = $user->objetivo;
        $tipoPlano = $this->getTipoPlano($user->id);

        $query = Exercise::query();

        if ($tipoPlano === 'Grátis') {
            $query->where('level', 'Iniciante');
        }

        switch ($objetivo) {
            case 'Hipertrofia':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Hipertrofia')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Hipertrofia')->get();
                break;

            case 'Emagrecimento':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Emagrecimento', 'Cardio')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Emagrecimento','Cardio')->get();
                break;

            case 'Resistência':
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])
                    ->where('category', 'Resistência')->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])
                    ->where('category', 'Resistência')->get();
                break;

            default:
                $upperBodyExercises = (clone $query)->whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps','Core'])->get();
                $lowerBodyExercises = (clone $query)->whereIn('muscle_group', ['Pernas', 'Glúteos'])->get();
                break;
        }

        $limiteExercicios = $tipoPlano === 'Grátis' ? 6 : 10;

        $this->updateIfExists($user, 'A', $upperBodyExercises->random(min($limiteExercicios, $upperBodyExercises->count())), $tipoPlano, $objetivo);
        $this->updateIfExists($user, 'B', $upperBodyExercises->random(min($limiteExercicios, $upperBodyExercises->count())), $tipoPlano, $objetivo);
        $this->updateIfExists($user, 'C', $lowerBodyExercises->random(min($limiteExercicios, $lowerBodyExercises->count())), $tipoPlano, $objetivo);
    }

    private function updateIfExists(User $user, $type, $exercises, $tipoPlano, $objetivo)
    {
        $existingWorkouts = Workout::where('user_id', $user->id)->where('type', $type)->get();

        if ($existingWorkouts->isEmpty()) {
            return;
        }

        Workout::where('user_id', $user->id)->where('type', $type)->delete();

        foreach ($exercises as $exercise) {
            Workout::create([
                'user_id' => $user->id,
                'type' => $type,
                'exercise_id' => $exercise->id,
                'series' => $this->getSeries($tipoPlano, $objetivo),
                'repeticoes' => $this->getRepeticoes($tipoPlano, $objetivo),
                'descanso' => $this->getDescanso($tipoPlano, $objetivo),
                'carga' => null,
            ]);
        }
    }

    private function getTipoPlano($userId)
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$subscription) {
            return 'Grátis';
        }

        if ($subscription->plan->name === 'Grátis') {
            return 'Grátis';
        }

        $duration = $subscription->start_date->diffInMonths($subscription->end_date);

        return match ($duration) {
            1 => 'Mensal',
            3 => 'Trimestral',
            6 => 'Semestral',
            12 => 'Anual',
            default => 'Outro',
        };
    }

    private function getSeries($tipoPlano, $objetivo)
    {
        if ($tipoPlano === 'Grátis') return 3;

        return match ($objetivo) {
            'Hipertrofia' => 6,
            'Emagrecimento' => 5,
            'Resistência' => 4,
            default => 6,
        };
    }

    private function getRepeticoes($tipoPlano, $objetivo)
    {
        if ($tipoPlano === 'Grátis') return 12;

        return match ($objetivo) {
            'Hipertrofia' => 10,
            'Emagrecimento' => 15,
            'Resistência' => 20,
            default => 12,
        };
    }

    private function getDescanso($tipoPlano, $objetivo)
    {
        if ($tipoPlano === 'Grátis') return 60;

        return match ($objetivo) {
            'Hipertrofia' => 60,
            'Emagrecimento' => 30,
            'Resistência' => 20,
            default => 60,
        };
    }
}
