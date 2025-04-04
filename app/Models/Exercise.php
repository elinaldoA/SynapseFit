<?php

// app/Models/Exercise.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'muscle_group'
    ];

    public function workouts(): BelongsToMany
    {
        return $this->belongsToMany(Workout::class);
    }
}
