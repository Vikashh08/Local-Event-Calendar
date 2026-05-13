<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white tracking-tight">Welcome back</h2>
        <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.4);">Sign in to your LECS account to continue.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:18px;">
        @csrf

        <div>
            <label class="field-label" for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="input-field" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <label class="field-label" for="password" style="margin-bottom:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:rgba(255,255,255,0.35); font-size:0.78rem; text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Forgot?</a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                required autocomplete="current-password"
                class="input-field" placeholder="••••••••">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div style="display:flex; align-items:center; gap:8px;">
            <input id="remember_me" type="checkbox" name="remember"
                style="width:15px; height:15px; accent-color:white; cursor:pointer; border-radius:4px;">
            <label for="remember_me" style="color:rgba(255,255,255,0.4); font-size:0.83rem; cursor:pointer; margin:0;">Remember me</label>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:4px;">
            Sign in
        </button>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Don't have an account? <a href="{{ route('register') }}">Create one free</a>
    </p>

    <div style="text-align:center; margin-top:16px;">
        <a href="{{ route('admin.login') }}" style="color:rgba(255,255,255,0.25); font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; font-weight:600; text-decoration:none;" onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.25)'">
            Admin Portal →
        </a>
    </div>
</x-guest-layout>
