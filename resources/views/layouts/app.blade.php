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