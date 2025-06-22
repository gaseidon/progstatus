@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <h1 class="text-3xl md:text-4xl font-extrabold mb-8 text-center">Профиль</h1>
    <div class="bg-white/90 rounded-xl shadow p-8 w-full max-w-md flex flex-col items-center">
        @if(session('success'))
            <div class="mb-4 w-full bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 w-full bg-red-100 text-red-700 px-4 py-2 rounded">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @if(Auth::user()->avatar)
            <div class="relative mb-2 flex flex-col items-center">
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" class="w-24 h-24 rounded-full object-cover border-2 border-sky-500 shadow">
                <form method="POST" action="{{ route('profile.avatar.remove') }}" class="mt-2" style="z-index:2;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white border border-red-200 text-red-500 rounded-full p-1 hover:bg-red-50 transition" title="Удалить фото">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
        @else
            <div class="relative mb-2 flex flex-col items-center">
                <span class="w-24 h-24 rounded-full bg-sky-100 flex items-center justify-center border-2 border-sky-300 shadow">
                    <svg class="w-12 h-12 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                </span>
            </div>
        @endif
        <!-- Cropper Modal -->
        <div id="avatar-cropper-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded shadow-lg">
                <img id="cropper-preview" class="max-w-xs max-h-80 mx-auto" />
                <div class="flex items-center justify-center mt-2">
                    <label for="cropper-size" class="mr-2 text-sm text-gray-600">Размер:</label>
                    <input type="range" id="cropper-size" min="100" max="500" value="300" class="w-32">
                    <span id="cropper-size-value" class="ml-2 text-sm text-gray-600">300px</span>
                </div>
                <div class="flex justify-center mt-4">
                    <button type="button" id="cropper-cancel" class="mr-2 px-4 py-2 bg-gray-200 rounded">Отмена</button>
                    <button type="button" id="cropper-save" class="px-4 py-2 bg-sky-600 text-white rounded">Сохранить</button>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" class="w-full mb-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4 flex flex-col items-center">
                <label for="avatar" class="mt-2 inline-block cursor-pointer px-4 py-2 bg-sky-50 text-sky-700 border border-sky-200 rounded-lg font-semibold hover:bg-sky-100 transition">
                    Загрузить фото
                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" />
                </label>
                <input type="hidden" name="avatar_cropped" id="avatar-cropped">
                <span class="text-xs text-gray-400 mt-1">JPG, PNG, до 2 МБ</span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 mb-1" for="name">Имя</label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 mb-1" for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 rounded-lg transition">Сохранить изменения</button>
        </form>
        <form method="POST" action="{{ route('profile.password') }}" class="w-full">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-600 mb-1" for="old_password">Старый пароль</label>
                <input type="password" id="old_password" name="old_password" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 mb-1" for="password">Новый пароль</label>
                <input type="password" id="password" name="password" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600 mb-1" for="password_confirmation">Подтверждение пароля</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-lg border border-gray-200 px-4 py-2 focus:ring-2 focus:ring-sky-200 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-semibold py-2 rounded-lg transition">Сменить пароль</button>
        </form>
    </div>
</div>
@endsection

