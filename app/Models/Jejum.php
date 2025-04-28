<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jejum extends Model
{
    use HasFactory;

    protected $table = "jejuns";
    protected $fillable = [
        'user_id',
        'protocolo',
        'duracao_jejum',
        'inicio',
        'objetivo',
        'peso_atual',
        'peso_meta',
        'jejum_previamente_feito',
        'doenca_cronica',
        'descricao_doenca',
        'outra_doenca',
        'observacoes',
        'status',
        'pausado_em',
        'tempo_pausado'
    ];

    protected $casts = [
        'jejum_previamente_feito' => 'boolean',
        'doenca_cronica' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
