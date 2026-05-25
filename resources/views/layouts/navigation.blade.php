<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm shadow-slate-900/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="flex items-center gap-2.5 group shrink-0">
                <div class="w-8 h-8 bg-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-700 transition-colors shadow-sm shadow-indigo-600/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-black text-xl text-slate-900 tracking-tight">LECS.</span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden sm:flex items-center gap-1">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Dashboard
                    </a>
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('events.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('events.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Events
                        </a>
                    @endif
                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('bookmarks.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Bookmarks
                        </a>
                        <a href="{{ route('tickets.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('tickets.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            My Tickets
                        </a>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Right: User Dropdown / Guest Links --}}
            <div class="hidden sm:flex items-center gap-3">
                @auth
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-all duration-150">
                                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[100px] truncate">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-100 mb-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Signed in as</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1.5 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border {{ Auth::user()->role === 'organizer' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : (Auth::user()->role === 'admin' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-emerald-50 text-emerald-600 border-emerald-200') }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ __('Profile') }}
                                </div>
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="flex items-center gap-2 text-rose-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        {{ __('Log Out') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 transition-all shadow-sm">
                        Get Started
                    </a>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                @if(Auth::user()->role !== 'admin')
                    <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('events.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">Events</a>
                @endif
                @if(Auth::user()->role === 'user')
                    <a href="{{ route('bookmarks.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">Bookmarks</a>
                    <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('tickets.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">My Tickets</a>
                @endif
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">Admin Panel</a>
                @endif
            @endauth
        </div>
        @auth
            <div class="px-4 py-4 border-t border-slate-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-all">Log Out</button>
                    </form>
                </div>
            </div>
        @else
            <div class="px-4 py-3 border-t border-slate-100 flex gap-3">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-all">Log in</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 bg-slate-900 rounded-xl text-sm font-bold text-white hover:bg-indigo-600 transition-all">Register</a>
            </div>
        @endauth
    </div>
</nav>
