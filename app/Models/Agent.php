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

    public function getSystemPrompt(): string
    {
        $prompt = "Цель: {$this->purpose}. ";
        $tools = $this->getToolsListAttribute();
        if (!empty($tools)) {
            $prompt .= "Инструменты: " . implode(', ', $tools) . ". ";
        }
        if (!empty($this->description)) {
            $prompt .= "Инструкции: {$this->description}";
        }
        return trim($prompt);
    }
}
