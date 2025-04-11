<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['name','avatar','user_id', 'message', 'is_from_user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
