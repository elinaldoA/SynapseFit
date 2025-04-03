<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bioimpedance extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos
    protected $fillable = [
        'user_id', // Relacionamento com o usuário
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
        'data_medicao',
    ];

    // Define o relacionamento com o modelo User (um para muitos)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
