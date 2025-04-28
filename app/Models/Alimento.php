<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'refeicao',
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'agua',
        'fibras',
        'sodio',
        'descricao',
        'data',
        'porcao',
    ];

    // Se quiser, pode criar um relacionamento com AlimentoConsumido
    public function consumos()
    {
        return $this->hasMany(AlimentoConsumido::class);
    }
}
