@extends('layouts.app') <!-- Указывает, что используем layout -->

@section('title', 'Главная') <!-- Задаем заголовок -->

@section('content') <!-- Контент страницы -->
<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Создавай AI-агентов для любых задач</h1>
        <p class="text-lg text-gray-600 mb-6">Автоматизируй рутину, экономь время и усилия — твой ИИ-помощник готов за пару минут!</p>
        <a href="/agents" class="inline-block px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold rounded-lg shadow transition">Начать бесплатно</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl mb-12">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="bg-blue-100 text-blue-600 rounded-full w-14 h-14 flex items-center justify-center mb-4">
                <!-- Lightning bolt icon for no-code -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 2L3 14h9l-1 8L21 10h-9l1-8z"/></svg>
            </div>
            <h3 class="font-bold text-xl mb-2">Без кода</h3>
            <p class="text-gray-500 text-center">Создавай и настраивай агентов без программирования — всё через удобный интерфейс.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="bg-green-100 text-green-600 rounded-full w-14 h-14 flex items-center justify-center mb-4">
                <!-- Template sheet with bookmark icon -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 3v6l3-2 3 2V3"/></svg>
            </div>
            <h3 class="font-bold text-xl mb-2">Готовые шаблоны</h3>
            <p class="text-gray-500 text-center">Выбирай из десятков шаблонов: чат-боты, ассистенты, автоматизация задач и многое другое.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="bg-orange-100 text-orange-600 rounded-full w-14 h-14 flex items-center justify-center mb-4">
                <!-- Minimalistic integration icon: two circles connected by a line -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <circle cx="7" cy="12" r="3"/>
                  <circle cx="17" cy="12" r="3"/>
                  <line x1="10" y1="12" x2="14" y2="12"/>
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2">Интеграции</h3>
            <p class="text-gray-500 text-center">Интегрируй агентов с Telegram, Discord, Email и другими сервисами в пару кликов.</p>
        </div>
    </div>
    <div class="w-full max-w-5xl">
        <h2 class="text-2xl font-bold mb-4">Примеры использования</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-lg p-5 shadow flex flex-col">
                <span class="font-semibold mb-2">AI-чат-бот для поддержки</span>
                <span class="text-gray-500 text-sm">Автоматические ответы на вопросы клиентов 24/7</span>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 shadow flex flex-col">
                <span class="font-semibold mb-2">Персональный ассистент</span>
                <span class="text-gray-500 text-sm">Планирование задач, напоминания, поиск информации</span>
            </div>
            <div class="bg-gray-50 rounded-lg p-5 shadow flex flex-col">
                <span class="font-semibold mb-2">Автоматизация бизнес-процессов</span>
                <span class="text-gray-500 text-sm">Обработка заявок, интеграция с CRM, рассылки</span>
            </div>
        </div>
    </div>
</div>
@endsection