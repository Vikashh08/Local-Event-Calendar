<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">Your Bookmarks</p>
                <h2 class="font-black text-3xl text-slate-900 tracking-tight mt-0.5">
                    {{ __('My Saved Events') }}
                </h2>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl px-4 py-2.5 flex items-center gap-2.5 shadow-sm">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                <span class="text-xs font-bold text-slate-700">{{ $events->count() }} Saved Bookmarks</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="bg-white border border-slate-200/80 rounded-[32px] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative">
                        <!-- Remove Bookmark Button -->
                        <form action="{{ route('bookmarks.destroy', $event) }}" method="POST" class="absolute top-4 right-4 z-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white/95 backdrop-blur-sm p-2 rounded-full text-rose-500 hover:text-white hover:bg-rose-500 shadow-sm border border-slate-200 hover:border-transparent transition" title="Remove Bookmark">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                            </button>
                        </form>

                        <div>
                            <div class="h-44 relative bg-slate-100 overflow-hidden">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>

                                <!-- Date badge -->
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm rounded-2xl px-3 py-2 text-center shadow-md border border-slate-200">
                                    <span class="block text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                    <span class="block text-xl font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                </div>

                                <!-- Category Badge -->
                                <div class="absolute top-4 right-14 bg-black/40 backdrop-blur-sm border border-white/20 rounded-full px-3 py-1 text-[10px] font-black text-white uppercase tracking-wider">
                                    {{ $event->category?->name ?? 'General' }}
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-1 mb-2 hover:text-indigo-650 transition-colors">
                                    <a href="{{ route('events.show', $event) }}" target="_blank">{{ $event->title }}</a>
                                </h3>

                                <div class="space-y-1.5 text-xs text-slate-500 font-semibold mb-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                    </div>
                                    @if($event->location)
                                        <div class="flex items-center gap-2 truncate">
                                            <svg class="w-3.5 h-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            <span class="truncate">{{ $event->location }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 pb-6 pt-0 border-t border-slate-100">
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('events.show', $event) }}" class="block w-full text-center py-2.5 bg-slate-900 hover:bg-blue-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm hover:shadow">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white border border-slate-200 rounded-3xl text-center shadow-sm">
                        <div class="w-16 h-16 bg-blue-50/50 rounded-2xl flex items-center justify-center mb-4 text-blue-600 border border-blue-100">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No Bookmarks Saved</h3>
                        <p class="text-slate-500 text-xs mb-6 max-w-sm">Bookmark local events you're interested in to track them here!</p>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">Discover Events</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
