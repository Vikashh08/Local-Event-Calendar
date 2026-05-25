<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-600">Your Bookings</p>
                <h2 class="font-black text-3xl text-slate-900 tracking-tight mt-0.5">
                    {{ __('My Tickets & Passes') }}
                </h2>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl px-4 py-2.5 flex items-center gap-2.5 shadow-sm">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                <span class="text-xs font-bold text-slate-700">{{ $tickets->count() }} Active Tickets</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($tickets->isEmpty())
                <div class="flex flex-col items-center justify-center p-16 bg-white rounded-3xl border border-slate-200 text-center shadow-sm">
                    <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 border border-indigo-100 text-indigo-650">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">No active tickets yet</h3>
                    <p class="text-slate-500 max-w-sm mb-8 text-xs font-medium">Once you book an event, your digital ticket and entry pass will appear here.</p>
                    <a href="{{ route('events.index') }}" class="px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-md">
                        Find Events to Attend
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tickets as $ticket)
                        @php $event = $ticket->event; @endphp
                        <div class="group relative animate-fade-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="bg-white rounded-[32px] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/80 flex flex-col h-full relative">
                                <!-- Side Notches to Mimic Ticket -->
                                <div class="absolute top-[170px] -left-3 w-6 h-6 bg-slate-50 rounded-full border-r border-slate-200 z-10"></div>
                                <div class="absolute top-[170px] -right-3 w-6 h-6 bg-slate-50 rounded-full border-l border-slate-200 z-10"></div>

                                {{-- Ticket Header --}}
                                <div class="h-44 relative overflow-hidden bg-slate-100">
                                    @if($event->image)
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-indigo-100"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                    
                                    <div class="absolute bottom-4 left-6 right-6">
                                        <span class="inline-block px-2.5 py-0.5 bg-white/20 backdrop-blur-md rounded text-[9px] font-black text-white uppercase tracking-widest border border-white/20 mb-2">
                                            {{ $event->category?->name ?? 'General' }}
                                        </span>
                                        <h3 class="text-white font-black text-lg leading-tight line-clamp-1">{{ $event->title }}</h3>
                                    </div>
                                </div>

                                {{-- Ticket Body --}}
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div class="grid grid-cols-2 gap-4 pb-6 border-b border-dashed border-slate-150 mb-4">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Date</p>
                                            <p class="text-slate-900 font-black text-sm">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-405 uppercase tracking-widest mb-1">Time</p>
                                            <p class="text-slate-900 font-black text-sm">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Venue</p>
                                        <p class="text-slate-800 font-semibold text-xs line-clamp-1 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $event->location ?? 'TBA' }}</span>
                                        </p>
                                    </div>

                                    <div class="mt-auto pt-2">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-900 hover:bg-indigo-650 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-sm">
                                            <span>View Entry Pass</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fadeSlideUp 0.6s ease-out forwards; }
    </style>
</x-app-layout>
