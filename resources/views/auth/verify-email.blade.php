@extends('layouts.app')
@section('title', 'Подтверждение email')
@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh]">
    <h1 class="text-2xl font-bold mb-4">Подтвердите ваш email</h1>
    <p class="mb-4">На вашу почту отправлено письмо с подтверждением. Пожалуйста, перейдите по ссылке из письма.</p>
    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold transition">Отправить письмо повторно</button>
    </form>
</div>
@endsection 