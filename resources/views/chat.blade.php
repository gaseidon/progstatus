@extends('layouts.app')

@section('title', 'Чат')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] py-8 bg-gradient-to-b from-white via-blue-50 to-white">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg border border-blue-100 flex flex-col h-[70vh] relative">
        <!-- Вкладки чатов -->
        <div class="flex items-center gap-2 px-6 pt-4 pb-2 border-b border-blue-100">
            @foreach($chats as $chat)
                <button class="chat-tab cursor-pointer px-4 py-2 rounded-t-lg font-semibold text-blue-700 bg-blue-50 border border-b-0 border-blue-200 focus:outline-none transition @if($loop->first) active bg-white @endif" data-chat-id="{{ $chat->id }}">
                    {{ $chat->title }} <span class="text-xs text-gray-400">({{ $chat->agent->name ?? 'Без агента' }})</span>
                </button>
            @endforeach
            <button id="new-chat-btn" class="ml-auto px-3 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition" title="Новый чат">+</button>
        </div>
        <!-- Модалка создания чата -->
        <div id="create-chat-modal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
                <button id="close-create-chat-modal" class="absolute top-2 right-2 text-gray-400 hover:text-blue-600">&times;</button>
                <h3 class="text-xl font-bold mb-4">Создать новый чат</h3>
                <form id="create-chat-form">
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium">Название чата</label>
                        <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium">Выберите агента</label>
                        <select name="agent_id" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="" disabled selected>Выберите агента</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->purpose }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">Создать</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Меню чата (выделено в отдельный блок) -->
        <div class="w-full flex justify-end px-6 z-20">
            <div class="relative" id="chat-menu-wrapper">
                <button id="chat-menu-btn" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-blue-100 transition" title="Меню">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="5" cy="12" r="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="19" cy="12" r="2"/>
                    </svg>
                </button>
                <div id="chat-menu-dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg py-2 border border-blue-100">
                    <button id="clear-chat-btn" class="w-full text-left px-4 py-2 text-red-600 hover:bg-blue-50 rounded-xl">Очистить чат</button>
                </div>
            </div>
        </div>
        <!-- Сообщения -->
        <div class="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-4 bg-blue-50" id="chat-messages">
            <div class="self-start bg-blue-100 text-blue-900 rounded-xl px-4 py-2 max-w-[80%]">Привет! Я твой AI-ассистент. Чем могу помочь?</div>
            <!-- Здесь будут сообщения -->
        </div>
        <!-- Индикатор загрузки -->
        <div id="ai-typing" class="flex items-center gap-2 px-6 py-2" style="display:none;">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span class="text-blue-500 text-sm">ИИ печатает...</span>
        </div>
        <form id="chat-form" action="{{ route('chat.message') }}" method="POST" class="flex flex-col gap-2 border-t border-blue-100 px-6 py-4 bg-white" autocomplete="off">
            @csrf
            <div class="flex items-end gap-2">
                <div class="relative flex-1">
                    <textarea id="chat-input" rows="3" class="w-full resize-none border border-gray-200 rounded-2xl px-4 py-4 min-h-[60px] bg-gray-50 text-gray-900 focus:ring-2 focus:ring-blue-200 outline-none placeholder-gray-400 pr-12" placeholder="Чем я могу помочь вам сегодня?"></textarea>
                    <button type="submit" class="send-btn-chat" title="Отправить">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 