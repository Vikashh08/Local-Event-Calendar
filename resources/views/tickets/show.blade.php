<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-2xl mx-auto px-6">
            
            {{-- Back link --}}
            <div class="mb-8">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    My Tickets
                </a>
            </div>

            {{-- THE TICKET --}}
            <div class="relative animate-fade-up">
                {{-- Card Top (Hero) --}}
                <div class="bg-white rounded-t-[40px] overflow-hidden">
                    <div class="h-64 relative bg-gray-900">
                        @if($rsvp->event->image)
                            <img src="{{ Storage::url($rsvp->event->image) }}" alt="{{ $rsvp->event->title }}" class="w-full h-full object-cover opacity-90">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-black"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/10 to-transparent"></div>
                        
                        {{-- Category Badge --}}
                        <div class="absolute top-8 left-8">
                            <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-lg text-[10px] font-black text-white uppercase tracking-widest border border-white/20">
                                {{ $rsvp->event->category?->name ?? 'General' }}
                            </span>
                        </div>

                        {{-- Event Logo/Name --}}
                        <div class="absolute bottom-6 left-8 right-8">
                            <h1 class="text-3xl font-black text-gray-900 tracking-tighter leading-tight">{{ $rsvp->event->title }}</h1>
                        </div>
                    </div>

                    {{-- Card Details --}}
                    <div class="px-8 pb-10 pt-4">
                        <div class="grid grid-cols-2 gap-8 py-8 border-b border-gray-100">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Date</p>
                                <p class="text-gray-900 font-black text-lg">{{ \Carbon\Carbon::parse($rsvp->event->date)->format('l, M d') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Entry Time</p>
                                <p class="text-gray-900 font-black text-lg">{{ \Carbon\Carbon::parse($rsvp->event->time)->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8 py-8 border-b border-gray-100">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Ticket Holder</p>
                                <p class="text-gray-900 font-black text-lg">{{ $rsvp->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Booking ID</p>
                                <p class="text-gray-900 font-black text-lg uppercase tracking-tight">{{ substr($rsvp->payment_id ?? 'TICK-'.uniqid(), 0, 10) }}</p>
                            </div>
                        </div>

                        <div class="py-8">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Venue</p>
                            <p class="text-gray-900 font-bold text-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $rsvp->event->location ?? 'To Be Announced' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Middle (Dashed Line & Notches) --}}
                <div class="relative bg-white h-8 flex items-center">
                    <div class="absolute left-[-16px] w-8 h-8 bg-gray-950 rounded-full z-10"></div>
                    <div class="absolute right-[-16px] w-8 h-8 bg-gray-950 rounded-full z-10"></div>
                    <div class="w-full border-t-2 border-dashed border-gray-100 mx-4"></div>
                </div>

                {{-- Card Bottom (QR Code Section) --}}
                <div class="bg-white rounded-b-[40px] px-8 py-10 text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Scan at Entry Gate</p>
                    
                    <div class="inline-block p-4 bg-gray-50 rounded-3xl border border-gray-100 mb-8 transform hover:scale-105 transition-transform duration-300">
                        {{-- Simulated QR Code using SVG --}}
                        <div class="w-48 h-48 bg-gray-900 rounded-xl flex items-center justify-center p-3">
                            <svg class="w-full h-full text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 3h6v6H3V3zm1 1v4h4V4H4zm1 1h2v2H5V5zM3 15h6v6H3v-6zm1 1v4h4v-4H4zm1 1h2v2H5v-2zM15 3h6v6h-6V3zm1 1v4h4V4h-4zm1 1h2v2h-2V5zM15 15h2v2h-2v-2zm2 2h2v2h-2v-2zm2-2h2v2h-2v-2zm-2 4h2v2h-2v-2zm2 2h2v-2h-2v2zm0-4V15h2v2h-2zM10 3h4v2h-4V3zm0 4h4v2h-4V7zm0 4h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm-2 4h4v-2h-4v2z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-gray-900 font-black uppercase tracking-widest text-sm">Valid Pass</p>
                        <p class="text-gray-400 text-xs font-medium max-w-xs mx-auto">Please present this digital pass at the venue entrance. Screenshot or download is acceptable.</p>
                    </div>

                    <div class="mt-10 flex justify-center gap-4">
                        <button onclick="window.print()" class="px-6 py-3 bg-gray-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all shadow-lg flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Pass
                        </button>
                    </div>
                </div>
            </div>

            {{-- Security Notice --}}
            <div class="mt-10 text-center">
                <p class="text-gray-600 text-[10px] font-bold uppercase tracking-[0.2em]">End-to-End Secure • LECS Verified</p>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeSlideUp { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        
        @media print {
            body * { visibility: hidden; }
            .animate-fade-up, .animate-fade-up * { visibility: visible; }
            .animate-fade-up { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</x-app-layout>
