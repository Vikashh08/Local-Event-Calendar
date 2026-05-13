<x-guest-layout>
    <div class="mb-9">
        <h2 class="text-3xl font-black text-white tracking-tight">Welcome back</h2>
        <p class="mt-2 text-sm" style="color: rgba(255,255,255,0.4);">Sign in to your LECS account to continue.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email">Email address</label>
            <div class="mt-1.5">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="input-field" placeholder="you@example.com">
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center">
                <label for="password">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs hover:text-white transition-colors" style="color: rgba(255,255,255,0.4);">Forgot password?</a>
                @endif
            </div>
            <div class="mt-1.5">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="input-field" placeholder="••••••••">
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded" style="accent-color: white;">
            <label for="remember_me" class="normal-case tracking-normal text-sm" style="color: rgba(255,255,255,0.5);">Remember me for 30 days</label>
        </div>

        <div class="pt-1">
            <button type="submit" class="btn-primary">
                Sign in to account
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="link">Don't have an account?
            <a href="{{ route('register') }}" class="link-bold">Create one free</a>
        </p>
    </div>

    <hr class="divider">

    <div class="text-center">
        <a href="{{ route('admin.login') }}" class="text-xs uppercase tracking-widest font-semibold link">
            Admin Portal →
        </a>
    </div>
</x-guest-layout>
