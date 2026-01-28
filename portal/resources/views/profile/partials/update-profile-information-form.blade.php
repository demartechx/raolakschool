<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-zinc-400">
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
            <label for="name"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Name</label>
            <input id="name" name="name" type="text"
                class="w-full bg-zinc-950/50 border border-zinc-800 rounded-xl px-4 py-3 text-zinc-500 cursor-not-allowed"
                value="{{ old('name', $user->name) }}" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Email</label>
            <input id="email" name="email" type="email"
                class="w-full bg-zinc-950/50 border border-zinc-800 rounded-xl px-4 py-3 text-zinc-500 cursor-not-allowed"
                value="{{ old('email', $user->email) }}" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-zinc-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-zinc-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label for="phone_number"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Phone
                Number</label>
            <input id="phone_number" name="phone_number" type="text"
                class="w-full bg-zinc-950/50 border border-zinc-800 rounded-xl px-4 py-3 text-zinc-500 cursor-not-allowed"
                value="{{ old('phone_number', $user->phone_number) }}" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <label for="address"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Address</label>
            <input id="address" name="address" type="text"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                value="{{ old('address', $user->address) }}" required />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex items-center gap-4">
            <button
                class="px-6 py-2 bg-white hover:bg-zinc-200 text-black font-semibold rounded-lg shadow-sm transition-colors duration-200">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-500">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>