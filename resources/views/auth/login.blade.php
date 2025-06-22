@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="max-w-lg w-full mx-auto bg-white rounded-xl shadow-lg p-10 mt-12">
    <h2 class="text-2xl font-bold mb-6 text-center">Вход</h2>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block mb-1 text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password" class="block mb-1 text-sm font-medium">Пароль</label>
            <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-400" {{ old('remember') ? 'checked' : '' }}>
                <span class="ml-2 text-sm">Запомнить меня</span>
            </label>
        </div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition">Войти</button>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Нет аккаунта? Зарегистрироваться</a>
    </div>
</div>
@endsection 