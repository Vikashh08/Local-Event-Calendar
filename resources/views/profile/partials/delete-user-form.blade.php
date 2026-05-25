<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-rose-600">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-xs font-semibold text-slate-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-slate-900 tracking-tight">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-xs font-semibold text-slate-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label class="block text-[10px] font-bold text-slate-450 uppercase tracking-widest mb-1.5" for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full md:w-3/4 text-xs font-semibold rounded-2xl border-slate-200 bg-white py-3 px-4 focus:border-slate-400 focus:ring-1 focus:ring-slate-400 outline-none text-slate-800"
                    placeholder="{{ __('Enter password to confirm') }}"
                />
                @error('password', 'userDeletion')
                    <p class="text-rose-650 text-xs mt-2 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
