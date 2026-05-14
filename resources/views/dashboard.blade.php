<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight tracking-tight">
                My Dashboard
            </h2>
            <p class="text-sm text-gray-500">Welcome back, <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span></p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Bar --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Upcoming RSVPs</p>
                        <p class="text-3xl font-black text-gray-900 mt-0.5">{{ $rsvps->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Saved Events</p>
                        <p class="text-3xl font-black text-gray-900 mt-0.5">{{ $bookmarks->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-700 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Account Role</p>
                        <p class="text-xl font-black text-gray-900 capitalize mt-0.5">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div x-data="{ tab: 'rsvps' }" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Tab Nav --}}
                <div class="flex border-b border-gray-100">
                    <button @click="tab = 'rsvps'"
                        :class="tab === 'rsvps' ? 'border-b-2 border-gray-900 text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center px-8 py-5 text-sm transition-colors focus:outline-none">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                        My RSVPs
                        <span class="ml-2 bg-gray-100 text-gray-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $rsvps->count() }}</span>
                    </button>
                    <button @click="tab = 'bookmarks'"
                        :class="tab === 'bookmarks' ? 'border-b-2 border-gray-900 text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'"
                        class="flex items-center px-8 py-5 text-sm transition-colors focus:outline-none">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                        My Bookmarks
                        <span class="ml-2 bg-gray-100 text-gray-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $bookmarks->count() }}</span>
                    </button>
                </div>

                {{-- RSVPs Tab --}}
                <div x-show="tab === 'rsvps'" class="p-6 sm:p-8">
                    @if($rsvps->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">No upcoming RSVPs</h3>
                            <p class="text-gray-500 text-sm mb-6">You haven't RSVP'd to any upcoming events yet.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition shadow-sm">
                                Browse Events
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($rsvps as $rsvp)
                                @php $event = $rsvp->event; @endphp
                                <a href="{{ route('events.show', $event) }}" class="group flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                                    <div class="h-36 relative overflow-hidden">
                                        @if($event->image)
                                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-600"></div>
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        @endif
                                        {{-- RSVP Status Badge --}}
                                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold
                                            {{ $rsvp->status === 'yes' ? 'bg-emerald-500 text-white' : ($rsvp->status === 'maybe' ? 'bg-yellow-400 text-white' : 'bg-red-400 text-white') }}">
                                            {{ ucfirst($rsvp->status) }}
                                        </span>
                                        <div class="absolute bottom-0 left-0 p-3">
                                            <p class="text-white font-bold text-sm leading-tight drop-shadow">{{ $event->title }}</p>
                                        </div>
                                    </div>
                                    <div class="p-4 flex flex-col gap-1 flex-1">
                                        <div class="flex items-center text-xs text-gray-500 space-x-3">
                                            <span class="flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-400 mt-1">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $event->location ?? 'TBA' }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Bookmarks Tab --}}
                <div x-show="tab === 'bookmarks'" x-cloak class="p-6 sm:p-8">
                    @if($bookmarks->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">No saved events</h3>
                            <p class="text-gray-500 text-sm mb-6">Bookmark events you're interested in to find them here.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition shadow-sm">
                                Browse Events
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($bookmarks as $bookmark)
                                @php $event = $bookmark->event; @endphp
                                <a href="{{ route('events.show', $event) }}" class="group flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                                    <div class="h-36 relative overflow-hidden">
                                        @if($event->image)
                                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-500"></div>
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        @endif
                                        <div class="absolute top-3 right-3 bg-yellow-400 p-1.5 rounded-full shadow">
                                            <svg class="w-3.5 h-3.5 text-white fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                        </div>
                                        <div class="absolute bottom-0 left-0 p-3">
                                            <p class="text-white font-bold text-sm leading-tight drop-shadow">{{ $event->title }}</p>
                                        </div>
                                    </div>
                                    <div class="p-4 flex flex-col gap-1 flex-1">
                                        @if($event->category)
                                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ $event->category->name }}</span>
                                        @endif
                                        <div class="flex items-center text-xs text-gray-500 space-x-3">
                                            <span class="flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-400 mt-1">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $event->location ?? 'TBA' }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            {{-- Quick Links for Organizers --}}
            @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Organizer Tools</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Create New Event
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            All Events
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Admin Panel
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
