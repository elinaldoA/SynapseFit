<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'last_name',
    'email',
    'password',
    'height',
    'weight',
    'sex',
    'age',
    'objetivo',
    'role',
    'plano',
    'trial_ends_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bioimpedance()
    {
        return $this->hasOne(Bioimpedance::class);
    }
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }
    public function workoutProgress()
    {
        return $this->hasMany(WorkoutProgress::class);
    }
    public function dieta()
    {
        return $this->hasOne(Dieta::class);
    }
    public function alimentacoes()
    {
        return $this->hasMany(Alimentacao::class);
    }

    public function aguaConsumida()
    {
        return $this->hasMany(ConsumoAgua::class);
    }


    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isAluno()
    {
        return $this->role === 'aluno';
    }
    public function subscriptions()
    {
        return $this->hasMany(\App\Models\UserSubscription::class);
    }
    public function activeSubscription()
    {
        return $this->hasOne(\App\Models\UserSubscription::class)->latestOfMany();
    }
}
