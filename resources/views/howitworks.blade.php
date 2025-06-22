@extends('layouts.app')

@section('title', 'Как это работает')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-center">Как это работает?</h1>
    <p class="text-lg text-gray-600 mb-10 text-center max-w-2xl">Создайте собственного AI-агента за пару минут: всё просто, даже если вы никогда не программировали. Вот как это устроено:</p>
    <div class="w-full max-w-4xl flex flex-col gap-0">
        <div class="relative flex flex-col items-center">
            <!-- Шаг 1 -->
            <div class="bg-white/90 rounded-xl shadow p-6 w-full flex items-center gap-4 mb-4">
                <span class="flex justify-center items-center w-12 h-12 bg-sky-100 rounded-full">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                </span>
                <div>
                    <h3 class="text-xl font-semibold mb-1">1. Зарегистрируйтесь</h3>
                    <p class="text-gray-500">Создайте аккаунт за минуту — без лишних данных и сложностей.</p>
                </div>
            </div>
            <!-- Arrow -->
            <div class="flex flex-col items-center mb-4">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-4-4m4 4l4-4"/></svg>
            </div>
            <!-- Шаг 2 -->
            <div class="bg-white/90 rounded-xl shadow p-6 w-full flex items-center gap-4 mb-4">
                <span class="flex justify-center items-center w-12 h-12 bg-lime-100 rounded-full">
                    <svg class="w-8 h-8 text-lime-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <rect x="4" y="8" width="16" height="8" rx="4"/>
                      <circle cx="8.5" cy="12" r="1"/>
                      <circle cx="15.5" cy="12" r="1"/>
                      <path d="M12 8V6m-4 10v2m8-2v2"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-xl font-semibold mb-1">2. Создайте агента</h3>
                    <p class="text-gray-500">Выберите шаблон или настройте своего AI-агента под задачи бизнеса или личные нужды.</p>
                </div>
            </div>
            <!-- Arrow -->
            <div class="flex flex-col items-center mb-4">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-4-4m4 4l4-4"/></svg>
            </div>
            <!-- Шаг 3 -->
            <div class="bg-white/90 rounded-xl shadow p-6 w-full flex items-center gap-4">
                <span class="flex justify-center items-center w-12 h-12 bg-amber-100 rounded-full">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="7" cy="12" r="3"/><circle cx="17" cy="12" r="3"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </span>
                <div>
                    <h3 class="text-xl font-semibold mb-1">3. Интегрируйте и запускайте</h3>
                    <p class="text-gray-500">Подключите Telegram, Discord, Email или другие сервисы — и начните использовать агента!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 