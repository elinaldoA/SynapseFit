<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calorias',
        'proteinas',
        'carboidratos',
        'gorduras',
        'fibras',
        'sodio',
        'agua',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
