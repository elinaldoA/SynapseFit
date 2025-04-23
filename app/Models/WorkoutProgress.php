<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgress extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_id',
        'series_completed',
        'carga',
        'status',
        'data_treino',
        'type',
    ];

    protected $casts = [
        'data_treino' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function workout() {
        return $this->belongsTo(Workout::class);
    }
}
