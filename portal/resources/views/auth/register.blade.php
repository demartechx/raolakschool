<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-light text-white tracking-tight">2026 Academic Session</h2>
        <p class="text-zinc-500 text-sm mt-2">Create your student account to apply.</p>
    </div>

    <form method="POST" action="{{ route('enroll') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Full
                Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Email
                Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="john@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div>
            <label for="phone_number"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Phone
                Number</label>
            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="08012345678">
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <label for="address"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Residential
                Address</label>
            <input id="address" type="text" name="address" value="{{ old('address') }}" required
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="Street Address, City">
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Confirm
                Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            @if(now()->greaterThanOrEqualTo('2026-02-10'))
                <button disabled
                    class="w-full py-3.5 bg-zinc-800 text-zinc-500 font-semibold rounded-xl border border-zinc-700 cursor-not-allowed">
                    Registration Closed
                </button>
            @else
                <button
                    class="w-full py-3.5 bg-white hover:bg-zinc-200 text-black font-semibold rounded-xl shadow-lg shadow-white/5 transform active:scale-[0.98] transition-all duration-200">
                    {{ __('Create Account') }}
                </button>
            @endif
        </div>

        <div class="text-center mt-8 pt-6 border-t border-zinc-800/50">
            <p class="text-sm text-zinc-500">
                Already registered?
                <a href="{{ route('login') }}"
                    class="text-white hover:text-zinc-300 font-medium transition-colors ml-1 border-b border-zinc-700 hover:border-zinc-500 pb-0.5">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>