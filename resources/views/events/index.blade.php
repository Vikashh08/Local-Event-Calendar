<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-indigo-650">Explore Community</p>
                <h2 class="font-black text-3xl text-slate-900 tracking-tight mt-0.5">
                    {{ __('Discover Local Events') }}
                </h2>
            </div>
            @auth
                @if(Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Event
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Filter Section -->
            <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 p-6">
                <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="search" class="block text-[10px] font-black uppercase tracking-widest text-slate-450 mb-2">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search title or location..." class="block w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 bg-slate-50/50 text-xs font-semibold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none">
                        </div>
                    </div>
                    <div>
                        <label for="category" class="block text-[10px] font-black uppercase tracking-widest text-slate-450 mb-2">Category</label>
                        <select name="category" id="category" class="block w-full py-2.5 px-3.5 rounded-xl border-slate-200 bg-slate-50/50 text-xs font-semibold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-[10px] font-black uppercase tracking-widest text-slate-450 mb-2">Date</label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}" class="block w-full py-2.5 px-3.5 rounded-xl border-slate-200 bg-slate-50/50 text-xs font-semibold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex justify-center items-center py-2.5 px-4 bg-slate-900 rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-650 transition-all shadow-sm h-[40px]">
                            Filter Events
                        </button>
                    </div>
                </form>
            </div>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="group block bg-white rounded-[32px] overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Image --}}
                            <div class="h-52 relative overflow-hidden bg-slate-100">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>

                                <!-- Date badge -->
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm rounded-2xl px-3 py-2 text-center shadow-md border border-slate-200">
                                    <span class="block text-[10px] font-black text-indigo-650 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                    <span class="block text-xl font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                </div>

                                <!-- Category badge -->
                                <div class="absolute top-4 right-4 bg-black/40 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 text-[10px] font-black text-white uppercase tracking-wider">
                                    {{ $event->category?->name ?? 'General' }}
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug line-clamp-2 group-hover:text-indigo-650 transition-colors">{{ $event->title }}</h3>
                                <div class="flex items-center gap-3 text-xs text-slate-450 mb-3 font-semibold">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                    </span>
                                    @if($event->location)
                                    <span class="text-slate-300">•</span>
                                    <span class="flex items-center gap-1 truncate max-w-[150px]">
                                        <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span class="truncate">{{ $event->location }}</span>
                                    </span>
                                    @endif
                                </div>
                                <p class="text-slate-500 text-xs font-medium line-clamp-2 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        </div>
                        <div class="px-6 pb-6 pt-3 mt-auto border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider {{ $event->price > 0 ? 'bg-slate-900 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-250' }}">
                                    {{ $event->price > 0 ? '₹' . number_format($event->price, 2) : 'Free' }}
                                </span>
                                <span class="text-xs text-slate-400 font-semibold">
                                    {{ $event->rsvps->where('status','yes')->count() }} attending
                                </span>
                            </div>
                            <span class="text-xs font-bold text-indigo-655 group-hover:underline flex items-center gap-1">
                                View details →
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white border border-slate-200 rounded-[32px] text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 border border-slate-200 text-slate-400">
                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No events found</h3>
                        <p class="text-slate-500 text-xs font-medium max-w-sm mb-6">We couldn't find any events matching your selected filters or search terms.</p>
                        @if(request()->has('search') || request()->has('category') || request()->has('date'))
                            <a href="{{ route('events.index') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-indigo-650 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm">Clear filters</a>
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
