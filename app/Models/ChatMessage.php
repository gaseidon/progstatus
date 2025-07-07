<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ChatMessage extends Model
{
    protected $fillable = ['chat_id', 'role', 'content'];

    public function chat() {
        return $this->belongsTo(\App\Models\Chat::class);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = Crypt::encryptString($value);
    }

    public function getContentAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
