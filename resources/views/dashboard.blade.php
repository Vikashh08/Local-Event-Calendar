<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                @if(Auth::user()->role === 'organizer')
                    <p class="text-[11px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Organizer Console</p>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                    </h1>
                    <p class="text-sm font-medium text-slate-500 mt-1">
                        Your events are live and accepting registrations. Here's how things are looking today.
                    </p>
                @else
                    <p class="text-[11px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Attendee Dashboard</p>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">
                        Hey, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                    </h1>
                    <p class="text-sm font-medium text-slate-500 mt-1">
                        Ready to discover something new? Your bookings and saved events are all here.
                    </p>
                @endif
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @if(Auth::user()->role === 'organizer')
                    <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-indigo-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Event
                    </a>
                @else
                    <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-indigo-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Browse Events
                    </a>
                @endif

                <div class="flex items-center gap-2 bg-white border border-slate-200 px-3 py-2.5 rounded-xl shadow-sm">
                    <span class="relative flex h-2 w-2 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-slate-600 tracking-wider uppercase">{{ strtoupper(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ activeTab: '{{ Auth::user()->role === 'organizer' ? 'overview' : 'rsvps' }}' }" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ===================== ATTENDEE METRIC CARDS ===================== --}}
        @if(Auth::user()->role === 'user')
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div @click="activeTab = 'rsvps'" class="cursor-pointer bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $rsvps->count() }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Active Passes</p>
                    </div>
                </div>

                <div @click="activeTab = 'bookmarks'" class="cursor-pointer bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $bookmarks->count() }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Saved Bookmarks</p>
                    </div>
                </div>

                <a href="{{ route('events.index') }}" class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden block">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-1.5 mt-1">
                            Discover
                            <svg class="w-4 h-4 text-emerald-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Explore Events</p>
                    </div>
                </a>
            </div>
        @endif

        {{-- ===================== TAB NAVIGATION ===================== --}}
        <div class="flex overflow-x-auto scrollbar-none gap-1 bg-slate-100/70 p-1.5 rounded-2xl mb-8 w-fit">
            @if(Auth::user()->role === 'organizer')
                <button @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 whitespace-nowrap">
                    Overview
                </button>
                <button @click="activeTab = 'events'"
                        :class="activeTab === 'events' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 whitespace-nowrap">
                    Manage Events
                </button>
            @else
                <button @click="activeTab = 'rsvps'"
                        :class="activeTab === 'rsvps' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 whitespace-nowrap">
                    My RSVPs & Passes
                    <span class="ml-1.5 text-[10px] font-black px-1.5 py-0.5 rounded-full"
                          :class="activeTab === 'rsvps' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-200 text-slate-500'">{{ $rsvps->count() }}</span>
                </button>
                <button @click="activeTab = 'bookmarks'"
                        :class="activeTab === 'bookmarks' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 whitespace-nowrap">
                    Saved Bookmarks
                    <span class="ml-1.5 text-[10px] font-black px-1.5 py-0.5 rounded-full"
                          :class="activeTab === 'bookmarks' ? 'bg-blue-100 text-blue-600' : 'bg-slate-200 text-slate-500'">{{ $bookmarks->count() }}</span>
                </button>
            @endif
        </div>

        {{-- Alert Banner --}}
        @if(session('success') || session('error'))
            <div class="mb-6">
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-2xl text-sm font-semibold">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-2xl text-sm font-semibold">
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        {{-- ===================== ORGANIZER VIEWS ===================== --}}
        @if(Auth::user()->role === 'organizer')

            {{-- Tab: Overview --}}
            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">

                {{-- Metric Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -translate-y-16 translate-x-16 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $totalEvents }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Events Hosted</p>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -translate-y-16 translate-x-16 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $totalAttendees }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Total Attendees</p>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -translate-y-16 translate-x-16 group-hover:scale-125 transition-transform duration-500"></div>
                        <div class="relative">
                            <div class="w-12 h-12 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2 .895 2 2m-2-2v12"/></svg>
                            </div>
                            <h3 class="text-4xl font-black text-slate-900 tracking-tight">₹{{ number_format($totalRevenue, 0) }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Total Revenue</p>
                        </div>
                    </div>
                </div>

                {{-- Recent Registrations --}}
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900 text-sm">Recent Registrations</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Latest bookings across all your hosted events</p>
                    </div>
                    @if($recentRegistrations->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-200">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">No registrations yet.</p>
                            <p class="text-xs text-slate-400 mt-1">Bookings will appear here once people register for your events.</p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($recentRegistrations as $registration)
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 text-indigo-700 font-black rounded-xl flex items-center justify-center text-sm shadow-sm shrink-0">
                                            {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">{{ $registration->user->name }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Booked
                                                <a href="{{ route('events.show', $registration->event) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">{{ $registration->event->title }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-[10px] font-semibold text-slate-400">{{ $registration->created_at->diffForHumans() }}</p>
                                        @if($registration->payment_status === 'paid')
                                            <span class="inline-block mt-1 text-[9px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 uppercase tracking-widest">Paid</span>
                                        @else
                                            <span class="inline-block mt-1 text-[9px] font-black text-slate-500 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-200 uppercase tracking-widest">Free</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab: Manage Events --}}
            <div x-show="activeTab === 'events'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-data="{ hostedQuery: '' }" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Manage Hosted Events</h2>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Check attendee logs, edit, or remove your event listings.</p>
                    </div>
                    <div class="relative w-full sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input x-model="hostedQuery" type="text" placeholder="Search your events..." class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm pl-9 pr-4 py-2.5 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 outline-none font-semibold">
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    @if($hostedEvents->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-200">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">No Hosted Events</h3>
                            <p class="text-slate-500 text-xs mb-6 max-w-sm">You haven't published any events yet. Create your first listing to start hosting!</p>
                            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Create Event
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="bg-slate-50/80 border-b border-slate-200">
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Event</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pricing</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Attendees</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenue</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($hostedEvents as $event)
                                        <tr x-show="hostedQuery === '' || $el.innerText.toLowerCase().includes(hostedQuery.toLowerCase())" class="hover:bg-slate-50/60 transition-colors">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('events.show', $event) }}" target="_blank" class="font-bold text-slate-900 hover:text-indigo-600 transition-colors line-clamp-1">{{ $event->title }}</a>
                                            </td>
                                            <td class="px-6 py-4 text-xs font-semibold text-slate-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($event->price > 0)
                                                    <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-bold text-xs">₹{{ number_format($event->price, 0) }}</span>
                                                @else
                                                    <span class="inline-flex px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-xs">Free</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-black text-slate-900">{{ $event->attendees_count }}</td>
                                            <td class="px-6 py-4 text-sm font-black text-slate-900">₹{{ number_format($event->price * $event->attendees_count, 0) }}</td>
                                            <td class="px-6 py-4">
                                                @if($event->status === 'approved')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-widest">
                                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Live
                                                    </span>
                                                @elseif($event->status === 'pending')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[9px] font-black bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-widest animate-pulse">
                                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Pending
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[9px] font-black bg-slate-50 text-slate-500 border border-slate-200 uppercase tracking-widest">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('events.attendees', $event) }}" class="px-2.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-lg transition-all">Attendees</a>
                                                    <a href="{{ route('events.edit', $event) }}" class="px-2.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-lg transition-all">Edit</a>
                                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event permanently?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold uppercase tracking-wider text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 hover:border-rose-600 rounded-lg transition-all">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        @endif {{-- end organizer --}}

        {{-- ===================== ATTENDEE VIEWS ===================== --}}
        @if(Auth::user()->role === 'user')

            {{-- Tab: My RSVPs & Passes --}}
            <div x-show="activeTab === 'rsvps'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-data="{ rsvpQuery: '' }" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">My RSVPs & Entry Passes</h2>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Your event bookings and confirmed passes.</p>
                    </div>
                    <div class="relative w-full sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input x-model="rsvpQuery" type="text" placeholder="Search your bookings..." class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm pl-9 pr-4 py-2.5 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 outline-none font-semibold">
                    </div>
                </div>

                @if($rsvps->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 bg-white border border-slate-200 rounded-3xl shadow-sm text-center">
                        <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4 border border-indigo-100">
                            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No RSVPs Yet</h3>
                        <p class="text-slate-500 text-xs mb-6 max-w-sm">You haven't booked any events. Browse upcoming events and reserve your spot!</p>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            Browse Events
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($rsvps as $rsvp)
                            @php $event = $rsvp->event; @endphp
                            <div x-show="rsvpQuery === '' || $el.innerText.toLowerCase().includes(rsvpQuery.toLowerCase())"
                                 class="bg-white border border-slate-200/80 rounded-3xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">

                                {{-- Ticket notch effect --}}
                                <div class="absolute top-[160px] -left-3 w-6 h-6 bg-slate-50 rounded-full border-r border-slate-200 z-10"></div>
                                <div class="absolute top-[160px] -right-3 w-6 h-6 bg-slate-50 rounded-full border-l border-slate-200 z-10"></div>

                                {{-- Event Image --}}
                                <div class="h-40 relative bg-slate-100 rounded-t-3xl overflow-hidden">
                                    @if($event->image)
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm rounded-xl px-2.5 py-1.5 text-center shadow border border-white/50">
                                        <span class="block text-[9px] font-black text-indigo-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                        <span class="block text-lg font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                    </div>

                                    <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider border border-white/20 shadow backdrop-blur-sm bg-black/40 text-white">
                                        {{ ucfirst($rsvp->status) }}
                                    </div>
                                </div>

                                {{-- Dashed divider --}}
                                <div class="relative border-t border-dashed border-slate-200 mx-4"></div>

                                {{-- Content --}}
                                <div class="p-5 flex-1 flex flex-col">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-2 hover:text-indigo-600 transition-colors">
                                            <a href="{{ route('events.show', $event) }}" target="_blank">{{ $event->title }}</a>
                                        </h3>
                                        @if($rsvp->payment_status === 'paid')
                                            <span class="shrink-0 text-[8px] font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 uppercase tracking-wider">Paid</span>
                                        @else
                                            <span class="shrink-0 text-[8px] font-black text-slate-500 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-200 uppercase tracking-wider">Free</span>
                                        @endif
                                    </div>

                                    <div class="space-y-1.5 text-xs text-slate-500 font-semibold mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                        </div>
                                        @if($event->location)
                                            <div class="flex items-center gap-2 truncate">
                                                <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                                <span class="truncate">{{ $event->location }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <a href="{{ route('tickets.show', $rsvp) }}"
                                       class="mt-auto block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm hover:shadow-indigo-600/20 hover:shadow-md">
                                        View Entry Pass →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tab: Saved Bookmarks --}}
            <div x-show="activeTab === 'bookmarks'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-data="{ bookmarkQuery: '' }" class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Saved Bookmarks</h2>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Events you're interested in — book before they sell out!</p>
                    </div>
                    <div class="relative w-full sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input x-model="bookmarkQuery" type="text" placeholder="Search bookmarks..." class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm pl-9 pr-4 py-2.5 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/10 outline-none font-semibold">
                    </div>
                </div>

                @if($bookmarks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 bg-white border border-slate-200 rounded-3xl shadow-sm text-center">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-4 border border-blue-100">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No Bookmarks Saved</h3>
                        <p class="text-slate-500 text-xs mb-6 max-w-sm">Save events you're interested in to track them here.</p>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                            Browse Events
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($bookmarks as $bookmark)
                            @php $event = $bookmark->event; @endphp
                            <div x-show="bookmarkQuery === '' || $el.innerText.toLowerCase().includes(bookmarkQuery.toLowerCase())"
                                 class="bg-white border border-slate-200/80 rounded-3xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">

                                {{-- Remove button --}}
                                <form action="{{ route('bookmarks.destroy', $event) }}" method="POST" class="absolute top-3 right-3 z-20">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-white/95 backdrop-blur-sm p-1.5 rounded-full text-rose-500 hover:text-white hover:bg-rose-500 shadow-sm border border-white/50 transition-all" title="Remove Bookmark">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                    </button>
                                </form>

                                {{-- Event Image --}}
                                <div class="h-44 relative bg-slate-100 rounded-t-3xl overflow-hidden">
                                    @if($event->image)
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm rounded-xl px-2.5 py-1.5 text-center shadow border border-white/50">
                                        <span class="block text-[9px] font-black text-blue-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                        <span class="block text-lg font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                    </div>

                                    <div class="absolute bottom-3 left-3 right-10">
                                        <div class="bg-black/40 backdrop-blur-sm border border-white/10 rounded-full px-2.5 py-0.5 inline-block text-[9px] font-black text-white uppercase tracking-wider">
                                            {{ $event->category?->name ?? 'General' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-5 flex-1 flex flex-col">
                                    <h3 class="text-sm font-bold text-slate-900 leading-snug line-clamp-2 mb-3 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('events.show', $event) }}" target="_blank">{{ $event->title }}</a>
                                    </h3>

                                    <div class="space-y-1.5 text-xs text-slate-500 font-semibold mb-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                        </div>
                                        @if($event->location)
                                            <div class="flex items-center gap-2 truncate">
                                                <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                                <span class="truncate">{{ $event->location }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center mb-4 mt-auto">
                                        <span class="text-xs font-black {{ $event->price > 0 ? 'text-slate-900' : 'text-emerald-600' }}">
                                            {{ $event->price > 0 ? '₹'.number_format($event->price, 0) : 'Free' }}
                                        </span>
                                    </div>

                                    <a href="{{ route('events.show', $event) }}"
                                       class="block w-full text-center py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm hover:shadow-blue-600/20 hover:shadow-md">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        @endif {{-- end user role --}}

    </div>
</x-app-layout>
