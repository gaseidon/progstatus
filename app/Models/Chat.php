<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user_id', 'agent_id', 'title'];

    public function agent() {
        return $this->belongsTo(\App\Models\Agent::class);
    }
    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function messages() {
        return $this->hasMany(\App\Models\ChatMessage::class);
    }
}
