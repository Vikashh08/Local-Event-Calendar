<section>
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-xs font-semibold text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="update_password_current_password">Current Password</label>
            <input type="password" id="update_password_current_password" name="current_password" class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="update_password_password">New Password</label>
            <input type="password" id="update_password_password" name="password" class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800" autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="update_password_password_confirmation">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="w-full text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-rose-600 text-xs mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-slate-950 hover:bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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
