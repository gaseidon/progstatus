import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('chat-form');
    if (!form) return;
    const input = document.getElementById('chat-input');
    const messages = document.getElementById('chat-messages');
    const aiTyping = document.getElementById('ai-typing');

    // --- ВОССТАНОВЛЕНИЕ ИСТОРИИ ЧАТА ---
    if (messages) {
        let chatHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
        messages.innerHTML = '';
        if (chatHistory.length === 0) {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-center h-full text-center text-blue-900 text-lg opacity-70 empty-history-banner';
            div.style.minHeight = '200px';
            div.textContent = 'История сообщений пуста';
            messages.appendChild(div);
        } else {
            chatHistory.forEach(msg => {
                const div = document.createElement('div');
                div.className = msg.className;
                div.textContent = msg.text;
                messages.appendChild(div);
            });
        }
        messages.scrollTop = messages.scrollHeight;
    }

    // --- ДОБАВЛЕНИЕ СООБЩЕНИЯ ПОЛЬЗОВАТЕЛЯ ---
    function addUserMessage(text) {
        const userMsg = {
            className: 'self-end bg-blue-600 text-white rounded-xl px-4 py-2 max-w-[80%]',
            text: text
        };
        let chatHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
        chatHistory.push(userMsg);
        localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
    }

    // --- ДОБАВЛЕНИЕ СООБЩЕНИЯ ОТ AI ---
    function addAiMessage(text) {
        const aiMsg = {
            className: 'self-start bg-blue-100 text-blue-900 rounded-xl px-4 py-2 max-w-[80%]',
            text: text
        };
        let chatHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
        chatHistory.push(aiMsg);
        localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
    }

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!input || !messages || !aiTyping) return;
        const userText = input.value.trim();
        if (!userText) return;
        // Удаляем плашку 'История сообщений пуста', если она есть
        const emptyHistoryBanner = messages.querySelector('.empty-history-banner');
        if (emptyHistoryBanner) {
            emptyHistoryBanner.remove();
        }
        // Добавляем сообщение пользователя
        const userMsg = document.createElement('div');
        userMsg.className = 'self-end bg-blue-600 text-white rounded-xl px-4 py-2 max-w-[80%]';
        userMsg.textContent = userText;
        messages.appendChild(userMsg);
        addUserMessage(userText); // сохраняем в localStorage
        input.value = '';
        messages.scrollTop = messages.scrollHeight;
        // Показываем индикатор загрузки
        aiTyping.style.display = 'flex';
        // Отправляем на backend
        try {
            const response = await fetch(form.getAttribute('data-action') || form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: userText, chat_id: activeChatId })
            });
            const data = await response.json();
            // Скрываем индикатор загрузки
            aiTyping.style.display = 'none';
            const aiMsg = document.createElement('div');
            aiMsg.className = 'self-start bg-blue-100 text-blue-900 rounded-xl px-4 py-2 max-w-[80%]';
            aiMsg.textContent = data.content || 'Ошибка: нет ответа от ассистента';
            messages.appendChild(aiMsg);
            addAiMessage(data.content || 'Ошибка: нет ответа от ассистента'); // сохраняем в localStorage
            messages.scrollTop = messages.scrollHeight;
        } catch (err) {
            const errMsg = document.createElement('div');
            errMsg.className = 'self-start bg-red-100 text-red-700 rounded-xl px-4 py-2 max-w-[80%]';
            errMsg.textContent = 'Ошибка отправки запроса';
            messages.appendChild(errMsg);
            messages.scrollTop = messages.scrollHeight;
        }
    });

    // --- ОТПРАВКА ПО ENTER ---
    if (input && form) {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                form.requestSubmit(); // отправить форму
            }
        });
    }

    // --- Меню чата: показать/скрыть ---
    const chatMenuBtn = document.getElementById('chat-menu-btn');
    const chatMenuDropdown = document.getElementById('chat-menu-dropdown');
    if (chatMenuBtn && chatMenuDropdown) {
        chatMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            chatMenuDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e) {
            if (!chatMenuDropdown.classList.contains('hidden')) {
                chatMenuDropdown.classList.add('hidden');
            }
        });
        chatMenuDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    // --- Очистка чата ---
    const clearChatBtn = document.getElementById('clear-chat-btn');
    if (clearChatBtn && messages && chatMenuDropdown) {
        clearChatBtn.addEventListener('click', async function() {
            if (!activeChatId) return;
            try {
                const response = await fetch(`/api/chats/${activeChatId}/clear`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    }
                });
                if (response.ok) {
                    localStorage.removeItem('chatHistory');
                    messages.innerHTML = '<div class="flex items-center justify-center h-full text-center text-blue-900 text-lg opacity-70 empty-history-banner" style="min-height:200px;">История сообщений пуста</div>';
                    chatMenuDropdown.classList.add('hidden');
                } else {
                    alert('Ошибка очистки истории чата');
                }
            } catch (err) {
                alert('Ошибка очистки истории чата');
            }
        });
    }

    // --- Кнопка отправки: плавное появление ---
    const sendBtn = document.querySelector('.send-btn-chat');
    if (input && sendBtn) {
        input.addEventListener('focus', function() {
            sendBtn.style.opacity = '1';
        });
        input.addEventListener('blur', function() {
            sendBtn.style.opacity = '0.5';
        });
    }

    // --- СКРИПТЫ ИЗ layouts/app.blade.php (чат-модалка) ---
    const openChatBtn = document.getElementById('open-chat');
    const chatModal = document.getElementById('chat-modal');
    const chatModalContent = document.getElementById('chat-modal-content');
    const closeChatBtn = document.getElementById('close-chat');
    if (openChatBtn && chatModal && chatModalContent && closeChatBtn) {
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
    }

    // --- СКРИПТЫ ИЗ partials/header.blade.php (Alpine profileMenu) ---
    document.addEventListener('alpine:init', () => {
        if (window.Alpine) {
            window.Alpine.data('profileMenu', () => ({
                open: false,
                chatOpen: false,
            }));
        }
    });

    // --- СКРИПТЫ ИЗ agents.blade.php (форма создания агента) ---
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
        const showCreateFormBtn = document.getElementById('show-create-form');
        const createAgentForm = document.getElementById('create-agent-form');
        if (showCreateFormBtn && createAgentForm) {
            showCreateFormBtn.addEventListener('click', function() {
                createAgentForm.classList.remove('hidden');
                this.classList.add('hidden');
            });
        }
        // Если есть форма создания агента, навешиваем валидацию
        const agentForm = document.querySelector('#create-agent-form form');
        if (agentForm) {
            agentForm.addEventListener('input', validateAgentForm);
            validateAgentForm();
        }
    });

    // --- ВКЛАДКИ ЧАТА И СОЗДАНИЕ ЧАТА ---
    const chatTabs = document.querySelectorAll('.chat-tab');
    const chatMessages = document.getElementById('chat-messages');
    let activeChatId = chatTabs.length ? chatTabs[0].dataset.chatId : null;

    async function loadChatMessages(chatId) {
        chatMessages.innerHTML = '';
        try {
            const response = await fetch(`/api/chats/${chatId}/messages`);
            const data = await response.json();
            if (data.messages.length === 0) {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-center h-full text-center text-blue-900 text-lg opacity-70 empty-history-banner';
                div.style.minHeight = '200px';
                div.textContent = 'История сообщений пуста';
                chatMessages.appendChild(div);
            } else {
                data.messages.forEach(msg => {
                    const div = document.createElement('div');
                    div.className = msg.role === 'user'
                        ? 'self-end bg-blue-600 text-white rounded-xl px-4 py-2 max-w-[80%]'
                        : 'self-start bg-blue-100 text-blue-900 rounded-xl px-4 py-2 max-w-[80%]';
                    div.textContent = msg.content;
                    chatMessages.appendChild(div);
                });
            }
            chatMessages.scrollTop = chatMessages.scrollHeight;
        } catch (err) {
            chatMessages.innerHTML = '<div class="text-red-600">Ошибка загрузки истории чата</div>';
        }
    }

    // При загрузке страницы — подгружаем сообщения первого чата
    if (activeChatId) {
        loadChatMessages(activeChatId);
    }

    chatTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            chatTabs.forEach(t => t.classList.remove('active', 'bg-white'));
            this.classList.add('active', 'bg-white');
            activeChatId = this.dataset.chatId;
            loadChatMessages(activeChatId);
        });
    });

    // --- МОДАЛКА СОЗДАНИЯ ЧАТА ---
    const newChatBtn = document.getElementById('new-chat-btn');
    const createChatModal = document.getElementById('create-chat-modal');
    const closeCreateChatModal = document.getElementById('close-create-chat-modal');
    const createChatForm = document.getElementById('create-chat-form');

    if (newChatBtn && createChatModal) {
        newChatBtn.addEventListener('click', () => {
            createChatModal.classList.remove('hidden');
        });
    }
    if (closeCreateChatModal && createChatModal) {
        closeCreateChatModal.addEventListener('click', () => {
            createChatModal.classList.add('hidden');
        });
    }
    if (createChatForm) {
        createChatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(createChatForm);
            const data = Object.fromEntries(formData.entries());
            try {
                const response = await fetch('/api/chats', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                if (response.ok) {
                    // После успешного создания — перезагрузить страницу или динамически добавить вкладку
                    window.location.reload();
                } else {
                    alert('Ошибка создания чата');
                }
            } catch (err) {
                alert('Ошибка создания чата');
            }
        });
    }
});