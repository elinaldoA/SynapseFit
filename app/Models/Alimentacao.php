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
