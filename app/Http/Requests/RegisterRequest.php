<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно',
            'email.required' => 'Email обязателен',
            'email.email' => 'Некорректный email',
            'email.unique' => 'Email уже используется',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
} 