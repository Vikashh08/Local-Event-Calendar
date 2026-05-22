<x-app-layout>
    <div x-data="{ activeTab: 'overview' }" class="min-h-[calc(100vh-65px)] bg-gray-50 flex flex-col md:flex-row">
        
        {{-- Left Sidebar --}}
        <aside class="w-full md:w-72 bg-gray-900 border-r border-gray-800 text-gray-300 flex-shrink-0 flex flex-col">
            <div class="p-6">
                <h2 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-6">Admin Control Center</h2>
                
                <nav class="space-y-1">
                    <button @click="activeTab = 'overview'" 
                            :class="activeTab === 'overview' ? 'bg-gray-800 text-white font-bold border-l-4 border-indigo-500' : 'hover:bg-gray-800/50 hover:text-white font-medium border-l-4 border-transparent'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-r-lg transition-colors text-sm text-left">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Platform Overview
                    </button>
                    
                    <button @click="activeTab = 'moderation'" 
                            :class="activeTab === 'moderation' ? 'bg-gray-800 text-white font-bold border-l-4 border-emerald-500' : 'hover:bg-gray-800/50 hover:text-white font-medium border-l-4 border-transparent'"
                            class="w-full flex justify-between items-center px-4 py-3 rounded-r-lg transition-colors text-sm text-left">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Moderation Queue
                        </div>
                        @if($pendingEvents->count() > 0)
                            <span class="bg-amber-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $pendingEvents->count() }}</span>
                        @endif
                    </button>

                    <button @click="activeTab = 'users'" 
                            :class="activeTab === 'users' ? 'bg-gray-800 text-white font-bold border-l-4 border-indigo-500' : 'hover:bg-gray-800/50 hover:text-white font-medium border-l-4 border-transparent'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-r-lg transition-colors text-sm text-left">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        User Directory
                    </button>

                    <button @click="activeTab = 'taxonomy'" 
                            :class="activeTab === 'taxonomy' ? 'bg-gray-800 text-white font-bold border-l-4 border-indigo-500' : 'hover:bg-gray-800/50 hover:text-white font-medium border-l-4 border-transparent'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-r-lg transition-colors text-sm text-left">
                        <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Category Taxonomy
                    </button>
                </nav>
            </div>
            
            <div class="mt-auto p-6 border-t border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">System Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
            
            {{-- Tab: Overview --}}
            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-8">Platform Overview</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-indigo-200 transition-colors">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Users</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2">{{ $stats['total_users'] }}</h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-emerald-200 transition-colors">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-16 h-16 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Live Events</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2">{{ $stats['total_events'] }}</h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-amber-200 transition-colors">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-16 h-16 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending Approvals</p>
                        <h3 class="text-4xl font-black @if($stats['pending_events'] > 0) text-amber-600 @else text-gray-900 @endif mt-2">{{ $stats['pending_events'] }}</h3>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-teal-200 transition-colors">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-16 h-16 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Bookings</p>
                        <h3 class="text-4xl font-black text-gray-900 mt-2">{{ $stats['total_rsvps'] }}</h3>
                    </div>
                </div>
            </div>

            {{-- Tab: Moderation Queue --}}
            <div x-show="activeTab === 'moderation'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Moderation Queue</h1>
                    @if($pendingEvents->count() > 0)
                        <span class="bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $pendingEvents->count() }} Pending</span>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($pendingEvents->isEmpty())
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-300 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-800">Queue Empty</h4>
                            <p class="text-sm text-gray-500 mt-1">All events have been moderated.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Event</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Organizer</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pricing</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($pendingEvents as $event)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('events.show', $event) }}" class="font-bold text-gray-900 hover:text-indigo-600 transition-colors" target="_blank">{{ $event->title }}</a>
                                            </td>
                                            <td class="px-6 py-4 font-medium text-gray-700">{{ $event->user->name }}</td>
                                            <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4">
                                                @if($event->price > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200">₹{{ number_format($event->price, 2) }}</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">Free Event</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-end items-center gap-2">
                                                    <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="px-4 py-1.5 bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider rounded-lg hover:bg-emerald-600 transition-colors shadow-sm">Approve</button>
                                                    </form>
                                                    <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="px-4 py-1.5 bg-white border border-gray-200 text-red-600 font-bold text-xs uppercase tracking-wider rounded-lg hover:bg-red-50 transition-colors shadow-sm">Reject</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab: User Directory --}}
            <div x-show="activeTab === 'users'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-8">Platform Users</h1>
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Name & Email</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">System Role</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Account Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Manage Access</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50/50 transition-colors @if($user->is_blocked) bg-red-50/20 @endif">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.users.role', $user) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="text-xs font-bold rounded-lg border-gray-200 py-1.5 pl-3 pr-8 focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Attendee</option>
                                                    <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->is_blocked)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Suspended
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if(Auth::id() !== $user->id)
                                                <form action="{{ route('admin.users.block', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if($user->is_blocked)
                                                        <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-900 uppercase tracking-widest border border-transparent hover:border-emerald-200 px-3 py-1.5 rounded-lg transition-colors">Restore Access</button>
                                                    @else
                                                        <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-900 uppercase tracking-widest border border-transparent hover:border-red-200 px-3 py-1.5 rounded-lg transition-colors">Suspend</button>
                                                    @endif
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab: Category Taxonomy --}}
            <div x-show="activeTab === 'taxonomy'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-8">Event Taxonomy</h1>
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
                    <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-end gap-6">
                        <div class="flex-1">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Create New Category</h4>
                            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex items-center gap-3">
                                @csrf
                                <input type="text" name="name" placeholder="E.g. Technology, Art, Music..." required class="flex-1 text-sm font-medium rounded-xl border-gray-200 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                                <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-black transition-colors shadow-sm">
                                    Add Category
                                </button>
                            </form>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Category Name</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Management</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="name" value="{{ $category->name }}" class="text-sm font-bold text-gray-900 bg-transparent border-transparent px-2 py-1 rounded focus:bg-white focus:border-gray-300 focus:ring-0 w-full md:w-1/2" onchange="this.form.submit()">
                                            </form>
                                            @if($category->events_count > 0)
                                                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider mt-1 ml-2">{{ $category->events_count }} events attached</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-gray-400 hover:text-red-600 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all p-2">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</x-app-layout>
