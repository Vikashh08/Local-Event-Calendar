<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Explore Community</p>
                <h2 class="font-black text-3xl text-gray-900 tracking-tight mt-0.5">
                    {{ __('Discover Local Events') }}
                </h2>
            </div>
            @auth
                @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition-all shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Create Event
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Filter Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Title or location..." class="block w-full pl-9 pr-3 py-2.5 rounded-xl border-gray-200 bg-gray-50/50 text-sm focus:border-gray-900 focus:ring-gray-900 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                    <div>
                        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Category</label>
                        <select name="category" id="category" class="block w-full py-2.5 px-3 rounded-xl border-gray-200 bg-gray-50/50 text-sm focus:border-gray-900 focus:ring-gray-900 focus:bg-white transition-all outline-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">Date</label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}" class="block w-full py-2.5 px-3 rounded-xl border-gray-200 bg-gray-50/50 text-sm focus:border-gray-900 focus:ring-gray-900 focus:bg-white transition-all outline-none">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex justify-center items-center py-2.5 px-4 bg-gray-900 rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-black transition-all shadow-sm h-[42px]">
                            Filter Events
                        </button>
                    </div>
                </form>
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Image --}}
                            <div class="h-52 relative overflow-hidden bg-gray-900">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950 group-hover:from-gray-700 transition-all duration-500 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                {{-- Date badge --}}
                                <div class="absolute top-4 left-4 bg-white rounded-xl px-3 py-2 text-center shadow-lg">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                    <span class="block text-xl font-black text-gray-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                </div>

                                {{-- Category badge --}}
                                <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm border border-white/10 rounded-full px-3 py-1 text-xs font-semibold text-white">
                                    {{ $event->category?->name ?? 'General' }}
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors">{{ $event->title }}</h3>
                                <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                    </span>
                                    @if($event->location)
                                    <span class="text-gray-300">•</span>
                                    <span class="flex items-center gap-1 truncate">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </span>
                                    @endif
                                </div>
                                <p class="text-gray-500 text-xs line-clamp-2">{{ $event->description }}</p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-3 mt-auto border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $event->price > 0 ? 'bg-gray-900 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-100/60' }}">
                                    {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium">
                                    {{ $event->rsvps->where('status','yes')->count() }} attending
                                </span>
                            </div>
                            <span class="text-xs font-semibold text-gray-900 group-hover:underline flex items-center gap-1">
                                View details →
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-16 bg-white rounded-3xl border border-dashed border-gray-200 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">No events found</h3>
                        <p class="text-sm text-gray-500 max-w-md">We couldn't find any events matching your selected filters or search terms.</p>
                        @if(request()->has('search') || request()->has('category') || request()->has('date'))
                            <a href="{{ route('events.index') }}" class="mt-5 px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-semibold hover:bg-black transition-all">Clear filters</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
