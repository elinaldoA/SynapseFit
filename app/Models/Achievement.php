<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'titulo',
        'descricao',
    ];

    // Definir a relação com o modelo User (muitos para um)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
