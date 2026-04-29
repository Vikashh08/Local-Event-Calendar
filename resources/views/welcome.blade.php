<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LECS - Local Events') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-900 bg-gray-50">

    <!-- Navigation -->
    <nav class="absolute top-0 left-0 w-full z-50 bg-transparent py-6">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex justify-between items-center">
            <div class="text-white font-black text-2xl tracking-tighter flex items-center">
                <svg class="w-8 h-8 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                LECS.
            </div>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('events.index') }}" class="text-white hover:text-indigo-200 font-medium transition-colors hidden sm:block">Explore Events</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-indigo-200 font-medium transition-colors ml-6">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-indigo-200 font-medium transition-colors ml-6">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 px-5 py-2.5 rounded-full bg-white text-indigo-900 font-bold hover:bg-gray-100 hover:shadow-lg transition-all transform hover:-translate-y-0.5">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gray-900 pt-32 pb-24 lg:pt-48 lg:pb-32">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-black mix-blend-multiply opacity-80"></div>
            <!-- Decorative blobs -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-purple-500 opacity-20 blur-3xl filter animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-500 opacity-20 blur-3xl filter animate-pulse delay-700"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-6 md:px-12 text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 drop-shadow-xl">
                Discover Amazing <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-pink-400">Local Events</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto mb-10 font-light drop-shadow-md">
                Find concerts, workshops, meetups and more happening right in your neighborhood. Never miss out on what's next.
            </p>
            
            <form action="{{ route('events.index') }}" method="GET" class="max-w-2xl mx-auto bg-white p-2 rounded-full shadow-2xl flex relative transform hover:scale-[1.01] transition-transform duration-300">
                <input type="text" name="search" placeholder="Search for events, venues, or cities..." class="flex-grow bg-transparent border-none rounded-l-full px-6 py-4 text-gray-900 placeholder-gray-500 focus:ring-0 text-lg outline-none w-full">
                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-full px-8 py-4 transition-colors shadow-md flex-shrink-0 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Search
                </button>
            </form>
            
            <div class="mt-10 flex justify-center gap-3 flex-wrap">
                <span class="text-indigo-200 text-sm font-medium mr-2 self-center">Popular:</span>
                @foreach($categories->take(4) as $category)
                    <a href="{{ route('events.index', ['category' => $category->id]) }}" class="px-4 py-1.5 rounded-full border border-indigo-400/30 text-indigo-100 text-sm hover:bg-indigo-500/20 hover:border-indigo-400 backdrop-blur-sm transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-20">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Upcoming Events</h2>
                <p class="mt-2 text-lg text-gray-500">Don't miss out on these popular upcoming activities.</p>
            </div>
            <a href="{{ route('events.index') }}" class="hidden sm:inline-flex items-center text-indigo-600 font-bold hover:text-indigo-800 group">
                View all events 
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($upcomingEvents as $event)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <a href="{{ route('events.show', $event) }}" class="block relative">
                        <div class="h-56 bg-gradient-to-br from-blue-500 to-indigo-600 relative overflow-hidden">
                            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-3 py-2 rounded-xl text-center shadow-md">
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                <span class="block text-xl font-black text-indigo-600 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                            </div>
                            <div class="absolute top-4 right-4 bg-black/40 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-white border border-white/20">
                                {{ $event->category?->name ?? 'General' }}
                            </div>
                        </div>
                    </a>
                    <div class="p-6 relative">
                        <div class="absolute -top-6 right-6 h-12 w-12 bg-white rounded-full flex items-center justify-center shadow-md border border-gray-50 text-pink-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="block group-hover:text-indigo-600 transition-colors">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight pr-8">{{ $event->title }}</h3>
                        </a>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="truncate">{{ $event->location ?? 'TBA' }}</span>
                        </div>
                        <p class="text-gray-600 text-sm line-clamp-2">{{ $event->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No upcoming events yet</h3>
                    <p class="text-gray-500 mb-4">Check back later or create your own event!</p>
                    @auth
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium shadow hover:bg-indigo-700">Create Event</a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium shadow hover:bg-indigo-700">Join to Create</a>
                    @endauth
                </div>
            @endforelse
        </div>
        
        <div class="mt-8 sm:hidden text-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-indigo-600 font-bold hover:text-indigo-800">
                View all events 
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-600">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-16 md:py-24 flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-8 md:mb-0">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Host your own event?</h2>
                <p class="mt-4 text-xl text-indigo-200">Join thousands of organizers planning local events.</p>
            </div>
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('events.create') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-full hover:bg-gray-50 hover:shadow-lg transition-all transform hover:-translate-y-1">Create Event Now</a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-full hover:bg-gray-50 hover:shadow-lg transition-all transform hover:-translate-y-1">Get Started Free</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 text-center border-t border-gray-800">
        <p>&copy; {{ date('Y') }} Local Event Calendar System. All rights reserved.</p>
    </footer>

</body>
</html>
