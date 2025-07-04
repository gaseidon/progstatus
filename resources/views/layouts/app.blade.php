<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'AssitantLib')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen h-screen">
    @include('partials.header')

    <main class="flex-1 flex flex-col container mx-auto py-8">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Кнопка и модальное окно чата -->
    <button id="open-chat" class="fixed bottom-6 right-6 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg cursor-pointer text-3xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 0 1-4-.8L3 20l.8-4A8.96 8.96 0 0 1 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>
    <div id="chat-modal" class="fixed inset-0 z-50 flex items-end justify-end pointer-events-none">
        <div class="w-full max-w-md bg-white rounded-t-2xl shadow-2xl p-4 m-4 border border-blue-100 pointer-events-auto hidden flex-col" style="min-height:350px; max-height:80vh;" id="chat-modal-content">
            <div class="flex items-center justify-between mb-2">
                <span class="font-bold text-lg">Чат с агентом</span>
                <button id="close-chat" class="p-1 rounded-full hover:bg-gray-100 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <label for="chat-agent-select" class="block text-sm font-medium mb-1">Выберите агента:</label>
                <select id="chat-agent-select" class="w-full border rounded px-3 py-2">
                    <option>Агент 1</option>
                    <option>Агент 2</option>
                    <option>Агент 3</option>
                </select>
            </div>
            <div class="flex-1 overflow-y-auto bg-gray-50 rounded p-2 mb-2" style="min-height:120px;">Здесь будет история чата...</div>
            <form class="flex gap-2">
                <input type="text" class="flex-1 border rounded px-3 py-2" placeholder="Введите сообщение..." disabled>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded cursor-pointer" disabled>Отправить</button>
            </form>
        </div>
    </div>
    <script>
        const openChatBtn = document.getElementById('open-chat');
        const chatModal = document.getElementById('chat-modal');
        const chatModalContent = document.getElementById('chat-modal-content');
        const closeChatBtn = document.getElementById('close-chat');
        openChatBtn.addEventListener('click', () => {
            chatModalContent.classList.remove('hidden');
            chatModal.classList.add('pointer-events-auto');
        });
        closeChatBtn.addEventListener('click', () => {
            chatModalContent.classList.add('hidden');
            chatModal.classList.remove('pointer-events-auto');
        });
        chatModal.addEventListener('click', (e) => {
            if (e.target === chatModal) {
                chatModalContent.classList.add('hidden');
                chatModal.classList.remove('pointer-events-auto');
            }
        });
    </script>
</body>
</html>