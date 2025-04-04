<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoAgua extends Model
{
    protected $table = 'consumos_agua';

    protected $fillable = [
        'user_id',
        'quantidade',
        'registrado_em',
    ];

    public $timestamps = false;

    protected $dates = ['registrado_em'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
