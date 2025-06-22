@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <h1 class="text-3xl md:text-4xl font-extrabold mb-8 text-center">Контакты</h1>
    <div class="w-full max-w-2xl bg-white/90 rounded-xl shadow p-8 mb-8">
        <div class="mb-6 text-center">
            <div class="text-lg text-gray-700 mb-2">Email поддержки:</div>
            <a href="mailto:support@example.com" class="text-sky-600 font-semibold hover:underline">support@example.com</a>
        </div>
        <form method="POST" action="#" class="space-y-4">
            <div>
                <label class="block text-gray-600 mb-1" for="name">Имя</label>
                <input type="text" id="name" name="name" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <div>
                <label class="block text-gray-600 mb-1" for="email">Email</label>
                <input type="email" id="email" name="email" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <div>
                <label class="block text-gray-600 mb-1" for="message">Сообщение</label>
                <textarea id="message" name="message" rows="4" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required></textarea>
            </div>
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 rounded-lg transition">Отправить</button>
        </form>
    </div>
</div>
@endsection 