<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'AssitantLib')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen h-screen">
    @include('partials.header')

    <main class="flex-1 flex flex-col container mx-auto py-8">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>