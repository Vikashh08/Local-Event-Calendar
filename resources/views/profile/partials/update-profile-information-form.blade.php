<section>
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-xs font-semibold text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800" autofocus autocomplete="name">
            @error('name', 'updateProfileInformation')
                <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800" autocomplete="username">
            @error('email', 'updateProfileInformation')
                <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                    <p class="text-xs text-amber-800 font-bold">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-xs text-amber-900 hover:text-black font-black uppercase tracking-wider ml-1.5">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-slate-950 hover:bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-slate-500"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
