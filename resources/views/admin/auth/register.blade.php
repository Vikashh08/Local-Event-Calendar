<x-guest-layout>
    <div class="mb-9">
        <h2 class="text-3xl font-black text-white tracking-tight">Register Admin</h2>
        <p class="mt-2 text-sm" style="color: rgba(255,255,255,0.4);">Create a secure administrator account for the platform.</p>
    </div>

    <form method="POST" action="{{ route('admin.register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name">Full name</label>
            <div class="mt-1.5">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="input-field" placeholder="Admin Name">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="email">Admin email</label>
            <div class="mt-1.5">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="input-field" placeholder="admin@example.com">
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="password">Password</label>
            <div class="mt-1.5">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="input-field" placeholder="Min. 8 characters">
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="password_confirmation">Confirm password</label>
            <div class="mt-1.5">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="input-field" placeholder="Repeat your password">
                @error('password_confirmation')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-1">
            <button type="submit" class="btn-primary">
                Create Admin Account
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="link">Already have an admin account?
            <a href="{{ route('admin.login') }}" class="link-bold">Sign in</a>
        </p>
    </div>
</x-guest-layout>
