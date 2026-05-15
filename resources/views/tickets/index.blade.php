<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Your Bookings</p>
                <h2 class="font-black text-3xl text-gray-900 tracking-tight mt-0.5">
                    {{ __('My Tickets') }}
                </h2>
            </div>
            <div class="bg-gray-100 rounded-2xl px-4 py-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                <span class="text-sm font-bold text-gray-900">{{ $tickets->count() }} Active Tickets</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($tickets->isEmpty())
                <div class="flex flex-col items-center justify-center p-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-center animate-fade-in">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">No active tickets yet</h3>
                    <p class="text-gray-500 max-w-sm mb-8">Once you book an event, your digital ticket and entry pass will appear here.</p>
                    <a href="{{ route('events.index') }}" class="px-8 py-4 bg-gray-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-black transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        Find Events to Attend
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tickets as $ticket)
                        @php $event = $ticket->event; @endphp
                        <div class="group relative animate-fade-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full">
                                {{-- Ticket Header --}}
                                <div class="h-44 relative overflow-hidden bg-gray-950">
                                    @if($event->image)
                                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent"></div>
                                    
                                    <div class="absolute bottom-4 left-6 right-6">
                                        <span class="inline-block px-2 py-0.5 bg-white/20 backdrop-blur-md rounded text-[9px] font-black text-white uppercase tracking-widest border border-white/20 mb-2">
                                            {{ $event->category?->name ?? 'General' }}
                                        </span>
                                        <h3 class="text-white font-black text-lg leading-tight line-clamp-1">{{ $event->title }}</h3>
                                    </div>
                                </div>

                                {{-- Ticket Body --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-50">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Date</p>
                                            <p class="text-gray-900 font-black text-sm">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Time</p>
                                            <p class="text-gray-900 font-black text-sm">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-8">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Venue</p>
                                        <p class="text-gray-900 font-bold text-sm line-clamp-1 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $event->location ?? 'TBA' }}
                                        </p>
                                    </div>

                                    <div class="mt-auto pt-4">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="w-full flex items-center justify-center gap-2 py-4 bg-gray-50 hover:bg-gray-900 hover:text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all group/btn">
                                            <span>View Entry Pass</span>
                                            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Ticket Decorative Notches --}}
                            <div class="absolute left-[-8px] top-1/2 -translate-y-1/2 w-4 h-8 bg-gray-50 rounded-full border-r border-gray-100 hidden lg:block"></div>
                            <div class="absolute right-[-8px] top-1/2 -translate-y-1/2 w-4 h-8 bg-gray-50 rounded-full border-l border-gray-100 hidden lg:block"></div>
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
