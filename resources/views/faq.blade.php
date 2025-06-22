@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <h1 class="text-3xl md:text-4xl font-extrabold mb-8 text-center">Часто задаваемые вопросы</h1>
    <div class="w-full max-w-2xl">
        <div class="space-y-4">
            <details class="group border border-gray-200 rounded-xl bg-white/90 p-4">
                <summary class="font-semibold cursor-pointer flex items-center justify-between">
                    Это действительно бесплатно?
                    <span class="ml-2 text-sky-500 group-open:rotate-180 transition-transform">&#9660;</span>
                </summary>
                <div class="mt-2 text-gray-600">Да, вы можете пользоваться базовым тарифом бесплатно без ограничений по времени. Платные тарифы открывают больше возможностей.</div>
            </details>
            <details class="group border border-gray-200 rounded-xl bg-white/90 p-4">
                <summary class="font-semibold cursor-pointer flex items-center justify-between">
                    Нужны ли навыки программирования?
                    <span class="ml-2 text-sky-500 group-open:rotate-180 transition-transform">&#9660;</span>
                </summary>
                <div class="mt-2 text-gray-600">Нет, всё настраивается через удобный визуальный интерфейс. Программировать не нужно.</div>
            </details>
            <details class="group border border-gray-200 rounded-xl bg-white/90 p-4">
                <summary class="font-semibold cursor-pointer flex items-center justify-between">
                    Какие есть интеграции?
                    <span class="ml-2 text-sky-500 group-open:rotate-180 transition-transform">&#9660;</span>
                </summary>
                <div class="mt-2 text-gray-600">Доступны интеграции с Telegram, Discord, Email и другими популярными сервисами. Список постоянно расширяется.</div>
            </details>
            <details class="group border border-gray-200 rounded-xl bg-white/90 p-4">
                <summary class="font-semibold cursor-pointer flex items-center justify-between">
                    Как быстро я смогу запустить своего агента?
                    <span class="ml-2 text-sky-500 group-open:rotate-180 transition-transform">&#9660;</span>
                </summary>
                <div class="mt-2 text-gray-600">Обычно на запуск уходит 2-5 минут: выберите шаблон, настройте параметры и интеграции — и всё готово!</div>
            </details>
            <details class="group border border-gray-200 rounded-xl bg-white/90 p-4">
                <summary class="font-semibold cursor-pointer flex items-center justify-between">
                    Как связаться с поддержкой?
                    <span class="ml-2 text-sky-500 group-open:rotate-180 transition-transform">&#9660;</span>
                </summary>
                <div class="mt-2 text-gray-600">Вы можете написать нам на email, указанный в разделе "Контакты", или воспользоваться формой обратной связи в личном кабинете.</div>
            </details>
        </div>
    </div>
</div>
@endsection 