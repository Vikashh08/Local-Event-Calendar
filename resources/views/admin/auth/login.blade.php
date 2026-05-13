<x-guest-layout>
    <div style="margin-bottom:28px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:white; border-radius:12px; margin-bottom:16px; box-shadow:0 4px 16px rgba(0,0,0,0.3);">
            <svg style="width:20px;height:20px;color:#0a0a0a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Admin Portal</h2>
        <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.4);">Restricted access for platform administrators.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" style="display:flex; flex-direction:column; gap:18px;">
        @csrf

        <div>
            <label class="field-label" for="email">Admin email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="input-field" placeholder="admin@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="password">Password</label>
            <input id="password" type="password" name="password"
                required autocomplete="current-password"
                class="input-field" placeholder="••••••••">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary" style="margin-top:4px;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Verify & Sign In
        </button>
    </form>

    <hr class="divider">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <a href="{{ route('admin.register') }}" style="color:white; font-size:0.83rem; font-weight:600; text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Register admin →</a>
        <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.3); font-size:0.78rem; text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">← User login</a>
    </div>
</x-guest-layout>
