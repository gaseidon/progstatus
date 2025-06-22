@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-lg w-full mx-auto bg-white rounded-xl shadow-lg p-10 mt-12">
    <h2 class="text-2xl font-bold mb-6 text-center">Регистрация</h2>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block mb-1 text-sm font-medium">Имя</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="email" class="block mb-1 text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password" class="block mb-1 text-sm font-medium">Пароль</label>
            <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="block mb-1 text-sm font-medium">Подтверждение пароля</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition">Зарегистрироваться</button>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Уже есть аккаунт? Войти</a>
    </div>
</div>
@endsection 