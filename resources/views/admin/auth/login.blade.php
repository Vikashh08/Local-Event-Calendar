<x-guest-layout>
    <div class="mb-9">
        <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-white mb-5 shadow-lg">
            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-black text-white tracking-tight">Admin Portal</h2>
        <p class="mt-2 text-sm" style="color: rgba(255,255,255,0.4);">Restricted access for platform administrators.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email">Admin email</label>
            <div class="mt-1.5">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="input-field" placeholder="admin@example.com">
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="password">Password</label>
            <div class="mt-1.5">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="input-field" placeholder="••••••••">
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-1">
            <button type="submit" class="btn-primary">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Verify & Sign In
                </span>
            </button>
        </div>
    </form>

    <hr class="divider">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.register') }}" class="link-bold text-sm">Register admin account →</a>
        <a href="{{ route('login') }}" class="link text-xs">← User login</a>
    </div>
</x-guest-layout>
