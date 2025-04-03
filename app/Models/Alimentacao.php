<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimentacao extends Model
{
    use HasFactory;

    protected $table = 'alimentacoes';

    protected $fillable = [
        'user_id',
        'alimento',
        'quantidade',
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'agua',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
