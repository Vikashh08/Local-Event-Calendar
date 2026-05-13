<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Registration</h2>
        <p class="text-sm text-gray-500 mt-2">Create an administrator account to manage the platform.</p>
    </div>

    <form method="POST" action="{{ route('admin.register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Administrator Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white transition-colors"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" href="{{ route('admin.login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="ms-4 inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register as Admin') }}
            </button>
        </div>
    </form>
</x-guest-layout>
