<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admin Console</h1>
                <p class="text-sm font-medium text-slate-500 mt-1">Manage events, user roles, moderation queue, and taxonomy settings.</p>
            </div>
            <!-- System Status Badge -->
            <div class="mt-4 md:mt-0 flex items-center gap-3 bg-white border border-slate-200 px-4 py-2 rounded-xl shadow-sm self-start">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">System Live</span>
            </div>
        </div>
    </x-slot>

    <div x-data="{ activeTab: 'overview' }" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Navigation Tabs -->
        <div class="flex overflow-x-auto space-x-8 border-b border-slate-200 pb-px mb-8 scrollbar-none">
            <button @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'border-indigo-600 text-indigo-600 font-bold border-b-2' : 'border-transparent text-slate-500 hover:text-slate-750 hover:border-slate-350'" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium transition-all cursor-pointer">
                Overview
            </button>
            <button @click="activeTab = 'events'" 
                    :class="activeTab === 'events' ? 'border-indigo-600 text-indigo-600 font-bold border-b-2' : 'border-transparent text-slate-500 hover:text-slate-750 hover:border-slate-350'" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium transition-all cursor-pointer flex items-center gap-1.5">
                Events Manager
            </button>
            <button @click="activeTab = 'moderation'" 
                    :class="activeTab === 'moderation' ? 'border-indigo-600 text-indigo-600 font-bold border-b-2' : 'border-transparent text-slate-500 hover:text-slate-750 hover:border-slate-350'" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium transition-all cursor-pointer flex items-center gap-1.5">
                Moderation Queue
                @if($pendingEvents->count() > 0)
                    <span class="bg-rose-500 text-white text-[11px] px-2 py-0.5 rounded-full font-black animate-pulse shadow-sm">{{ $pendingEvents->count() }}</span>
                @endif
            </button>
            <button @click="activeTab = 'users'" 
                    :class="activeTab === 'users' ? 'border-indigo-600 text-indigo-600 font-bold border-b-2' : 'border-transparent text-slate-500 hover:text-slate-750 hover:border-slate-350'" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium transition-all cursor-pointer">
                User Directory
            </button>
            <button @click="activeTab = 'taxonomy'" 
                    :class="activeTab === 'taxonomy' ? 'border-indigo-600 text-indigo-600 font-bold border-b-2' : 'border-transparent text-slate-500 hover:text-slate-750 hover:border-slate-350'" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium transition-all cursor-pointer">
                Categories
            </button>
        </div>

        <!-- Alert Banner -->
        @if(session('success') || session('error'))
            <div class="mb-8">
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-2xl shadow-sm text-sm font-semibold">
                        <svg class="w-5 h-5 text-emerald-650 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-2xl shadow-sm text-sm font-semibold">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Tab View: Overview -->
        <div x-show="activeTab === 'overview'" class="space-y-10" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
            <!-- Metric Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Metric: Total Users -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="w-12 h-12 bg-blue-50 border border-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stats['total_users'] }}</h3>
                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest mt-2">Total Users</p>
                </div>

                <!-- Metric: Live Events -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="w-12 h-12 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stats['total_events'] }}</h3>
                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest mt-2">Live Events</p>
                </div>

                <!-- Metric: Pending Approvals -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="w-12 h-12 bg-amber-50 border border-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stats['pending_events'] }}</h3>
                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest mt-2">Pending Approvals</p>
                </div>

                <!-- Metric: Total Bookings -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                    <div class="w-12 h-12 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 transition-transform group-hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stats['total_rsvps'] }}</h3>
                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-widest mt-2">Total Bookings</p>
                </div>
            </div>

            <!-- Overview Bottom Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Category Distribution -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm col-span-1">
                    <h3 class="font-bold text-slate-800 mb-6 text-sm uppercase tracking-wider">Category Distribution</h3>
                    <div class="space-y-4">
                        @foreach($categories as $category)
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-600">{{ $category->name }}</span>
                            <div class="flex items-center gap-3 flex-1 justify-end ml-4">
                                <div class="w-24 bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-indigo-650 h-full bg-indigo-600" style="width: {{ $stats['total_events'] > 0 ? ($category->events_count / $stats['total_events']) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-900 w-6 text-right">{{ $category->events_count }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Column: Activity Status -->
                <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm lg:col-span-2 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">System Health & Diagnostics</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-150">
                            <p class="text-[10px] text-slate-450 font-bold uppercase tracking-wider">Laravel Engine</p>
                            <p class="text-sm font-bold text-slate-800 mt-1">v{{ App::VERSION() }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-150">
                            <p class="text-[10px] text-slate-450 font-bold uppercase tracking-wider">Database Status</p>
                            <p class="text-sm font-bold text-slate-800 mt-1 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Connected
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-150">
                            <p class="text-[10px] text-slate-450 font-bold uppercase tracking-wider">Active Categories</p>
                            <p class="text-sm font-bold text-slate-800 mt-1">{{ $categories->count() }} Seeded</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-150">
                            <p class="text-[10px] text-slate-450 font-bold uppercase tracking-wider">Mail Server</p>
                            <p class="text-sm font-bold text-slate-800 mt-1">{{ config('mail.default') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab View: Events Manager -->
        <div x-show="activeTab === 'events'" x-cloak class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-data="{ eventQuery: '' }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Events Manager</h2>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Search and oversee all approved, pending, and rejected events on the platform.</p>
                </div>
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-450">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input x-model="eventQuery" type="text" placeholder="Search events by keyword..." class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm pl-10 pr-4 py-2.5 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none font-semibold">
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Title</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Category</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Organizer</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Date</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Price</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Bookings</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allEvents as $event)
                            <tr x-show="eventQuery === '' || $el.innerText.toLowerCase().includes(eventQuery.toLowerCase())" class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    <a href="{{ route('events.show', $event) }}" target="_blank" class="hover:underline">{{ $event->title }}</a>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-500">
                                    {{ $event->category?->name ?? 'None' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded bg-slate-100 text-slate-700 flex items-center justify-center text-[10px] font-black border border-slate-200">
                                            {{ strtoupper(substr($event->user?->name ?? 'U', 0, 1)) }}
                                        </div>
                                        {{ $event->user?->name ?? 'System' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-500">
                                    {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-800">
                                    @if($event->price > 0)
                                        <span class="inline-flex px-2 py-0.5 rounded bg-slate-50 text-slate-700 font-bold border border-slate-200">₹{{ number_format($event->price, 2) }}</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">Free</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs font-black text-slate-900">
                                    {{ $event->rsvps_count }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($event->status === 'approved')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-250 uppercase tracking-widest">
                                            Approved
                                        </span>
                                    @elseif($event->status === 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-amber-50 text-amber-700 border border-amber-250 uppercase tracking-widest animate-pulse">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-slate-50 text-slate-500 border border-slate-200 uppercase tracking-widest">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($event->status === 'approved' || $event->status === 'pending')
                                        <form action="{{ route('admin.events.status', $event) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 border border-slate-200 hover:bg-slate-50 rounded-lg transition-all shadow-sm">Reject</button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.events.status', $event) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white bg-slate-950 hover:bg-slate-900 border border-transparent rounded-lg transition-all shadow-sm">Approve</button>
                                        </form>
                                        @endif

                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-rose-600 hover:text-rose-700 border border-rose-200 hover:bg-rose-50 rounded-lg transition-all shadow-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-16 text-slate-500 font-semibold">
                                    No events found in the database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab View: Moderation Queue -->
        <div x-show="activeTab === 'moderation'" x-cloak class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Moderation Queue</h2>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Review and authorize pending organizer submissions.</p>
                </div>
                @if($pendingEvents->count() > 0)
                    <span class="bg-amber-50 border border-amber-200 text-amber-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">{{ $pendingEvents->count() }} Action Required</span>
                @endif
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                @if($pendingEvents->isEmpty())
                    <div class="py-24 text-center px-4">
                        <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-650 mb-6 shadow-sm">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 tracking-tight">All Caught Up!</h4>
                        <p class="text-xs font-medium text-slate-550 mt-1">The moderation queue is completely empty. Great work!</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Event Details</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Organizer</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Date</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Pricing</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingEvents as $event)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-5">
                                            <a href="{{ route('events.show', $event) }}" class="font-bold text-slate-900 hover:underline text-base" target="_blank">{{ $event->title }}</a>
                                        </td>
                                        <td class="px-6 py-5 font-semibold text-slate-700">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-7 h-7 rounded bg-slate-100 text-slate-700 flex items-center justify-center text-[10px] font-black border border-slate-200">
                                                    {{ strtoupper(substr($event->user?->name ?? 'U', 0, 1)) }}
                                                </div>
                                                {{ $event->user?->name ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 font-semibold text-slate-500 text-xs">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-5">
                                            @if($event->price > 0)
                                                <span class="inline-flex px-2 py-0.5 rounded bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold">₹{{ number_format($event->price, 2) }}</span>
                                            @else
                                                <span class="inline-flex px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-xs border border-emerald-200">Free Event</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex justify-end items-center gap-2.5">
                                                <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="px-4 py-2 bg-slate-950 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-colors shadow-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="px-4 py-2 bg-slate-50 border border-slate-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 font-bold text-xs uppercase tracking-wider rounded-xl transition-colors shadow-sm">Reject</button>
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

        <!-- Tab View: User Directory -->
        <div x-show="activeTab === 'users'" x-cloak class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-data="{ userQuery: '' }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">User Directory</h2>
                    <p class="text-xs font-semibold text-slate-500 mt-0.5">Manage permissions, suspend/restore users, and overview platform roles.</p>
                </div>
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-450">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input x-model="userQuery" type="text" placeholder="Search users by name/email..." class="w-full text-xs rounded-xl border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm pl-10 pr-4 py-2.5 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none font-semibold">
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Name & Email</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">System Role</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Account Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest text-right">Manage Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr x-show="userQuery === '' || $el.innerText.toLowerCase().includes(userQuery.toLowerCase())" class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors @if($user->is_blocked) opacity-70 bg-slate-50/30 @endif">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-slate-900 text-base leading-snug">{{ $user->name }}</p>
                                        <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="text-xs font-bold rounded-xl border-slate-200 bg-white text-slate-800 shadow-sm py-1.5 pl-3 pr-8 focus:border-slate-400 focus:ring-1 focus:ring-slate-400" onchange="this.form.submit()">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Attendee</option>
                                                <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_blocked)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[9px] font-black bg-rose-50 border border-rose-250 text-rose-700 uppercase tracking-widest">
                                                Suspended
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-250 uppercase tracking-widest">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(Auth::id() !== $user->id)
                                            <form action="{{ route('admin.users.block', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                @if($user->is_blocked)
                                                    <button type="submit" class="text-xs font-bold text-slate-700 hover:text-slate-900 uppercase tracking-wider border border-slate-200 hover:bg-slate-50 px-3.5 py-1.5 rounded-xl transition-all shadow-sm">Restore</button>
                                                @else
                                                    <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 uppercase tracking-wider border border-rose-200 hover:bg-rose-50 px-3.5 py-1.5 rounded-xl transition-all shadow-sm">Suspend</button>
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

        <!-- Tab View: Category Taxonomy -->
        <div x-show="activeTab === 'taxonomy'" x-cloak class="space-y-6" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Categories & Tags</h2>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Manage taxonomy terms and associate them with live platform events.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Create Category Widget -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Create New Category</h3>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5" for="category_name">Category Name</label>
                            <input type="text" id="category_name" name="name" placeholder="e.g., Technology, Wellness..." required class="w-full text-xs font-bold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800">
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-slate-950 hover:bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl transition-all shadow-sm">
                            Create Category
                        </button>
                    </form>
                    @error('name')
                        <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categories Table Listing -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden lg:col-span-2">
                    <div class="max-h-[600px] overflow-y-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Category Name (Double Click text to Edit / press enter)</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-3">
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="name" value="{{ $category->name }}" class="text-base font-bold text-slate-900 bg-transparent border-transparent px-3 py-1.5 rounded-xl focus:bg-slate-50 focus:border-slate-200 focus:ring-1 focus:ring-slate-400 w-full md:w-3/4 transition-all" onchange="this.form.submit()">
                                            </form>
                                            @if($category->events_count > 0)
                                                <div class="flex items-center gap-1.5 mt-1 ml-3 text-[10px] font-bold text-slate-450 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded bg-slate-400"></span>
                                                    {{ $category->events_count }} events attached
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[10px] font-black text-rose-600 hover:text-white uppercase tracking-wider border border-transparent hover:bg-rose-600 transition-all px-3.5 py-1.5 rounded-xl opacity-0 group-hover:opacity-100">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
