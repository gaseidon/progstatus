@extends('layouts.app')

@section('title', 'Чат')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] py-8 bg-gradient-to-b from-white via-blue-50 to-white">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg border border-blue-100 flex flex-col h-[70vh]">
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
        <form id="chat-form" class="flex flex-col gap-2 border-t border-blue-100 px-6 py-4 bg-white" autocomplete="off">
            <div class="flex items-end gap-2">
                <div class="flex flex-col">
                    <label for="chat-agent-select" class="text-xs font-medium text-gray-500 mb-1 ml-1">Агент:</label>
                    <select id="chat-agent-select" class="border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-700 focus:ring-2 focus:ring-blue-400 shadow-sm min-w-[120px]">
                        @forelse($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @empty
                            <option disabled>Нет агентов</option>
                        @endforelse
                    </select>
                </div>
                <textarea id="chat-input" rows="1" class="flex-1 resize-none border border-gray-200 rounded-2xl px-4 py-3 bg-gray-50 text-gray-900 focus:ring-2 focus:ring-blue-200 outline-none placeholder-gray-400" placeholder="Чем я могу помочь вам сегодня?"></textarea>
                <button type="submit" class="w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center transition cursor-pointer ml-2" title="Отправить">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const messages = document.getElementById('chat-messages');
    const aiTyping = document.getElementById('ai-typing');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const userText = input.value.trim();
        if (!userText) return;
        // Добавляем сообщение пользователя
        const userMsg = document.createElement('div');
        userMsg.className = 'self-end bg-blue-600 text-white rounded-xl px-4 py-2 max-w-[80%]';
        userMsg.textContent = userText;
        messages.appendChild(userMsg);
        input.value = '';
        messages.scrollTop = messages.scrollHeight;
        // Показываем индикатор загрузки
        aiTyping.style.display = 'flex';
        // Отправляем на backend
        try {
            const response = await fetch("{{ route('chat.message') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: userText })
            });
            const data = await response.json();
            // Скрываем индикатор загрузки
            aiTyping.style.display = 'none';
            const aiMsg = document.createElement('div');
            aiMsg.className = 'self-start bg-blue-100 text-blue-900 rounded-xl px-4 py-2 max-w-[80%]';
            aiMsg.textContent = data.content || 'Ошибка: нет ответа от ассистента';
            messages.appendChild(aiMsg);
            messages.scrollTop = messages.scrollHeight;
        } catch (err) {
            const errMsg = document.createElement('div');
            errMsg.className = 'self-start bg-red-100 text-red-700 rounded-xl px-4 py-2 max-w-[80%]';
            errMsg.textContent = 'Ошибка отправки запроса';
            messages.appendChild(errMsg);
            messages.scrollTop = messages.scrollHeight;
        }
    });
});
</script>
@endsection 