<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Логотип -->
        <a href="/" class="text-xl font-bold">AssitantLib</a>

        <!-- Навигация -->
        <nav class="space-x-4 hidden md:flex">
            <a href="/howitworks" class="text-gray-700 hover:text-blue-500">Как это работает</a>
            <a href="/pricing" class="text-gray-700 hover:text-blue-500">Цены</a>
            <a href="/agents" class="text-gray-700 hover:text-blue-500">Каталог агентов</a>
        </nav>

        <!-- Действия пользователя -->
        <div class="flex items-center space-x-4">
            @guest
                <a href="/login" class="text-gray-700 hover:text-blue-500">Войти</a>
                <a href="/register" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Регистрация</a>
            @else
                <div class="relative flex items-center" x-data="{ open: false }">
                    <button class="flex items-center focus:outline-none transition group" id="profile-menu-button" @click="open = !open">
                        @if(Auth::user()->avatar ?? false)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar" class="w-10 h-10 rounded-full object-cover border-2 border-sky-500 group-hover:border-sky-400 group-hover:bg-sky-50 transition">
                        @else
                            <span class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center border-2 border-sky-500 group-hover:border-sky-400 group-hover:bg-sky-50 transition">
                                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"/></svg>
                            </span>
                        @endif
                        <svg class="w-4 h-4 ml-1 text-gray-400 group-hover:text-sky-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50">
                        <a href="/agents" class="block px-4 py-2 text-gray-700 hover:bg-sky-50">Мои агенты</a>
                        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-sky-50">Профиль</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-500 hover:bg-red-50">Выход</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>