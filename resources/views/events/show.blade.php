<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <a href="{{ route('events.index') }}" class="text-gray-900 hover:text-black mr-2 flex items-center inline-flex">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </h2>
            <div class="flex space-x-3">
                @auth
                    <!-- Bookmark Form -->
                    @php
                        $isBookmarked = Auth::user()->bookmarks()->where('event_id', $event->id)->exists();
                    @endphp
                    @if($isBookmarked)
                        <form action="{{ route('bookmarks.destroy', $event) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-100 border border-yellow-300 rounded-lg font-semibold text-xs text-yellow-800 uppercase tracking-widest hover:bg-yellow-200 active:bg-yellow-300 focus:outline-none focus:border-yellow-400 focus:ring ring-yellow-200 disabled:opacity-25 transition shadow-sm">
                                <svg class="w-4 h-4 mr-1.5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                Saved
                            </button>
                        </form>
                    @else
                        <form action="{{ route('bookmarks.store', $event) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Save
                            </button>
                        </form>
                    @endif

                    @if(Auth::user()->role === 'admin' || Auth::id() === $event->user_id)
                        <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                            Edit
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow-sm">
                                Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Event Hero -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 mb-8">
                <div class="h-64 sm:h-80 md:h-96 w-full bg-gradient-to-r from-gray-900 via-gray-800 to-gray-600 relative flex items-end">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 p-8 sm:p-12 w-full text-white">
                        <div class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-sm font-semibold mb-4 border border-white/30">
                            {{ $event->category?->name ?? 'General Category' }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-2 drop-shadow-lg">{{ $event->title }}</h1>
                        <p class="text-lg text-gray-200 font-medium">Organized by {{ $event->user->name }}</p>
                    </div>
                </div>
                <div class="p-8 sm:p-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        <!-- Left Content (Details) -->
                        <div class="lg:col-span-2 space-y-8">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    About This Event
                                </h3>
                                <div class="prose max-w-none text-gray-600 leading-relaxed text-lg">
                                    {!! nl2br(e($event->description)) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar (Info & RSVP) -->
                        <div class="space-y-6">
                            <!-- Info Card -->
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                <ul class="space-y-6">
                                    <li class="flex">
                                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center border border-gray-100 text-gray-900">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Date</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                                        </div>
                                    </li>
                                    <li class="flex">
                                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center border border-gray-100 text-gray-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Time</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                                        </div>
                                    </li>
                                    <li class="flex">
                                        <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center border border-gray-100 text-gray-700">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Location</p>
                                            <p class="text-gray-900 font-semibold mt-0.5">{{ $event->location ?? 'To Be Announced' }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- RSVP Card -->
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-50 opacity-50"></div>
                                <div class="p-6 relative z-10">
                                    <h4 class="text-xl font-bold text-gray-900 mb-2">Are you going?</h4>
                                    @auth
                                        @php
                                            $userRsvp = Auth::user()->rsvps()->where('event_id', $event->id)->first();
                                        @endphp
                                        
                                        <form action="{{ route('rsvps.store', $event) }}" method="POST" class="space-y-3 mt-4">
                                            @csrf
                                            <button type="submit" name="status" value="yes" class="w-full relative flex items-center justify-center px-4 py-3 {{ $userRsvp?->status === 'yes' ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 border' }} rounded-xl font-semibold transition-all">
                                                @if($userRsvp?->status === 'yes') <svg class="w-5 h-5 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                                Yes, I'm going
                                            </button>
                                            <button type="submit" name="status" value="maybe" class="w-full relative flex items-center justify-center px-4 py-3 {{ $userRsvp?->status === 'maybe' ? 'bg-yellow-500 text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 border' }} rounded-xl font-semibold transition-all">
                                                @if($userRsvp?->status === 'maybe') <svg class="w-5 h-5 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                                Maybe
                                            </button>
                                            <button type="submit" name="status" value="no" class="w-full relative flex items-center justify-center px-4 py-3 {{ $userRsvp?->status === 'no' ? 'bg-red-500 text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 border' }} rounded-xl font-semibold transition-all">
                                                @if($userRsvp?->status === 'no') <svg class="w-5 h-5 absolute left-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> @endif
                                                No, I can't
                                            </button>
                                        </form>
                                        @if($userRsvp)
                                            <form action="{{ route('rsvps.destroy', $event) }}" method="POST" class="mt-4 text-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">Remove RSVP</button>
                                            </form>
                                        @endif
                                    @else
                                        <p class="text-gray-600 text-sm mb-4">Please log in to RSVP for this event.</p>
                                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 bg-gray-900 text-white rounded-xl font-semibold hover:bg-black shadow-sm transition">Log in to RSVP</a>
                                    @endauth
                                </div>
                            </div>
                            
                            <!-- Attendees Snippet -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                                <h4 class="font-bold text-gray-900 mb-4 flex justify-between items-center">
                                    <span>Attendees</span>
                                    <span class="bg-gray-200 text-black text-xs py-1 px-2.5 rounded-full">{{ $event->rsvps->where('status', 'yes')->count() }} Going</span>
                                </h4>
                                @if($event->rsvps->where('status', 'yes')->count() > 0)
                                    <div class="flex -space-x-3 overflow-hidden">
                                        @foreach($event->rsvps->where('status', 'yes')->take(5) as $rsvp)
                                            <div class="inline-block h-10 w-10 rounded-full bg-gradient-to-tr from-gray-800 to-gray-700 ring-2 ring-white flex items-center justify-center text-white font-bold text-sm" title="{{ $rsvp->user->name }}">
                                                {{ substr($rsvp->user->name, 0, 1) }}
                                            </div>
                                        @endforeach
                                        @if($event->rsvps->where('status', 'yes')->count() > 5)
                                            <div class="inline-block h-10 w-10 rounded-full bg-gray-100 ring-2 ring-white flex items-center justify-center text-gray-600 font-bold text-xs">
                                                +{{ $event->rsvps->where('status', 'yes')->count() - 5 }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">Be the first to RSVP!</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
