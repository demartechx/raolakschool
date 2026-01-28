<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-light text-white tracking-tight">Welcome Back</h2>
        <p class="text-zinc-500 text-sm mt-2">Sign in to access your dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-6 p-4 bg-emerald-500/10 text-emerald-500 text-sm rounded-lg border border-emerald-500/20"
        :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Email or
                Phone</label>
            <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="Enter your email or phone">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password"
                class="block text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1.5 ml-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-4 py-3 text-white placeholder-zinc-600 focus:border-white focus:ring-0 focus:outline-none transition-colors"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded bg-zinc-900 border-zinc-700 text-white shadow-sm focus:ring-0 focus:ring-offset-0 cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-sm text-zinc-400 group-hover:text-zinc-300 transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-zinc-500 hover:text-white transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button
                class="w-full py-3.5 bg-white hover:bg-zinc-200 text-black font-semibold rounded-xl shadow-lg shadow-white/5 transform active:scale-[0.98] transition-all duration-200">
                {{ __('Sign In') }}
            </button>
        </div>

        <div class="text-center mt-8 pt-6 border-t border-zinc-800/50">
            <p class="text-sm text-zinc-500">
                New to Raolak?
                <a href="{{ route('enroll') }}"
                    class="text-white hover:text-zinc-300 font-medium transition-colors ml-1 border-b border-zinc-700 hover:border-zinc-500 pb-0.5">
                    Enroll for 2026 Session
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>