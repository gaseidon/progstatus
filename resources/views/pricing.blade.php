@extends('layouts.app')

@section('title', 'Цены')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-center">Тарифы</h1>
    <p class="text-lg text-gray-600 mb-10 text-center max-w-2xl">Выберите подходящий тариф и начните использовать AI-агентов для автоматизации своих задач.</p>
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Бесплатный -->
        <div class="bg-white/90 rounded-xl shadow p-8 flex flex-col items-center border border-gray-100">
            <h2 class="text-xl font-bold mb-2">Бесплатный</h2>
            <div class="text-3xl font-extrabold mb-4">0₽<span class="text-base font-normal text-gray-400">/мес</span></div>
            <ul class="text-gray-500 mb-6 space-y-2 text-center">
                <li>1 агент</li>
                <li>Ограниченный доступ к шаблонам</li>
                <li>Базовые интеграции</li>
                <li>Поддержка по email</li>
            </ul>
            @auth
                <a href="{{ url('/agents') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Перейти в кабинет</a>
            @else
                <a href="{{ route('register') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Зарегистрироваться</a>
            @endauth
        </div>
        <!-- Базовый -->
        <div class="bg-white/90 rounded-xl shadow-lg p-8 flex flex-col items-center border-2 border-sky-500 scale-105 z-10 relative">
            <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-sky-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow">Рекомендуем</div>
            <h2 class="text-xl font-bold mb-2">Базовый</h2>
            <div class="text-3xl font-extrabold mb-4">490₽<span class="text-base font-normal text-gray-400">/мес</span></div>
            <ul class="text-gray-500 mb-6 space-y-2 text-center">
                <li>До 5 агентов</li>
                <li>Все шаблоны</li>
                <li>Интеграции: Telegram, Discord, Email</li>
                <li>Приоритетная поддержка</li>
            </ul>
            @auth
                <a href="{{ url('/agents') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Перейти в кабинет</a>
            @else
                <a href="{{ route('register') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Зарегистрироваться</a>
            @endauth
        </div>
        <!-- Премиум -->
        <div class="bg-white/90 rounded-xl shadow p-8 flex flex-col items-center border border-gray-100">
            <h2 class="text-xl font-bold mb-2">Премиум</h2>
            <div class="text-3xl font-extrabold mb-4">1490₽<span class="text-base font-normal text-gray-400">/мес</span></div>
            <ul class="text-gray-500 mb-6 space-y-2 text-center">
                <li>Неограниченно агентов</li>
                <li>Все шаблоны</li>
                <li>Все интеграции</li>
                <li>Личный менеджер</li>
            </ul>
            @auth
                <a href="{{ url('/agents') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Перейти в кабинет</a>
            @else
                <a href="{{ route('register') }}" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Зарегистрироваться</a>
            @endauth
        </div>
    </div>
</div>
@endsection 