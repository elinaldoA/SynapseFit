<?php

namespace App\Services;

use App\Models\Workout;
use App\Models\WorkoutProgress;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WorkoutService
{
    public function getWorkoutsGroupedByType($user)
    {
        return $user->workouts()
            ->distinct('type')
            ->with('exercise')
            ->orderBy('type')
            ->get(['type']);
    }

    public function getCurrentWorkoutProgress($user)
    {
        return WorkoutProgress::where('user_id', $user->id)
            ->latest('data_treino')
            ->get()
            ->map(function ($item) {
                $item->data_treino = Carbon::parse($item->data_treino)->toDateString();
                return $item;
            })
            ->groupBy('type');
    }

    public function saveProgress($data, $user)
    {
        $workout = Workout::findOrFail($data['workout_id']);
        $pontos = 10;

        if ($data['series_completed'] >= $workout->series) {
            $pontos += 5;
        }

        $ontem = now()->subDay()->toDateString();
        $treinoOntem = WorkoutProgress::where('user_id', $user->id)
            ->whereDate('data_treino', $ontem)
            ->exists();

        if ($treinoOntem) {
            $pontos += 2;
        }

        $user->increment('pontos', $pontos);

        $progress = WorkoutProgress::updateOrCreate(
            [
                'workout_id' => $data['workout_id'],
                'user_id' => $user->id,
            ],
            [
                'series_completed' => $data['series_completed'],
                'carga' => $data['carga'],
                'status' => $data['status'],
                'data_treino' => now(),
                'type' => $workout->type,
            ]
        );

        return [$progress, $pontos];
    }

    public function getNextWorkoutType($currentType)
    {
        $cycle = ['A', 'B', 'C'];
        $index = array_search($currentType, $cycle);
        return $index !== false ? $cycle[($index + 1) % count($cycle)] : null;
    }
}
