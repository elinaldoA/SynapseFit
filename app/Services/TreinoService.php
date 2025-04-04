<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workout;
use App\Models\Exercise;

class TreinoService
{
    public function criarTreino(User $user)
    {
        $upperBodyExercises = Exercise::whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps', 'Abdômen'])->get();
        $lowerBodyExercises = Exercise::whereIn('muscle_group', ['Pernas', 'Glúteos'])->get();

        $this->createWorkout($user, 'A', $upperBodyExercises->random(10));
        $this->createWorkout($user, 'B', $upperBodyExercises->random(10));
        $this->createWorkout($user, 'C', $lowerBodyExercises->random(10));
    }

    private function createWorkout(User $user, $type, $exercises)
    {
        foreach ($exercises as $exercise) {
            Workout::create([
                'user_id' => $user->id,
                'type' => $type,
                'exercise_id' => $exercise->id,
                'series' => 3,
                'repeticoes' => 12,
                'descanso' => 60,
                'carga' => null,
            ]);
        }
    }

    public function atualizarTreino(User $user)
    {
        $upperBodyExercises = Exercise::whereIn('muscle_group', ['Peito', 'Costas', 'Ombros', 'Bíceps', 'Tríceps', 'Abdômen'])->get();
        $lowerBodyExercises = Exercise::whereIn('muscle_group', ['Pernas', 'Glúteos'])->get();

        $this->updateIfExists($user, 'A', $upperBodyExercises->random(10));
        $this->updateIfExists($user, 'B', $upperBodyExercises->random(10));
        $this->updateIfExists($user, 'C', $lowerBodyExercises->random(10));
    }

    private function updateIfExists(User $user, $type, $exercises)
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
                'series' => 3,
                'repeticoes' => 12,
                'descanso' => 60,
                'carga' => null,
            ]);
        }
    }
}
