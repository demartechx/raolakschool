<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-zinc-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Current
                Password</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">New
                Password</label>
            <input id="update_password_password" name="password" type="password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Confirm
                Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button
                class="px-6 py-2 bg-white hover:bg-zinc-200 text-black font-semibold rounded-lg shadow-sm transition-colors duration-200">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-500">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>