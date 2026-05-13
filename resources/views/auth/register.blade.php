<x-guest-layout>
    <div style="margin-bottom:28px;">
        <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">Create account</h2>
        <p style="margin-top:6px; font-size:0.875rem; color:#64748b;">Join LECS — discover and create local events.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:15px;">
        @csrf

        <div>
            <label class="field-label" for="name">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                required autofocus autocomplete="name"
                class="input-field" placeholder="Your full name">
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autocomplete="username"
                class="input-field" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="password">Password</label>
            <input id="password" type="password" name="password"
                required autocomplete="new-password"
                class="input-field" placeholder="Min. 8 characters">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                class="input-field" placeholder="Repeat your password">
            @error('password_confirmation') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary" style="margin-top:6px;">
            Create free account
        </button>

        <p style="color:#94a3b8; font-size:0.72rem; text-align:center; line-height:1.6; margin:0;">
            By registering, you agree to our Terms of Service and Privacy Policy.
        </p>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
</x-guest-layout>
