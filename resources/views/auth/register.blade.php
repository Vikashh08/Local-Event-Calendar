<x-guest-layout>
    <div class="mb-9">
        <h2 class="text-3xl font-black text-white tracking-tight">Create account</h2>
        <p class="mt-2 text-sm" style="color: rgba(255,255,255,0.4);">Join thousands of event-goers on LECS. It's free.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name">Full name</label>
            <div class="mt-1.5">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="input-field" placeholder="Raj Kumar">
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="email">Email address</label>
            <div class="mt-1.5">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="input-field" placeholder="you@example.com">
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
                Create free account
            </button>
        </div>

        <p class="text-center text-xs leading-relaxed" style="color: rgba(255,255,255,0.3);">
            By creating an account, you agree to our Terms of Service and Privacy Policy.
        </p>
    </form>

    <div class="mt-6 text-center">
        <p class="link">Already have an account?
            <a href="{{ route('login') }}" class="link-bold">Sign in</a>
        </p>
    </div>
</x-guest-layout>
