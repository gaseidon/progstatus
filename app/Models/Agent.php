<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'purpose',
        'style',
        'tools',
        'description',
        'interaction',
        'user_id'
    ];

    public function getToolsListAttribute()
    {
        return json_decode($this->tools, true) ?: [];
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
