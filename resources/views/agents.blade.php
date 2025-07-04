@extends('layouts.app')

@section('title', 'Мои агенты')

@section('content')
<div class="flex flex-col items-center py-12 min-h-[60vh] bg-gradient-to-b from-white via-blue-50 to-white">
    <div class="max-w-2xl w-full bg-white rounded-xl shadow-lg p-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Мои агенты</h2>
        @if(session('success'))
            <div class="mb-4 w-full bg-green-100 text-green-700 px-4 py-2 rounded text-center">{{ session('success') }}</div>
        @endif
        @if($agents->isEmpty())
            <div class="text-center text-gray-500 mb-6">У вас пока нет агентов.</div>
        @else
            <ul class="mb-8 divide-y divide-gray-200">
                @foreach($agents as $agent)
                    <li class="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div>
                            <div class="font-semibold text-lg">{{ $agent->name }}</div>
                            <div class="text-gray-500 text-sm">{{ $agent->purpose }}</div>
                            <div class="text-xs text-gray-400 mt-1">Стиль: {{ $agent->style }}</div>
                            <div class="text-xs text-gray-400 mt-1">Инструменты: {{ implode(', ', $agent->tools_list) }}</div>
                        </div>
                        <div class="flex gap-2 mt-2 md:mt-0">
                            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" onsubmit="return confirm('Удалить агента?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-transparent hover:bg-red-100 rounded-full transition cursor-pointer" title="Удалить">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="text-center mb-4">
            <button id="show-create-form" type="button" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition cursor-pointer">Создать агента</button>
        </div>
        <div id="create-agent-form" class="mt-8 @if(!$errors->any()) hidden @endif">
            <h3 class="text-xl font-bold mb-4 text-center">Создать AI-ассистента</h3>
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
                                <span class="inline-block px-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-700 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition select-none min-w-[110px] text-center cursor-pointer">
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
                                <span class="inline-block px-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-700 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition select-none cursor-pointer">
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
    </div>
</div>
@if(!$errors->any())
<script>
    document.getElementById('show-create-form').addEventListener('click', function() {
        document.getElementById('create-agent-form').classList.remove('hidden');
        this.classList.add('hidden');
    });
</script>
@else
<script>
    document.getElementById('show-create-form').classList.add('hidden');
</script>
@endif
@push('scripts')
<script>
    function validateAgentForm() {
        const form = document.querySelector('#create-agent-form form');
        if (!form) return;
        const name = form.querySelector('input[name="name"]');
        const purpose = form.querySelector('input[name="purpose"]');
        const style = form.querySelector('select[name="style"]');
        const tools = form.querySelectorAll('input[name="tools[]"]:checked');
        const interaction = form.querySelectorAll('input[name="interaction[]"]:checked');
        const submitBtn = form.querySelector('button[type="submit"]');
        let valid = true;
        if (!name.value.trim()) valid = false;
        if (!purpose.value.trim()) valid = false;
        if (!style.value) valid = false;
        if (tools.length === 0) valid = false;
        if (interaction.length === 0) valid = false;
        submitBtn.disabled = !valid;
        submitBtn.classList.toggle('opacity-50', !valid);
        submitBtn.classList.toggle('cursor-not-allowed', !valid);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#create-agent-form form');
        if (!form) return;
        form.addEventListener('input', validateAgentForm);
        validateAgentForm();
    });
</script>
@endpush
@stack('scripts')
@endsection 