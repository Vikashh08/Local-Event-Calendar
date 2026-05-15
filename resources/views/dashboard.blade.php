<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Overview</p>
                <h2 class="font-black text-3xl text-gray-900 tracking-tight mt-0.5">
                    My Dashboard
                </h2>
            </div>
            <p class="text-sm text-gray-500">Welcome back, <span class="font-bold text-gray-900">{{ Auth::user()->name }}</span></p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Bar --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Upcoming RSVPs</p>
                        <p class="text-3xl font-black text-gray-900 mt-0.5">{{ $rsvps->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-900 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Saved Events</p>
                        <p class="text-3xl font-black text-gray-900 mt-0.5">{{ $bookmarks->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md p-6 flex items-center space-x-4 transition-all duration-200 group">
                    <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-200 text-gray-800 font-extrabold text-sm uppercase tracking-wider">
                        {{ substr(Auth::user()->role, 0, 3) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Account Role</p>
                        <p class="text-lg font-black text-gray-900 capitalize mt-0.5">{{ Auth::user()->role }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div x-data="{ tab: 'rsvps' }" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Tab Nav --}}
                <div class="flex border-b border-gray-100">
                    <button @click="tab = 'rsvps'"
                        :class="tab === 'rsvps' ? 'border-b-2 border-gray-900 text-gray-900 font-black' : 'text-gray-400 hover:text-gray-700 font-semibold'"
                        class="flex items-center px-8 py-5 text-sm transition-colors focus:outline-none tracking-tight">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                        My RSVPs
                        <span class="ml-2 bg-gray-100 text-gray-900 text-xs font-bold px-2 py-0.5 rounded-full">{{ $rsvps->count() }}</span>
                    </button>
                    <button @click="tab = 'bookmarks'"
                        :class="tab === 'bookmarks' ? 'border-b-2 border-gray-900 text-gray-900 font-black' : 'text-gray-400 hover:text-gray-700 font-semibold'"
                        class="flex items-center px-8 py-5 text-sm transition-colors focus:outline-none tracking-tight">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        My Bookmarks
                        <span class="ml-2 bg-gray-100 text-gray-900 text-xs font-bold px-2 py-0.5 rounded-full">{{ $bookmarks->count() }}</span>
                    </button>
                </div>

                {{-- RSVPs Tab --}}
                <div x-show="tab === 'rsvps'" class="p-6 sm:p-8">
                    @if($rsvps->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">No upcoming RSVPs</h3>
                            <p class="text-gray-500 text-sm mb-6 max-w-sm">You haven't confirmed your attendance for any upcoming events yet.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-black transition-all shadow-sm">
                                Browse Events
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($rsvps as $rsvp)
                                @php $event = $rsvp->event; @endphp
                                <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                                    <div>
                                        {{-- Image --}}
                                        <div class="h-44 relative overflow-hidden bg-gray-900">
                                            @if($event->image)
                                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950 group-hover:from-gray-700 transition-all duration-500 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                            {{-- Date badge --}}
                                            <div class="absolute top-3 left-3 bg-white rounded-xl px-2.5 py-1.5 text-center shadow-lg">
                                                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                                <span class="block text-lg font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                            </div>

                                            {{-- RSVP Status Badge --}}
                                            <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold border border-white/10 shadow-sm backdrop-blur-sm
                                                {{ $rsvp->status === 'yes' ? 'bg-emerald-500/90 text-white' : ($rsvp->status === 'maybe' ? 'bg-yellow-500/90 text-white' : 'bg-red-500/90 text-white') }}">
                                                {{ ucfirst($rsvp->status) }}
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="p-4">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-1 group-hover:text-gray-700 transition-colors">{{ $event->title }}</h3>
                                                @if($rsvp->payment_status === 'paid')
                                                    <span class="flex items-center gap-1 text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100/50">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        Paid
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 text-[11px] text-gray-400 mb-2 pr-2">
                                                <span class="flex items-center gap-1 shrink-0">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                                </span>
                                                @if($event->location)
                                                <span class="text-gray-300">•</span>
                                                <span class="flex items-center gap-1 truncate pr-2">
                                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                    <span class="truncate">{{ $event->location }}</span>
                                                </span>
                                                @endif
                                            </div>
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
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">No saved events</h3>
                            <p class="text-gray-500 text-sm mb-6 max-w-sm">Bookmark local events you're interested in to quickly keep track of them here.</p>
                            <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-black transition-all shadow-sm">
                                Browse Events
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($bookmarks as $bookmark)
                                @php $event = $bookmark->event; @endphp
                                <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                                    <div>
                                        {{-- Image --}}
                                        <div class="h-44 relative overflow-hidden bg-gray-900">
                                            @if($event->image)
                                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950 group-hover:from-gray-700 transition-all duration-500 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                            {{-- Date badge --}}
                                            <div class="absolute top-3 left-3 bg-white rounded-xl px-2.5 py-1.5 text-center shadow-lg">
                                                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                                <span class="block text-lg font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                            </div>

                                            {{-- Saved Ribbon --}}
                                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full border border-gray-100 shadow-sm flex items-center gap-1 text-gray-900 text-[11px] font-bold">
                                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                                Saved
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="p-4">
                                            <h3 class="text-sm font-bold text-gray-900 mb-1.5 leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors">{{ $event->title }}</h3>
                                            <div class="flex items-center gap-2 text-[11px] text-gray-400 mb-2 pr-2">
                                                <span class="flex items-center gap-1 shrink-0">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                                </span>
                                                @if($event->location)
                                                <span class="text-gray-300">•</span>
                                                <span class="flex items-center gap-1 truncate pr-2">
                                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                    <span class="truncate">{{ $event->location }}</span>
                                                </span>
                                                @endif
                                            </div>
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
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 tracking-tight">Organizer Control Center</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Publish new events or manage approvals effortlessly.</p>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-black transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Create Event
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-100 transition-all">
                            All Events
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-gray-100 transition-all">
                                Admin Panel
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
