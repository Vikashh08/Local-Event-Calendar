<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-widest group">
                <span class="w-7 h-7 bg-white border border-slate-200 rounded-lg flex items-center justify-center shadow-sm group-hover:bg-indigo-50 group-hover:border-indigo-200 transition-all">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </span>
                All Events
            </a>
            <div class="flex items-center gap-2">
                @auth
                    @php $isBookmarked = Auth::user()->bookmarks()->where('event_id', $event->id)->exists(); @endphp
                    @if($isBookmarked)
                        <form action="{{ route('bookmarks.destroy', $event) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-xl font-bold text-[10px] text-indigo-600 uppercase tracking-wider hover:bg-indigo-100 transition-all">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                                Bookmarked
                            </button>
                        </form>
                    @else
                        <form action="{{ route('bookmarks.store', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-[10px] text-slate-700 uppercase tracking-wider hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                Save Event
                            </button>
                        </form>
                    @endif

                    @if(Auth::user()->role === 'admin' || Auth::id() === $event->user_id)
                        @if(Auth::id() === $event->user_id)
                            <a href="{{ route('events.attendees', $event) }}" class="inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-indigo-700 text-white rounded-xl font-bold text-[10px] uppercase tracking-wider transition-all shadow-sm">
                                Attendees ({{ $event->rsvps->where('status', 'yes')->count() }})
                            </a>
                        @endif
                        <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-[10px] text-slate-700 uppercase tracking-wider hover:bg-slate-50 transition-all shadow-sm">Edit</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event permanently?');" class="inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-50 border border-rose-100 rounded-xl font-bold text-[10px] text-rose-700 uppercase tracking-wider hover:bg-rose-100 transition-all shadow-sm">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    {{-- Alpine state for toasts --}}
    <div x-data="{
        success: {{ session('success') ? 'true' : 'false' }},
        cancelled: {{ session('cancelled') ? 'true' : 'false' }},
        showCancelDialog: false,
        init() {
            if (this.success) setTimeout(() => this.success = false, 2800);
            if (this.cancelled) setTimeout(() => this.cancelled = false, 2800);
        }
    }" class="min-h-screen bg-slate-50/70 pb-16">

        {{-- ===== BOOKING CONFIRMED TOAST ===== --}}
        <div x-show="success" x-cloak
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="fixed bottom-6 right-6 z-[200] max-w-sm w-full mx-4">
            <div class="relative bg-white border border-emerald-100 shadow-2xl shadow-emerald-900/10 rounded-2xl overflow-hidden">
                {{-- Progress bar --}}
                <div class="absolute top-0 left-0 h-1 bg-emerald-500 rounded-full" style="animation: shrink-bar 2.8s linear forwards;">
                </div>
                <div class="flex items-start gap-4 p-5">
                    <div class="shrink-0 w-11 h-11 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm shadow-emerald-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-slate-900 text-sm tracking-tight">🎉 Booking Confirmed!</p>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5 leading-relaxed">Your entry pass is ready. Check it in <strong>My Tickets</strong>.</p>
                    </div>
                    <button @click="success = false" class="shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== CANCELLATION TOAST ===== --}}
        <div x-show="cancelled" x-cloak
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="fixed bottom-6 right-6 z-[200] max-w-sm w-full mx-4">
            <div class="relative bg-white border border-rose-100 shadow-2xl shadow-rose-900/10 rounded-2xl overflow-hidden">
                <div class="absolute top-0 left-0 h-1 bg-rose-400 rounded-full" style="animation: shrink-bar 2.8s linear forwards;"></div>
                <div class="flex items-start gap-4 p-5">
                    <div class="shrink-0 w-11 h-11 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-black text-slate-900 text-sm">Registration Cancelled</p>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Your pass was removed and the spot is now available.</p>
                    </div>
                    <button @click="cancelled = false" class="shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== CANCEL CONFIRMATION MODAL ===== --}}
        @auth
            @php $userRsvp = Auth::user()->rsvps()->where('event_id', $event->id)->first(); @endphp
            @if($userRsvp)
                <div x-show="showCancelDialog" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
                     @click.self="showCancelDialog = false">
                    <div x-show="showCancelDialog"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90"
                         class="bg-white rounded-3xl p-8 shadow-2xl max-w-sm w-full border border-slate-200">
                        <div class="flex flex-col items-center text-center gap-4">
                            <div class="w-14 h-14 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-center text-rose-500">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-slate-900 font-black text-xl tracking-tight">Cancel Booking?</h4>
                                <p class="text-slate-500 text-xs font-semibold mt-2 leading-relaxed max-w-xs">This will cancel your entry pass for <strong class="text-slate-800">{{ $event->title }}</strong> and release your spot.</p>
                            </div>
                            <div class="flex gap-3 w-full mt-1">
                                <button @click="showCancelDialog = false" class="flex-1 py-3 bg-slate-50 hover:bg-slate-100 text-slate-700 rounded-xl font-bold text-xs uppercase tracking-widest transition-all border border-slate-200">Keep it</button>
                                <form action="{{ route('rsvps.destroy', $event) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-sm shadow-rose-600/20">Cancel Pass</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

            {{-- ===== HERO BANNER ===== --}}
            <div class="relative h-72 sm:h-[420px] rounded-3xl overflow-hidden mb-8 shadow-lg">
                @if($event->image)
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-600"></div>
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/30 to-transparent"></div>

                {{-- Category pill --}}
                <div class="absolute top-6 left-6">
                    <span class="px-3 py-1.5 bg-white/15 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-black text-white uppercase tracking-widest">
                        {{ $event->category?->name ?? 'General' }}
                    </span>
                </div>

                {{-- Price badge --}}
                <div class="absolute top-6 right-6">
                    <span class="px-3 py-1.5 rounded-full text-xs font-black shadow-lg {{ $event->price > 0 ? 'bg-white text-slate-900' : 'bg-emerald-500 text-white' }}">
                        {{ $event->price > 0 ? '₹'.number_format($event->price, 0) : 'FREE' }}
                    </span>
                </div>

                {{-- Hero text --}}
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10">
                    <p class="text-white/60 text-xs font-bold uppercase tracking-widest mb-2">Hosted by {{ $event->user->name }}</p>
                    <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight max-w-3xl">{{ $event->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <span class="flex items-center gap-1.5 text-white/75 text-xs font-semibold">
                            <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}
                        </span>
                        <span class="flex items-center gap-1.5 text-white/75 text-xs font-semibold">
                            <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                        </span>
                        @if($event->location)
                            <span class="flex items-center gap-1.5 text-white/75 text-xs font-semibold">
                                <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $event->location }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ===== MAIN TWO-COLUMN LAYOUT ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT: Description + Details --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- About Card --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100">
                            <h2 class="text-lg font-black text-slate-900 tracking-tight">About This Event</h2>
                        </div>
                        <div class="px-8 py-6">
                            <div class="prose prose-slate prose-sm max-w-none leading-relaxed text-slate-600 font-medium">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Event Details Card --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100">
                            <h2 class="text-lg font-black text-slate-900 tracking-tight">Event Details</h2>
                        </div>
                        <div class="px-8 py-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Date</p>
                                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Time</p>
                                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Location</p>
                                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $event->location ?? 'To Be Announced' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.11.895 2 2m-2-2v14"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Ticket Price</p>
                                        <p class="text-sm font-bold mt-0.5 {{ $event->price > 0 ? 'text-slate-900' : 'text-emerald-600' }}">
                                            {{ $event->price > 0 ? '₹' . number_format($event->price, 2) : 'Free Entry' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Capacity Bar --}}
                            @if($event->capacity)
                                @php
                                    $filled = $event->rsvps->where('status','yes')->count();
                                    $cap = $event->capacity;
                                    $pct = $cap > 0 ? min(100, round($filled / $cap * 100)) : 0;
                                @endphp
                                <div class="mt-5 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="flex justify-between items-center mb-2 text-xs">
                                        <span class="font-black text-slate-400 uppercase tracking-widest text-[9px]">Capacity</span>
                                        <span class="font-bold text-slate-800">{{ $filled }} / {{ $cap }} spots filled</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 {{ $pct >= 100 ? 'bg-rose-500' : ($pct >= 80 ? 'bg-amber-500' : 'bg-indigo-500') }}" style="width: {{ $pct }}%"></div>
                                    </div>
                                    @if($pct >= 90 && $pct < 100)
                                        <p class="text-[10px] font-bold text-amber-600 mt-1.5">⚡ Only {{ $cap - $filled }} spot{{ $cap - $filled === 1 ? '' : 's' }} left!</p>
                                    @elseif($pct >= 100)
                                        <p class="text-[10px] font-bold text-rose-600 mt-1.5">🔴 This event is fully booked.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Attendees Card --}}
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="text-lg font-black text-slate-900 tracking-tight">Who's Going</h2>
                            <span class="px-2.5 py-1 bg-indigo-50 border border-indigo-100 rounded-lg text-xs font-black text-indigo-700">{{ $event->rsvps->where('status', 'yes')->count() }} Going</span>
                        </div>
                        <div class="px-8 py-6">
                            @if($event->rsvps->where('status', 'yes')->count() > 0)
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach($event->rsvps->where('status', 'yes')->take(8) as $rsvp)
                                        <div class="inline-flex shrink-0 h-10 w-10 rounded-full bg-indigo-600 border-2 border-white items-center justify-center text-white font-black text-xs shadow-sm uppercase" title="{{ $rsvp->user->name }}">
                                            {{ substr($rsvp->user->name, 0, 1) }}
                                        </div>
                                    @endforeach
                                    @if($event->rsvps->where('status', 'yes')->count() > 8)
                                        <div class="inline-flex shrink-0 h-10 w-10 rounded-full bg-slate-100 border-2 border-white items-center justify-center text-slate-600 font-bold text-xs shadow-sm">
                                            +{{ $event->rsvps->where('status', 'yes')->count() - 8 }}
                                        </div>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-400 font-semibold mt-3">{{ $event->rsvps->where('status', 'yes')->count() }} {{ $event->rsvps->where('status', 'yes')->count() === 1 ? 'person is' : 'people are' }} attending this event.</p>
                            @else
                                <div class="flex items-center gap-3 text-sm text-slate-400 font-semibold">
                                    <div class="w-9 h-9 bg-slate-50 rounded-full border-2 border-dashed border-slate-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                    Be the first to book your spot!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Sticky Action Sidebar --}}
                <div class="space-y-5">
                    <div class="sticky top-24 space-y-5">

                        {{-- RSVP / Booking Card --}}
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">RSVP & Registration</h3>

                                @auth
                                    @php
                                        $userRsvp = Auth::user()->rsvps()->where('event_id', $event->id)->first();
                                        $yesCount = $event->rsvps->where('status', 'yes')->count();
                                        $isFull = $event->capacity && $yesCount >= $event->capacity;
                                    @endphp

                                    @if(Auth::user()->role === 'organizer')
                                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                                            <p class="text-slate-500 text-xs font-semibold">Organizers cannot book tickets for their own events.</p>
                                        </div>
                                    @else
                                        {{-- Spots warning --}}
                                        @if($event->capacity && !$isFull && $userRsvp?->status !== 'yes')
                                            <div class="flex items-center gap-2 mb-4 bg-amber-50 border border-amber-100 rounded-xl px-3 py-2">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse shrink-0"></span>
                                                <span class="text-xs text-amber-800 font-semibold">Only {{ $event->capacity - $yesCount }} spot{{ $event->capacity - $yesCount === 1 ? '' : 's' }} left!</span>
                                            </div>
                                        @elseif($isFull && $userRsvp?->status !== 'yes')
                                            <div class="flex items-center gap-2 mb-4 bg-rose-50 border border-rose-100 rounded-xl px-3 py-2">
                                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full shrink-0"></span>
                                                <span class="text-xs text-rose-800 font-semibold">This event is fully booked</span>
                                            </div>
                                        @endif

                                        {{-- Active pass badge --}}
                                        @if($userRsvp?->status === 'yes' && $event->price > 0)
                                            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 bg-emerald-500 rounded-lg flex items-center justify-center text-white shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                    <span class="text-emerald-900 font-black">Pass Active</span>
                                                </div>
                                                <span class="text-emerald-600 font-black uppercase tracking-widest text-[9px]">ID: {{ substr($userRsvp->payment_id ?? 'LECS000', 0, 8) }}</span>
                                            </div>
                                        @endif

                                        {{-- Paid event CTA --}}
                                        @if($event->price > 0 && $userRsvp?->status !== 'yes')
                                            <div class="space-y-3">
                                                <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Ticket Price</span>
                                                    <span class="text-2xl font-black text-slate-900">₹{{ number_format($event->price, 2) }}</span>
                                                </div>
                                                <a href="{{ $isFull ? '#' : route('events.checkout', $event) }}"
                                                   class="relative overflow-hidden flex items-center justify-center gap-2 w-full py-3.5 rounded-2xl font-bold text-xs uppercase tracking-widest text-center transition-all shadow-sm {{ $isFull ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/20' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                                    {{ $isFull ? 'Fully Booked' : 'Book Ticket Now' }}
                                                </a>
                                                <p class="text-[9px] text-center text-slate-400 font-bold uppercase tracking-widest flex items-center justify-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                    Secure checkout via LECS Pay
                                                </p>
                                            </div>
                                        @else
                                            {{-- Free event RSVP buttons --}}
                                            <form action="{{ route('rsvps.store', $event) }}" method="POST" class="space-y-3" x-data="{ submitting: false }" @submit="submitting = true">
                                                @csrf
                                                <button type="submit" name="status" value="yes"
                                                        {{ $isFull && $userRsvp?->status !== 'yes' ? 'disabled' : '' }}
                                                        class="relative w-full flex items-center justify-center gap-2 px-4 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all {{ $userRsvp?->status === 'yes' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/20' : ($isFull ? 'bg-slate-50 text-slate-400 border border-slate-200 cursor-not-allowed' : 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-600/20') }}">
                                                    @if($userRsvp?->status === 'yes')
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                        You're Going!
                                                    @elseif($isFull)
                                                        Fully Booked
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                                        Yes, I'm Going!
                                                    @endif
                                                </button>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <button type="submit" name="status" value="maybe"
                                                            class="flex items-center justify-center py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all {{ $userRsvp?->status === 'maybe' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
                                                        Maybe
                                                    </button>
                                                    <button type="submit" name="status" value="no"
                                                            class="flex items-center justify-center py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all {{ $userRsvp?->status === 'no' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
                                                        Can't Go
                                                    </button>
                                                </div>
                                            </form>
                                        @endif

                                        {{-- Cancel link --}}
                                        @if($userRsvp)
                                            <div class="mt-4 text-center">
                                                <button @click="showCancelDialog = true" class="text-[10px] font-black text-slate-400 hover:text-rose-600 uppercase tracking-widest transition-colors inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Cancel Registration
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center space-y-3">
                                        <p class="text-slate-500 text-xs font-semibold">Sign in to book your pass for this event.</p>
                                        <a href="{{ route('login') }}" class="block w-full py-3 bg-slate-900 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                                            Log In to Book
                                        </a>
                                        <a href="{{ route('register') }}" class="block w-full py-3 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                                            Create Account
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        {{-- Organizer Card --}}
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Organized By</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-sm">
                                    {{ strtoupper(substr($event->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $event->user->name }}</p>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Event Organizer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shrink-bar {
            from { width: 100%; }
            to   { width: 0%;   }
        }
    </style>
</x-app-layout>
