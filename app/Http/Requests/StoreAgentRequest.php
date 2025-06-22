<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'style' => 'required|string|max:255',
            'tools' => 'required|array|min:1',
            'tools.*' => 'string|max:255',
            'interaction' => 'required|array|min:1',
            'interaction.*' => 'in:chat,telegram',
            'description' => 'nullable|string',
        ];
    }
} 