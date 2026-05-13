<x-guest-layout>
    <div style="margin-bottom:28px;">
        <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">Welcome back</h2>
        <p style="margin-top:6px; font-size:0.875rem; color:#64748b;">Sign in to your LECS account to continue.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:16px;">
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
                    <a href="{{ route('password.request') }}" style="color:#6366f1; font-size:0.78rem; font-weight:500; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Forgot password?</a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                required autocomplete="current-password"
                class="input-field" placeholder="••••••••">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div style="display:flex; align-items:center; gap:8px;">
            <input id="remember_me" type="checkbox" name="remember"
                style="width:15px; height:15px; accent-color:#4f46e5; cursor:pointer;">
            <label for="remember_me" style="color:#64748b; font-size:0.83rem; cursor:pointer; margin:0; font-weight:400;">Remember me</label>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:4px;">
            Sign in to account
        </button>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Don't have an account? <a href="{{ route('register') }}">Create one free</a>
    </p>

    <div style="text-align:center; margin-top:14px;">
        <a href="{{ route('admin.login') }}" style="color:#94a3b8; font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; font-weight:600; text-decoration:none;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
            Admin Portal →
        </a>
    </div>
</x-guest-layout>
