<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LECS — Discover Local Events Near You</title>
    <meta name="description" content="Find concerts, workshops, meetups, and more happening right in your neighborhood. RSVP, book tickets, and never miss out with LECS.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fafafa; color: #0f172a; }

        /* Hero dark section */
        .hero-dark {
            background: #0f172a;
        }
        .dot-pattern {
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 26px 26px;
        }

        /* Subtle noise texture for hero */
        .hero-noise::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: 0.4;
        }

        /* Search input */
        .search-wrap {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
        }
        .search-wrap:focus-within {
            border-color: rgba(16,185,129,0.5);
            box-shadow: 0 0 0 4px rgba(16,185,129,0.08);
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-6px); }
        }
        .anim-up   { animation: fadeUp 0.65s cubic-bezier(0.16,1,0.3,1) both; }
        .d1 { animation-delay: 0.05s; }
        .d2 { animation-delay: 0.12s; }
        .d3 { animation-delay: 0.20s; }
        .d4 { animation-delay: 0.28s; }
        .d5 { animation-delay: 0.36s; }
        .float-card { animation: subtleFloat 6s ease-in-out infinite; }

        /* Event card */
        .event-card { transition: transform 0.3s cubic-bezier(0.16,1,0.3,1), box-shadow 0.3s ease; }
        .event-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px -12px rgba(0,0,0,0.18); }

        /* CTA button */
        .btn-primary {
            background: #0f172a;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(15,23,42,0.3);
        }
        .btn-accent {
            background: #059669;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-accent:hover {
            background: #047857;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(5,150,105,0.3);
        }

        /* Navbar */
        .nav-scrolled {
            background: rgba(15,23,42,0.92) !important;
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

{{-- ============================== NAVBAR ============================== --}}
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 py-5"
     x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = window.scrollY > 40"
     :class="scrolled ? 'nav-scrolled !py-3' : 'py-5'">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0">
            <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-xl font-black text-white tracking-tight">LECS.</span>
        </a>

        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('events.index') }}" class="px-4 py-2 text-sm font-semibold text-white/60 hover:text-white hover:bg-white/8 rounded-xl transition-all">Browse Events</a>
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white/60 hover:text-white hover:bg-white/8 rounded-xl transition-all">Dashboard</a>
                @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                    <a href="{{ route('events.create') }}" class="ml-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-sm">
                        + Create Event
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-white/60 hover:text-white hover:bg-white/8 rounded-xl transition-all">Log in</a>
                <a href="{{ route('register') }}" class="ml-2 px-5 py-2.5 bg-white text-slate-900 text-xs font-black uppercase tracking-wider rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                    Get Started
                </a>
            @endauth
        </div>

        <div class="flex md:hidden items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-white/70 hover:text-white">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-white/60 hover:text-white">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-slate-900 text-xs font-black rounded-xl">Join</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ============================== HERO ============================== --}}
<section class="hero-dark hero-noise dot-pattern relative min-h-screen flex items-center justify-center overflow-hidden pt-20 pb-24">

    {{-- Radial glow — single warm tone --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-emerald-900/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">

        {{-- Live badge --}}
        <div class="anim-up d1 inline-flex items-center gap-2.5 bg-white/6 border border-white/10 rounded-full px-4 py-2 text-xs text-white/60 font-bold mb-10">
            <span class="relative flex w-2 h-2 shrink-0">
                <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
            </span>
            Events happening near you right now
        </div>

        {{-- Headline — clean white, no gradients --}}
        <h1 class="anim-up d2 font-black text-white tracking-tight leading-[0.9] mb-7" style="font-size: clamp(3.5rem, 10vw, 7rem);">
            Discover<br>
            <span class="text-white/80">Local Events.</span>
        </h1>

        <p class="anim-up d3 text-white/45 text-base sm:text-lg font-medium leading-relaxed max-w-xl mx-auto mb-10">
            Find workshops, festivals, meetups and more happening right in your city. Book tickets and never miss what's next.
        </p>

        {{-- Search bar --}}
        <form action="{{ route('events.index') }}" method="GET" class="anim-up d4 max-w-xl mx-auto mb-8">
            <div class="search-wrap flex items-center rounded-2xl p-2 transition-all duration-200">
                <div class="pl-3 shrink-0">
                    <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Search events, venues..."
                       class="flex-1 bg-transparent border-none text-white placeholder-white/25 text-sm font-semibold px-4 py-2.5 focus:ring-0 outline-none">
                <button type="submit" class="btn-accent text-white text-xs font-black uppercase tracking-wider px-5 py-2.5 rounded-xl shrink-0">
                    Search
                </button>
            </div>
        </form>

        {{-- Category pills --}}
        @if($categories->count() > 0)
            <div class="anim-up d4 flex flex-wrap justify-center gap-2 mb-16">
                <span class="self-center text-[10px] font-black text-white/25 uppercase tracking-widest mr-1">Quick:</span>
                @foreach($categories->take(6) as $category)
                    <a href="{{ route('events.index', ['category' => $category->id]) }}"
                       class="px-3.5 py-1.5 rounded-full bg-white/5 border border-white/8 text-white/50 text-xs font-semibold hover:bg-white/10 hover:text-white/80 hover:border-white/15 transition-all duration-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @else
            <div class="mb-16"></div>
        @endif

        {{-- Stats --}}
        <div class="anim-up d5 flex flex-wrap justify-center gap-4">
            <div class="bg-white/5 border border-white/8 rounded-2xl px-7 py-4 text-center float-card" style="animation-delay:0s">
                <p class="text-3xl font-black text-white leading-none">{{ \App\Models\Event::approved()->count() }}+</p>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mt-1.5">Live Events</p>
            </div>
            <div class="bg-white/5 border border-white/8 rounded-2xl px-7 py-4 text-center float-card" style="animation-delay:2s">
                <p class="text-3xl font-black text-white leading-none">{{ \App\Models\User::count() }}+</p>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mt-1.5">Members</p>
            </div>
            <div class="bg-white/5 border border-white/8 rounded-2xl px-7 py-4 text-center float-card" style="animation-delay:4s">
                <p class="text-3xl font-black text-white leading-none">{{ \App\Models\Rsvp::count() }}+</p>
                <p class="text-[10px] font-bold text-white/30 uppercase tracking-widest mt-1.5">Bookings</p>
            </div>
        </div>
    </div>

    {{-- Clean wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 64" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full">
            <path d="M0,32 C480,64 960,0 1440,32 L1440,64 L0,64 Z" fill="#fafafa"/>
        </svg>
    </div>
</section>

{{-- ============================== HOW IT WORKS ============================== --}}
<section class="py-24 bg-[#fafafa]">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-16">
            <span class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 px-4 py-1.5 rounded-full mb-4">How It Works</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Three steps to your next event</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach([
                ['step'=>'01','icon'=>'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z','title'=>'Browse Events','desc'=>'Search and filter local events by category, date, and venue. No login needed to explore.'],
                ['step'=>'02','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','title'=>'Create an Account','desc'=>'Sign up in seconds. Save bookmarks, manage RSVPs, and get digital entry passes.'],
                ['step'=>'03','icon'=>'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z','title'=>'Book & Attend','desc'=>'Confirm your spot or pay for a ticket. Check in with your digital pass on the day.'],
            ] as $item)
            <div class="relative bg-white border border-slate-200/80 rounded-3xl p-8 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
                <div class="absolute top-5 right-6 text-7xl font-black text-slate-50 select-none leading-none group-hover:text-slate-100 transition-colors">{{ $item['step'] }}</div>
                <div class="relative">
                    <div class="w-11 h-11 bg-slate-900 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-black text-slate-900 text-base mb-2 tracking-tight">{{ $item['title'] }}</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== UPCOMING EVENTS ============================== --}}
<section class="py-24 bg-white border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <span class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 px-4 py-1.5 rounded-full mb-3">Don't Miss Out</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Upcoming Events</h2>
            </div>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-600 hover:text-slate-900 uppercase tracking-wider transition-colors group shrink-0">
                View All
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($upcomingEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="event-card group block bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm flex flex-col">

                    <div class="relative h-52 overflow-hidden bg-slate-100 shrink-0">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/55 via-transparent to-transparent"></div>

                        {{-- Date badge --}}
                        <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-2 text-center shadow">
                            <span class="block text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                            <span class="block text-xl font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                        </div>

                        {{-- Category --}}
                        <div class="absolute top-4 right-4 bg-black/40 backdrop-blur-sm rounded-full px-3 py-1 text-[9px] font-black text-white uppercase tracking-wider">
                            {{ $event->category?->name ?? 'General' }}
                        </div>

                        {{-- Price --}}
                        <div class="absolute bottom-4 right-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $event->price > 0 ? 'bg-white text-slate-900 shadow' : 'bg-emerald-500 text-white' }}">
                                {{ $event->price > 0 ? '₹'.number_format($event->price, 0) : 'FREE' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-2 mb-3 group-hover:text-emerald-700 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold text-slate-400 mb-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                            </span>
                            @if($event->location)
                                <span class="text-slate-200">•</span>
                                <span class="flex items-center gap-1 truncate max-w-[140px]">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span class="truncate">{{ $event->location }}</span>
                                </span>
                            @endif
                        </div>

                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100">
                            <span class="text-xs font-semibold text-slate-400">
                                {{ $event->rsvps->where('status','yes')->count() }} attending
                            </span>
                            <span class="text-xs font-black text-slate-700 group-hover:text-emerald-600 inline-flex items-center gap-1 transition-colors">
                                View →
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center bg-[#fafafa] rounded-3xl border border-slate-200">
                    <div class="w-16 h-16 bg-white border border-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">No upcoming events yet</h3>
                    <p class="text-sm text-slate-500 font-medium mb-6">Be the first to publish one in your neighborhood!</p>
                    @auth
                        <a href="{{ route('events.create') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-wider">Create Event</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary inline-flex items-center px-6 py-3 rounded-xl text-xs font-black uppercase tracking-wider">Join & Create</a>
                    @endauth
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================== FEATURE TILES ============================== --}}
<section class="py-24 bg-[#fafafa] border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="text-center mb-14">
            <span class="inline-block text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 px-4 py-1.5 rounded-full mb-4">Platform Features</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Built for everyone</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['icon'=>'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z','title'=>'Digital Tickets','desc'=>'QR-code entry passes delivered instantly to your dashboard.'],
                ['icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.11.895 2 2m-2-2v14','title'=>'Paid Events','desc'=>'Organizers charge for tickets with a secure checkout flow.'],
                ['icon'=>'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z','title'=>'Save Bookmarks','desc'=>'Keep a personal shortlist of events you want to attend.'],
                ['icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','title'=>'Organizer Stats','desc'=>'Track attendees, revenue, and registrations in real time.'],
            ] as $f)
            <div class="bg-white border border-slate-200/80 rounded-3xl p-7 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
                <div class="w-10 h-10 bg-slate-900 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-black text-slate-900 text-sm mb-1.5 tracking-tight">{{ $f['title'] }}</h3>
                <p class="text-xs font-medium text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================== CTA ============================== --}}
<section class="py-24 bg-white border-t border-slate-100">
    <div class="max-w-5xl mx-auto px-6 lg:px-10">
        <div class="relative overflow-hidden bg-slate-900 rounded-3xl p-12 sm:p-16 text-center">
            <div class="absolute inset-0 dot-pattern opacity-50 pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/8 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10">
                <span class="inline-block text-[10px] font-black uppercase tracking-widest text-emerald-400 bg-emerald-400/10 border border-emerald-400/20 px-4 py-1.5 rounded-full mb-6">For Organizers</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4 leading-tight">
                    Ready to Host<br class="hidden sm:block"> Your Own Events?
                </h2>
                <p class="text-white/40 font-medium text-sm leading-relaxed max-w-lg mx-auto mb-10">
                    Create event listings, manage RSVPs, handle paid tickets, and track attendance — all in one place.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                            <a href="{{ route('events.create') }}" class="btn-accent inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-wider shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Create an Event
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-accent inline-flex items-center justify-center px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-wider shadow-lg">
                                Go to Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn-accent inline-flex items-center justify-center px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-wider shadow-lg">
                            Get Started — It's Free
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/6 hover:bg-white/10 border border-white/10 text-white font-bold text-sm uppercase tracking-wider rounded-2xl transition-all">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================== FOOTER ============================== --}}
<footer class="bg-[#fafafa] border-t border-slate-100 py-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-lg font-black text-slate-900 tracking-tight">LECS.</span>
            <span class="text-xs font-medium text-slate-400 ml-1">Local Event Calendar System</span>
        </div>

        <nav class="flex flex-wrap justify-center gap-x-6 gap-y-2">
            <a href="{{ route('events.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Browse</a>
            <a href="{{ route('register') }}" class="text-xs font-bold text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Register</a>
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Login</a>
            <a href="{{ route('admin.login') }}" class="text-xs font-bold text-slate-400 hover:text-slate-700 uppercase tracking-widest transition-colors">Admin</a>
        </nav>

        <p class="text-xs font-medium text-slate-400">&copy; {{ date('Y') }} LECS. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
