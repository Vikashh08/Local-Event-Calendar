<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white tracking-tight">Register Admin</h2>
        <p class="mt-1.5 text-sm" style="color: rgba(255,255,255,0.4);">Create a secure administrator account.</p>
    </div>

    <form method="POST" action="{{ route('admin.register') }}" style="display:flex; flex-direction:column; gap:16px;">
        @csrf

        <div>
            <label class="field-label" for="name">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                required autofocus autocomplete="name"
                class="input-field" placeholder="Admin Name">
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="email">Admin email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autocomplete="username"
                class="input-field" placeholder="admin@example.com">
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
            Create Admin Account
        </button>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Already have an admin account? <a href="{{ route('admin.login') }}">Sign in</a>
    </p>
</x-guest-layout>
