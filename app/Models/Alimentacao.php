<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimentacao extends Model
{
    use HasFactory;

    protected $table = "alimentacoes";

    protected $fillable = [
        'user_id',
        'refeicao', // café, almoço, lanche, jantar
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'agua',
        'fibras',
        'sodio',
        'descricao', // opcional: para descrever o que foi comido
        'data',
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Refeições padrão
    public static function refeicoesPadrao()
    {
        return ['café', 'almoço', 'lanche', 'jantar'];
    }
}
