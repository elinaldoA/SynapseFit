<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;

class WorkoutSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        // Exercícios para membros superiores
        $upper_body_exercises = Exercise::where('muscle_group', 'Peito')
                                        ->orWhere('muscle_group', 'Costas')
                                        ->orWhere('muscle_group', 'Ombros')
                                        ->orWhere('muscle_group', 'Bíceps')
                                        ->orWhere('muscle_group', 'Tríceps')
                                        ->orWhere('muscle_group', 'Abdômen')
                                        ->get();

        // Exercícios para membros inferiores
        $lower_body_exercises = Exercise::where('muscle_group', 'Pernas')
                                        ->orWhere('muscle_group', 'Glúteos')
                                        ->get();

        foreach ($users as $user) {
            $this->createWorkout($user, 'A', $upper_body_exercises->random(10));
            $this->createWorkout($user, 'B', $upper_body_exercises->random(10));
            $this->createWorkout($user, 'C', $lower_body_exercises->random(10));
        }
    }

    private function createWorkout($user, $type, $exercises)
    {
        foreach ($exercises as $exercise) {
            $series = 3;
            $repeticoes = 12;
            $descanso = 60;
            $carga = null;

            Workout::create([
                'user_id' => $user->id,
                'type' => $type,
                'exercise_id' => $exercise->id,
                'series' => $series,
                'repeticoes' => $repeticoes,
                'descanso' => $descanso,
                'carga' => $carga,
            ]);
        }
    }
}
