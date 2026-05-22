<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 tracking-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Side: Profile Info Card & Stats --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 flex flex-col items-center text-center relative overflow-hidden">
                        {{-- Decorative background gradient glow based on role --}}
                        <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b opacity-[0.03] pointer-events-none
                            @if($user->role === 'admin') from-indigo-600 to-transparent
                            @elseif($user->role === 'organizer') from-emerald-600 to-transparent
                            @else from-gray-900 to-transparent @endif">
                        </div>

                        {{-- Avatar with initials --}}
                        <div class="relative w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-black shadow-xl shrink-0 z-10
                            @if($user->role === 'admin') bg-gradient-to-br from-indigo-500 to-purple-600 ring-4 ring-indigo-50
                            @elseif($user->role === 'organizer') bg-gradient-to-br from-emerald-500 to-teal-600 ring-4 ring-emerald-50
                            @else bg-gradient-to-br from-gray-700 to-gray-900 ring-4 ring-gray-100 @endif">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="mt-6 z-10">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight leading-tight">{{ $user->name }}</h3>
                            <p class="text-sm font-medium text-gray-500 mt-1">{{ $user->email }}</p>
                        </div>

                        {{-- Role Badge --}}
                        <div class="mt-4 z-10">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>Admin
                                </span>
                            @elseif($user->role === 'organizer')
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Organizer
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-gray-50 text-gray-700 ring-1 ring-gray-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>Attendee
                                </span>
                            @endif
                        </div>

                        <div class="w-full border-t border-gray-100 my-6"></div>

                        {{-- Statistics Grid --}}
                        <div class="w-full grid grid-cols-2 gap-4">
                            @if($user->role === 'organizer')
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-emerald-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['events_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Hosted Events</p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-emerald-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['attendees_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Total Attendees</p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 col-span-2 text-center border border-gray-100 hover:border-emerald-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">₹{{ number_format($stats['revenue'] ?? 0, 2) }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Revenue Generated</p>
                                </div>
                            @elseif($user->role === 'admin')
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-indigo-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_events'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Total Events</p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-indigo-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Total Users</p>
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-gray-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['rsvps_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">RSVPs Made</p>
                                </div>
                                <div class="bg-gray-50 rounded-2xl p-4 text-center border border-gray-100 hover:border-gray-200 transition-colors">
                                    <p class="text-2xl font-black text-gray-900">{{ $stats['bookmarks_count'] ?? 0 }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Bookmarks</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                            Member since {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Right Side: Profile Edit Forms --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white rounded-3xl border border-red-100 shadow-sm p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
