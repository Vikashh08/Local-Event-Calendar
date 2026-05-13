<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <div class="inline-flex items-center justify-center bg-gray-900 text-white rounded-xl p-3 mb-4 shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Portal</h2>
        <p class="text-gray-500 mt-2">Secure access for platform administrators.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Administrator Email')" class="mb-1 font-semibold" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
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
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                {{ __('Secure Login') }}
            </button>
        </div>
    </form>
    
    <div class="mt-12 pt-6 border-t border-gray-100 flex flex-col items-center lg:items-start gap-4">
        <a href="{{ route('admin.register') }}" class="text-sm font-bold text-gray-900 hover:underline transition-colors">
            Need an admin account? Register here &rarr;
        </a>
        <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-wider">
            &larr; Standard Login
        </a>
    </div>
</x-guest-layout>
