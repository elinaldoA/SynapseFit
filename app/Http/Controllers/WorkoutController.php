<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WorkoutProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $workouts = $user->workouts()
            ->distinct('type')
            ->with('exercise')
            ->orderBy('type')
            ->get(['type']);

        return view('workouts.index', compact('workouts'));
    }
    public function show($type)
    {
        $user = Auth::user();
        $workouts = $user->workouts()->where('type', $type)->with('exercise')->get();

        $progress = WorkoutProgress::whereIn('workout_id', $workouts->pluck('id'))->get()->keyBy('workout_id');

        return view('workouts.show', compact('workouts', 'type', 'progress'));
    }
    public function exportToPdf()
    {
        $user = Auth::user();
        $workouts = $user->workouts;
        $groupedWorkouts = $workouts->groupBy('type');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('workouts.pdf', compact('groupedWorkouts'));

        return $pdf->stream('treinos_' . $user->name . '.pdf');
    }
    public function saveProgress(Request $request)
    {
        $validated = $request->validate([
            'workout_id' => 'required|exists:workouts,id',
            'series_completed' => 'required|integer',
            'carga' => 'nullable|string',
            'status' => 'required|string',
        ]);

        WorkoutProgress::updateOrCreate(
            [
                'workout_id' => $validated['workout_id'],
                'user_id' => Auth::id(),
            ],
            [
                'series_completed' => $validated['series_completed'],
                'carga' => $validated['carga'],
                'status' => $validated['status'],
            ]
        );

        return response()->json(['success' => true]);
    }
}
