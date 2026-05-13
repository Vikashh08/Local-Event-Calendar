<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome Back</h2>
        <p class="text-gray-500 mt-3">Log in to your account to manage your events and RSVPs.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="mb-1 font-semibold" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-500 hover:text-gray-900 font-medium transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
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

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 bg-gray-900 border border-transparent rounded-xl font-bold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all shadow-md hover:shadow-lg">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <div class="mt-10 text-center">
        <p class="text-gray-500">Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:underline">Sign up</a>
        </p>
    </div>

    <div class="mt-12 pt-6 border-t border-gray-100 text-center lg:text-left">
        <a href="{{ route('admin.login') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-wider">
            Admin Portal
        </a>
    </div>
</x-guest-layout>
