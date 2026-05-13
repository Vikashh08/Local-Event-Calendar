<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LECS') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-gray-900">
        <div class="min-h-screen flex">
            <!-- Left Side: Branding / Visual (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-gray-900 relative overflow-hidden flex-col justify-between p-12">
                <!-- Abstract Background -->
                <div class="absolute inset-0 z-0 opacity-20">
                    <div class="absolute top-0 -left-1/4 w-full h-full bg-gradient-to-br from-white to-transparent rounded-full blur-3xl filter transform scale-150"></div>
                    <div class="absolute bottom-0 -right-1/4 w-full h-full bg-gradient-to-tl from-gray-500 to-transparent rounded-full blur-3xl filter transform scale-150"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10">
                    <a href="/" class="flex items-center text-white group">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-black text-2xl tracking-tighter">LECS.</span>
                    </a>
                </div>

                <div class="relative z-10 max-w-lg">
                    <h1 class="text-4xl font-bold text-white mb-6 leading-tight">Discover the best local events happening near you.</h1>
                    <p class="text-lg text-gray-400">Join our community to connect, organize, and experience unforgettable moments in your city.</p>
                </div>
                
                <div class="relative z-10 text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Local Event Calendar System. All rights reserved.
                </div>
            </div>

            <!-- Right Side: Auth Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 bg-white">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-10 flex justify-center">
                        <a href="/" class="flex items-center text-gray-900 group">
                            <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-black text-2xl tracking-tighter">LECS.</span>
                        </a>
                    </div>

                    {{ $slot }}
                    
                </div>
            </div>
        </div>
    </body>
</html>
