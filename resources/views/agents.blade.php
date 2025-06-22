@extends('layouts.app')

@section('title', 'Создать AI-ассистента')

@section('content')
<div class="max-w-lg w-full mx-auto bg-white rounded-xl shadow-lg p-10 mt-12">
    <h2 class="text-2xl font-bold mb-6 text-center">Создать AI-ассистента</h2>
    @if ($errors->any())
        <div class="mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <form action="{{ route('agents.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block mb-1 text-sm font-medium">Имя агента</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                   required autofocus>
            @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="purpose" class="block mb-1 text-sm font-medium">Цель агента</label>
            <input type="text" id="purpose" name="purpose" value="{{ old('purpose') }}"
                   placeholder="Например: Планировать встречи, Писать тексты"
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                   required>
            @error('purpose')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="style" class="block mb-1 text-sm font-medium">Стиль общения</label>
            <select id="style" name="style"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                <option value="" disabled {{ old('style') ? '' : 'selected' }}>Выберите стиль</option>
                <option value="neutral" @if(old('style')=='neutral') selected @endif>Нейтральный</option>
                <option value="friendly" @if(old('style')=='friendly') selected @endif>Дружелюбный</option>
                <option value="formal" @if(old('style')=='formal') selected @endif>Формальный</option>
            </select>
            @error('style')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block mb-1 text-sm font-medium">Инструменты</label>
            <div class="max-h-48 overflow-y-auto bg-gray-50 rounded border border-gray-200 p-2 flex flex-col gap-2 mb-1">
                @php
                    $toolsList = [
                        'Календарь' => 'Назначение, редактирование и удаление встреч',
                        'Email' => 'Отправка писем, получение ответов',
                        'Telegram' => 'Поддержка ботов, автоматический чат',
                        'Поиск' => 'Поиск информации в интернете (Google / Bing API)',
                        'Файлы' => 'Создание PDF, Word, сохранение истории диалога',
                    ];
                    $oldTools = old('tools', []);
                @endphp
                @foreach($toolsList as $tool => $desc)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="tools[]" value="{{ $tool }}" class="peer hidden"
                            @if(collect($oldTools)->contains($tool)) checked @endif>
                        <span class="inline-block px-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-700 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition select-none min-w-[110px] text-center">
                            {{ $tool }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $desc }}</span>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-gray-500">Выберите один или несколько инструментов</p>
            @error('tools')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="mt-6">
            <label class="block mb-1 text-sm font-medium">Способ взаимодействия с агентом</label>
            <div class="flex flex-wrap gap-4 mb-1">
                @php
                    $ways = [
                        'chat' => 'Внутренний чат',
                        'telegram' => 'Telegram-бот',
                    ];
                    $oldWays = old('interaction', []);
                @endphp
                @foreach($ways as $way => $label)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="interaction[]" value="{{ $way }}" class="peer hidden"
                            @if(collect($oldWays)->contains($way)) checked @endif>
                        <span class="inline-block px-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-700 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition select-none">
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-gray-500">Можно выбрать один или оба варианта</p>
            @error('interaction')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="description" class="block mb-1 text-sm font-medium">Описание или инструкции (опционально)</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
            @error('description')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
        </div>
        <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition">
            Создать
        </button>
    </form>
</div>
@endsection 