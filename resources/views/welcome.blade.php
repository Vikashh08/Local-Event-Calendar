<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LECS — Discover Local Events Near You</title>
    <meta name="description" content="Find concerts, workshops, meetups, and more happening right in your neighborhood. Never miss out on what's next with LECS.">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fade-up { animation: fadeSlideUp 0.7s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; opacity: 0; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; }
        .delay-400 { animation-delay: 0.4s; opacity: 0; }
    </style>
</head>
<body class="antialiased text-gray-900 bg-white">

    {{-- ===================== NAVBAR ===================== --}}
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 py-5" x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 40" :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm py-3' : 'bg-transparent py-5'">
        <div class="max-w-7xl mx-auto px-6 md:px-10 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-black transition-colors">
                    <svg class="w-4.5 h-4.5 text-white w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span :class="scrolled ? 'text-gray-900' : 'text-white'" class="font-black text-xl tracking-tight transition-colors">LECS.</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('events.index') }}" :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-gray-300 hover:text-white'" class="text-sm font-medium transition-colors">Explore Events</a>
                @auth
                    <a href="{{ route('dashboard') }}" :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-gray-300 hover:text-white'" class="text-sm font-medium transition-colors">Dashboard</a>
                    @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                        <a href="{{ route('events.create') }}" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-full hover:bg-black transition-colors shadow-lg shadow-gray-900/20">+ Create Event</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-gray-300 hover:text-white'" class="text-sm font-medium transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-white text-gray-900 text-sm font-bold rounded-full hover:bg-gray-50 hover:shadow-lg transition-all">Get Started Free</a>
                @endauth
            </div>

            {{-- Mobile menu --}}
            <div class="md:hidden flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" :class="scrolled ? 'text-gray-900' : 'text-white'" class="text-sm font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" :class="scrolled ? 'text-gray-600' : 'text-gray-300'" class="text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-gray-900 text-sm font-bold rounded-full">Join</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden bg-gray-950 min-h-screen flex items-center hero-grid">
        {{-- Background blobs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -right-32 w-[600px] h-[600px] bg-gray-700 rounded-full opacity-10 blur-[120px]"></div>
            <div class="absolute -bottom-32 -left-32 w-[500px] h-[500px] bg-gray-600 rounded-full opacity-10 blur-[100px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-gray-800 rounded-full opacity-5 blur-[80px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 md:px-10 pt-32 pb-20 w-full">
            <div class="text-center max-w-5xl mx-auto">
                {{-- Badge --}}
                <div class="animate-fade-up inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 text-sm text-gray-400 font-medium mb-8">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    Events happening near you right now
                </div>

                {{-- Headline --}}
                <h1 class="animate-fade-up delay-100 text-5xl md:text-7xl lg:text-8xl font-black text-white tracking-tighter leading-[0.9] mb-6">
                    Discover<br>
                    <span class="bg-gradient-to-r from-gray-300 via-white to-gray-400 bg-clip-text text-transparent">
                        Local Events.
                    </span>
                </h1>

                <p class="animate-fade-up delay-200 text-lg md:text-xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                    From intimate workshops to city-wide festivals — find, RSVP, and never miss what's happening in your city.
                </p>

                {{-- Search Bar --}}
                <form action="{{ route('events.index') }}" method="GET" class="animate-fade-up delay-300 max-w-2xl mx-auto">
                    <div class="relative flex bg-white rounded-2xl shadow-2xl shadow-black/40 p-1.5 focus-within:ring-4 focus-within:ring-white/20 transition-all">
                        <div class="flex items-center pl-4 text-gray-400 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" placeholder="Search events, venues, or cities..." class="flex-1 bg-transparent border-none px-4 py-3.5 text-gray-900 placeholder-gray-400 focus:ring-0 text-base outline-none">
                        <button type="submit" class="bg-gray-900 hover:bg-black text-white font-semibold rounded-xl px-6 py-3 transition-all text-sm shrink-0">
                            Search
                        </button>
                    </div>
                </form>

                {{-- Quick Category Pills --}}
                @if($categories->count() > 0)
                <div class="animate-fade-up delay-400 mt-6 flex justify-center gap-2 flex-wrap">
                    <span class="text-gray-500 text-sm self-center mr-1">Browse:</span>
                    @foreach($categories->take(5) as $category)
                        <a href="{{ route('events.index', ['category' => $category->id]) }}"
                           class="px-4 py-1.5 rounded-full border border-white/10 text-gray-400 text-sm hover:bg-white/10 hover:text-white hover:border-white/20 transition-all duration-200">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Floating Stats --}}
            <div class="mt-20 grid grid-cols-3 gap-4 max-w-lg mx-auto">
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center backdrop-blur-sm animate-float" style="animation-delay:0s">
                    <p class="text-2xl font-black text-white">{{ \App\Models\Event::approved()->count() }}+</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Live Events</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center backdrop-blur-sm animate-float" style="animation-delay:2s">
                    <p class="text-2xl font-black text-white">{{ \App\Models\User::count() }}+</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">Members</p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl p-4 text-center backdrop-blur-sm animate-float" style="animation-delay:4s">
                    <p class="text-2xl font-black text-white">{{ \App\Models\Rsvp::count() }}+</p>
                    <p class="text-xs text-gray-500 mt-1 font-medium">RSVPs Made</p>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-gray-600 animate-bounce">
            <span class="text-xs uppercase tracking-widest font-semibold">Scroll</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </section>

    {{-- ===================== HOW IT WORKS ===================== --}}
    <section class="py-24 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
            <div class="text-center mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Simple & Fast</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight mt-2">How it works</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'step' => '01', 'title' => 'Browse Events', 'desc' => 'Search and filter thousands of local events by category, date, and location — no account needed.'],
                    ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'step' => '02', 'title' => 'Create an Account', 'desc' => 'Register in seconds, verify your email, and unlock the full experience including RSVPs and bookmarks.'],
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'step' => '03', 'title' => 'RSVP & Attend', 'desc' => 'Confirm your attendance, get email reminders the day before, and connect with your local community.'],
                ] as $item)
                <div class="relative bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="absolute top-6 right-6 text-6xl font-black text-gray-50 group-hover:text-gray-100 transition-colors select-none leading-none">{{ $item['step'] }}</div>
                    <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== UPCOMING EVENTS ===================== --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Don't Miss Out</span>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight mt-2">Upcoming Events</h2>
                </div>
                <a href="{{ route('events.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-gray-900 hover:text-gray-600 transition-colors group">
                    View all
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($upcomingEvents as $event)
                    <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                        {{-- Image --}}
                        <div class="h-52 relative overflow-hidden bg-gray-900">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950 group-hover:from-gray-700 transition-all duration-500 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                            {{-- Date badge --}}
                            <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-2 text-center shadow-lg">
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                <span class="block text-xl font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                            </div>

                            {{-- Category badge --}}
                            <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm border border-white/10 rounded-full px-3 py-1 text-xs font-semibold text-white">
                                {{ $event->category?->name ?? 'General' }}
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors">{{ $event->title }}</h3>
                            <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                </span>
                                @if($event->location)
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center gap-1 truncate">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="truncate">{{ $event->location }}</span>
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-gray-50 mt-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $event->price > 0 ? 'bg-gray-900 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-100/60' }}">
                                        {{ $event->price > 0 ? '₹' . number_format($event->price, 2) : 'Free' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $event->rsvps->where('status','yes')->count() }} attending
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-gray-900 group-hover:underline">View event →</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center bg-gray-50 rounded-3xl border border-gray-100">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700 mb-1">No upcoming events yet</h3>
                        <p class="text-sm text-gray-400 mb-5">Be the first to host one in your community!</p>
                        @auth
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition-colors">Create Event</a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition-colors">Join & Create</a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <div class="mt-10 text-center sm:hidden">
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 hover:text-gray-600">
                    View all events
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== CTA BANNER ===================== --}}
    <section class="py-24 bg-gray-950 relative overflow-hidden">
        <div class="absolute inset-0 hero-grid opacity-50"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-gray-700 rounded-full opacity-10 blur-[80px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-gray-600 rounded-full opacity-10 blur-[60px] pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto px-6 md:px-10 text-center">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-gray-500 mb-4">For Organizers</span>
            <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">Ready to host your own event?</h2>
            <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto">Join our growing community of organizers. Create events, manage RSVPs, and track attendance — all in one place.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                        <a href="{{ route('events.create') }}" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 hover:shadow-xl transition-all">
                            Create an Event
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition-all">
                            Go to Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-50 hover:shadow-xl transition-all">
                        Get Started — It's Free
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 border border-white/20 text-white font-semibold rounded-full hover:bg-white/10 transition-all">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="bg-gray-950 border-t border-white/5 py-12">
        <div class="max-w-7xl mx-auto px-6 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-gray-800 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-white font-black tracking-tight">LECS.</span>
                    <span class="text-gray-600 text-sm ml-2">Local Event Calendar System</span>
                </div>

                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <a href="{{ route('events.index') }}" class="hover:text-gray-300 transition-colors">Browse Events</a>
                    <a href="{{ route('register') }}" class="hover:text-gray-300 transition-colors">Register</a>
                    <a href="{{ route('login') }}" class="hover:text-gray-300 transition-colors">Login</a>
                    <a href="{{ route('admin.login') }}" class="hover:text-gray-300 transition-colors">Admin</a>
                </div>

                <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} LECS. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
