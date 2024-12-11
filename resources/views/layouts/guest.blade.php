<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <title>{{ config('app.name', 'MyCorte') }}</title>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased dark:bg-gray-800">
        <livewire:layout.navigation />

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <livewire:errors.alert-message/> <!-- Adicione o componente aqui -->

        <div class="flex flex-col sm:justify-start items-center pt-6 bg-gray-100 dark:bg-gray-900 dark:pb-7 pb-7">
            <div class="w-full mt-2 px-6 py-4 bg-white dark:bg-gray-800 ">
                {{ $slot }}
            </div>
        </div>

        <livewire:layout.footer/>
    </body>
</html>
