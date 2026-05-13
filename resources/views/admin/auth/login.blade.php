<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Portal</h2>
        <p class="text-sm text-gray-500 mt-2">Secure access for platform administrators only.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Administrator Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end pt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="ms-3 inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Secure Login') }}
            </button>
        </div>
    </form>
    
    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col items-center gap-3">
        <a href="{{ route('admin.register') }}" class="text-sm font-bold text-gray-900 hover:text-gray-600 transition-colors">
            Need an admin account? Register here
        </a>
        <a href="{{ route('login') }}" class="text-xs font-medium text-gray-400 hover:text-gray-900 transition-colors">
            &larr; Return to Standard Login
        </a>
    </div>
</x-guest-layout>
