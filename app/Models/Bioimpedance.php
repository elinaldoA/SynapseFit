<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bioimpedance extends Model
{
    use HasFactory;

    protected $table = 'bioimpedances';

    protected $fillable = [
        'user_id',
        'imc',
        'peso_ideal_inferior',
        'peso_ideal_superior',
        'massa_magra',
        'percentual_gordura',
        'massa_gordura',
        'agua_corporal',
        'visceral_fat',
        'idade_corporal',
        'bmr',
        'massa_muscular',
        'massa_ossea',
        'grau_obesidade',
        'impedancia_segmentos',
        'data_medicao',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
