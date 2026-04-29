<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('My Saved Events') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group relative">
                        <!-- Remove Bookmark Button -->
                        <form action="{{ route('bookmarks.destroy', $event) }}" method="POST" class="absolute top-4 right-4 z-20">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white/90 backdrop-blur-sm p-2 rounded-full text-red-500 hover:text-red-700 hover:bg-red-50 shadow-sm transition" title="Remove Bookmark">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                            </button>
                        </form>

                        <a href="{{ route('events.show', $event) }}" class="block">
                            <div class="h-48 bg-gradient-to-br from-gray-800 to-gray-800 relative overflow-hidden">
                                <div class="absolute inset-0 bg-black opacity-10 group-hover:opacity-0 transition-opacity duration-300"></div>
                                <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 to-transparent">
                                    <h3 class="text-xl font-bold text-white leading-tight drop-shadow-md">{{ $event->title }}</h3>
                                </div>
                            </div>
                        </a>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-6 line-clamp-2 h-10">{{ $event->description }}</p>
                            
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                <div class="flex items-center text-sm text-gray-500 truncate pr-4">
                                    <svg class="w-4 h-4 mr-1 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    <span class="truncate">{{ $event->location ?? 'TBA' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-3xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-1">No saved events</h3>
                        <p class="text-gray-500 text-center">You haven't bookmarked any events yet. Explore events to save them here!</p>
                        <a href="{{ route('events.index') }}" class="mt-4 text-gray-900 hover:text-black font-medium text-sm border border-gray-900 rounded-full px-4 py-2 hover:bg-gray-100 transition">Discover Events</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
