<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white tracking-tight">Create account</h2>
        <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.4);">Join LECS — it's free to get started.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:16px;">
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

        <p style="color:rgba(255,255,255,0.2); font-size:0.72rem; text-align:center; line-height:1.5;">
            By registering, you agree to our Terms of Service and Privacy Policy.
        </p>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
</x-guest-layout>
