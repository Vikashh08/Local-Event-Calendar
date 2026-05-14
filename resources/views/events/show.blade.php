<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Events Listing
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <!-- Bookmark Form -->
                    @php
                        $isBookmarked = Auth::user()->bookmarks()->where('event_id', $event->id)->exists();
                    @endphp
                    @if($isBookmarked)
                        <form action="{{ route('bookmarks.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl font-semibold text-xs text-gray-900 uppercase tracking-wider hover:bg-gray-200 transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                Saved
                            </button>
                        </form>
                    @else
                        <form action="{{ route('bookmarks.store', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-50 transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Save Event
                            </button>
                        </form>
                    @endif

                    @if(Auth::user()->role === 'admin' || Auth::id() === $event->user_id)
                        @if(Auth::id() === $event->user_id)
                            <a href="{{ route('events.attendees', $event) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-xl font-semibold text-xs uppercase tracking-wider hover:bg-black transition-all shadow-sm">
                                Attendees ({{ $event->rsvps->where('status', 'yes')->count() }})
                            </a>
                        @endif
                        <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-50 transition-all shadow-sm">
                            Edit
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 rounded-xl font-semibold text-xs text-red-700 uppercase tracking-wider hover:bg-red-100 transition-all shadow-sm">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Event Hero -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="h-72 sm:h-96 w-full relative flex items-end overflow-hidden bg-gray-950">
                    @if($event->image)
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    @endif

                    {{-- Category pill top right --}}
                    <div class="absolute top-6 right-6 bg-black/50 backdrop-blur-md border border-white/10 px-4 py-1.5 rounded-full text-xs font-semibold text-white">
                        {{ $event->category?->name ?? 'General' }}
                    </div>

                    <div class="relative z-10 p-8 sm:p-12 w-full text-white max-w-3xl">
                        <span class="inline-block px-3 py-1 rounded-md bg-white/10 backdrop-blur-sm text-xs font-bold uppercase tracking-widest text-gray-300 mb-3 border border-white/10">
                            Published by {{ $event->user->name }}
                        </span>
                        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-2 leading-tight">{{ $event->title }}</h1>
                    </div>
                </div>

                {{-- Lower Info Section --}}
                <div class="p-8 sm:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        <!-- Left Content (Details) -->
                        <div class="lg:col-span-2 space-y-8">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">About This Event</h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed text-base sm:text-lg space-y-4">
                                    {!! nl2br(e($event->description)) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar (Info & RSVP) -->
                        <div class="space-y-6">
                            <!-- Info Card -->
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                <ul class="space-y-5 text-sm">
                                    <li class="flex items-start gap-3.5">
                                        <div class="shrink-0 w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-900 mt-0.5">
                                            <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Date</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3.5">
                                        <div class="shrink-0 w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-900 mt-0.5">
                                            <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Time</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3.5">
                                        <div class="shrink-0 w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-900 mt-0.5">
                                            <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Location</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ $event->location ?? 'To Be Announced' }}</p>
                                        </div>
                                    </li>
                                    @if($event->capacity)
                                    <li class="pt-3 border-t border-gray-200/60">
                                        @php
                                            $filled = $event->rsvps->where('status','yes')->count();
                                            $cap = $event->capacity;
                                            $pct = $cap > 0 ? min(100, round($filled / $cap * 100)) : 0;
                                        @endphp
                                        <div class="flex justify-between items-center mb-1.5 text-xs">
                                            <span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Capacity</span>
                                            <span class="font-semibold text-gray-900">{{ $filled }} / {{ $cap }} filled</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-yellow-500' : 'bg-gray-900') }}" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- RSVP Card -->
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                                <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">RSVP Status</h4>
                                @auth
                                    @php
                                        $userRsvp = Auth::user()->rsvps()->where('event_id', $event->id)->first();
                                        $yesCount = $event->rsvps->where('status', 'yes')->count();
                                        $isFull = $event->capacity && $yesCount >= $event->capacity;
                                    @endphp
                                    
                                    @if($event->capacity && !$isFull && $userRsvp?->status !== 'yes')
                                        <div class="flex items-center gap-2 mb-4 bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-2.5 text-xs text-emerald-800 font-medium">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse shrink-0"></span>
                                            <span>Only {{ $event->capacity - $yesCount }} spot{{ $event->capacity - $yesCount === 1 ? '' : 's' }} left!</span>
                                        </div>
                                    @elseif($isFull && $userRsvp?->status !== 'yes')
                                        <div class="flex items-center gap-2 mb-4 bg-red-50 border border-red-100 rounded-xl px-3 py-2.5 text-xs text-red-800 font-medium">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full shrink-0"></span>
                                            <span>Fully booked</span>
                                        </div>
                                    @endif

                                    <form action="{{ route('rsvps.store', $event) }}" method="POST" class="space-y-2.5">
                                        @csrf
                                        <button type="submit" name="status" value="yes" {{ $isFull && $userRsvp?->status !== 'yes' ? 'disabled' : '' }}
                                                class="w-full relative flex items-center justify-center px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $userRsvp?->status === 'yes' ? 'bg-gray-900 text-white shadow-md' : ($isFull ? 'bg-gray-50 text-gray-400 border border-gray-200 cursor-not-allowed' : 'bg-white text-gray-800 border border-gray-200 hover:bg-gray-50') }}">
                                            @if($userRsvp?->status === 'yes') <span class="absolute left-3 w-2 h-2 bg-emerald-400 rounded-full"></span> @endif
                                            Yes, I'm going
                                        </button>
                                        <div class="grid grid-cols-2 gap-2.5">
                                            <button type="submit" name="status" value="maybe"
                                                    class="relative flex items-center justify-center px-3 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $userRsvp?->status === 'maybe' ? 'bg-yellow-500 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }}">
                                                @if($userRsvp?->status === 'maybe') <span class="absolute left-2 w-1.5 h-1.5 bg-white rounded-full"></span> @endif
                                                Maybe
                                            </button>
                                            <button type="submit" name="status" value="no"
                                                    class="relative flex items-center justify-center px-3 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $userRsvp?->status === 'no' ? 'bg-red-500 text-white shadow-sm' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }}">
                                                @if($userRsvp?->status === 'no') <span class="absolute left-2 w-1.5 h-1.5 bg-white rounded-full"></span> @endif
                                                Can't go
                                            </button>
                                        </div>
                                    </form>
                                    @if($userRsvp)
                                        <form action="{{ route('rsvps.destroy', $event) }}" method="POST" class="mt-3 text-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-gray-400 hover:text-gray-600 underline">Clear RSVP</button>
                                        </form>
                                    @endif
                                @else
                                    <p class="text-gray-500 text-xs mb-3">Log in to confirm your spot for this event.</p>
                                    <a href="{{ route('login') }}" class="block w-full text-center py-2.5 bg-gray-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-black transition-all">Sign in to RSVP</a>
                                @endauth
                            </div>
                            
                            <!-- Attendees Snippet -->
                            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400">Attendees</h4>
                                    <span class="text-xs font-bold text-gray-900">{{ $event->rsvps->where('status', 'yes')->count() }} Going</span>
                                </div>
                                @if($event->rsvps->where('status', 'yes')->count() > 0)
                                    <div class="flex -space-x-2 overflow-hidden py-1">
                                        @foreach($event->rsvps->where('status', 'yes')->take(6) as $rsvp)
                                            <div class="inline-flex shrink-0 h-9 w-9 rounded-full bg-gray-900 ring-2 ring-white items-center justify-center text-white font-bold text-xs" title="{{ $rsvp->user->name }}">
                                                {{ strtoupper(substr($rsvp->user->name, 0, 1)) }}
                                            </div>
                                        @endforeach
                                        @if($event->rsvps->where('status', 'yes')->count() > 6)
                                            <div class="inline-flex shrink-0 h-9 w-9 rounded-full bg-gray-100 ring-2 ring-white items-center justify-center text-gray-600 font-bold text-[11px]">
                                                +{{ $event->rsvps->where('status', 'yes')->count() - 6 }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic">No attendees confirmed yet.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
