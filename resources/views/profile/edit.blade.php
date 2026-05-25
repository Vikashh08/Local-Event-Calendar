<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Profile Settings</h1>
                <p class="text-sm font-medium text-slate-500 mt-1">Manage your account information, update security settings, or close your account.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-slate-950 hover:bg-slate-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Side: Profile Info Card & Stats --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 flex flex-col items-center text-center relative overflow-hidden">
                        {{-- Decorative background gradient glow based on role --}}
                        <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b opacity-[0.04] pointer-events-none
                            @if($user->role === 'admin') from-indigo-600 to-transparent
                            @elseif($user->role === 'organizer') from-emerald-600 to-transparent
                            @else from-blue-600 to-transparent @endif">
                        </div>

                        {{-- Avatar with initials --}}
                        <div class="relative w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-black shadow-lg shrink-0 z-10
                            @if($user->role === 'admin') bg-gradient-to-br from-indigo-500 to-indigo-650 ring-4 ring-indigo-50
                            @elseif($user->role === 'organizer') bg-gradient-to-br from-emerald-500 to-emerald-650 ring-4 ring-emerald-50
                            @else bg-gradient-to-br from-blue-500 to-blue-650 ring-4 ring-blue-50 @endif">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="mt-6 z-10">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight leading-tight">{{ $user->name }}</h3>
                            <p class="text-sm font-medium text-slate-500 mt-1">{{ $user->email }}</p>
                        </div>

                        {{-- Role Badge --}}
                        <div class="mt-4 z-10">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>Admin
                                </span>
                            @elseif($user->role === 'organizer')
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Organizer
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>Attendee
                                </span>
                            @endif
                        </div>

                        <div class="w-full border-t border-slate-100 my-6"></div>

                        {{-- Statistics Grid --}}
                        <div class="w-full grid grid-cols-2 gap-4">
                            @if($user->role === 'organizer')
                                <div class="bg-indigo-50 rounded-2xl p-4 text-center border border-indigo-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-indigo-650 text-indigo-700">{{ $stats['events_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Hosted Events</p>
                                </div>
                                <div class="bg-blue-50 rounded-2xl p-4 text-center border border-blue-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-blue-650 text-blue-700">{{ $stats['attendees_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Attendees</p>
                                </div>
                                <div class="bg-emerald-50 rounded-2xl p-4 col-span-2 text-center border border-emerald-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-emerald-650 text-emerald-700">₹{{ number_format($stats['revenue'] ?? 0, 2) }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Revenue Generated</p>
                                </div>
                            @elseif($user->role === 'admin')
                                <div class="bg-indigo-50 rounded-2xl p-4 text-center border border-indigo-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-indigo-650 text-indigo-700">{{ $stats['total_events'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Total Events</p>
                                </div>
                                <div class="bg-blue-50 rounded-2xl p-4 text-center border border-blue-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-blue-650 text-blue-700">{{ $stats['total_users'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Total Users</p>
                                </div>
                            @else
                                <div class="bg-indigo-50 rounded-2xl p-4 text-center border border-indigo-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-indigo-650 text-indigo-700">{{ $stats['rsvps_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">RSVPs Made</p>
                                </div>
                                <div class="bg-blue-50 rounded-2xl p-4 text-center border border-blue-100 hover:shadow-sm transition-all">
                                    <p class="text-2xl font-black text-blue-650 text-blue-700">{{ $stats['bookmarks_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-slate-450 uppercase tracking-wider mt-1">Bookmarks</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                            Member since {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Right Side: Profile Edit Forms --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white rounded-3xl border border-rose-200 shadow-sm p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
