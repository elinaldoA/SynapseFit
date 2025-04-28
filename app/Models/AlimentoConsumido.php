<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlimentoConsumido extends Model
{
    use HasFactory;

    protected $table = "alimentos_consumidos";

    protected $fillable = [
        'user_id',
        'refeicao',
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'agua',
        'fibras',
        'sodio',
        'porcao',
        'descricao',
        'data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function refeicoesPadrao()
    {
        return ['café', 'almoço', 'lanche', 'jantar'];
    }
}
