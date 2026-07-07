<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Informasi Posyandu') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet">

    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
</head>

<body
    class="font-sans antialiased bg-gradient-to-br from-blue-50 via-white to-sky-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{ $slot }}

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 opacity-60">
                &copy; {{ date('Y') }} Sistem Informasi Posyandu. All rights reserved.
            </p>
        </div>
    </div>

    @include('partials.notifications')
</body>

</html>