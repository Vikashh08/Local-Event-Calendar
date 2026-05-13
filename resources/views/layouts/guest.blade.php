<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-900 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black opacity-90"></div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-gray-800 opacity-30 blur-3xl filter animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-gray-700 opacity-20 blur-3xl filter animate-pulse delay-700"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5 mix-blend-overlay"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center group">
                    <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-md border border-white/10 group-hover:bg-white/20 transition-all shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-white font-black text-2xl tracking-tighter mt-4 group-hover:text-gray-300 transition-colors">LECS.</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/95 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-3xl border border-white/20">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center">
                <a href="/" class="text-sm font-medium text-gray-500 hover:text-white transition-colors">
                    &larr; Back to website
                </a>
            </div>
        </div>
    </body>
</html>
