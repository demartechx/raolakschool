<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-medium text-xl text-zinc-100 tracking-tight">
                {{ __('Overview') }}
            </h2>
            <div class="text-sm text-zinc-400">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-light tracking-tighter text-white mb-2">
                Welcome back, <span class="font-medium text-white">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-zinc-400">Here's what's happening with your account today.</p>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Wallet Balance Card (Focal Point) -->
            <div
                class="bg-zinc-900/50 border border-zinc-800/80 rounded-2xl p-8 hover:border-zinc-700 transition-all duration-300 group relative overflow-hidden backdrop-blur-sm">

                <div class="flex items-center justify-between mb-8">
                    <div class="p-2.5 bg-zinc-900 rounded-lg border border-zinc-800 text-zinc-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 18V6l10 12V6M5 10h14M5 14h14">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-[10px] uppercase tracking-wider font-semibold text-zinc-500 bg-zinc-900 border border-zinc-800 px-2 py-1 rounded-md">Available
                        Balance</span>
                </div>

                <div class="flex items-baseline gap-1">
                    <span class="text-2xl text-zinc-500 font-light">₦</span>
                    <span
                        class="text-5xl font-semibold text-white tracking-tighter">{{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                </div>

            </div>

            <!-- Dedicated Account -->
            <div
                class="bg-zinc-900/50 border border-zinc-800/80 rounded-2xl p-8 hover:border-zinc-700 transition-all duration-300 group backdrop-blur-sm">
                <div class="flex items-center justify-between mb-8">
                    <div class="p-2.5 bg-zinc-900 rounded-lg border border-zinc-800 text-zinc-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-[10px] uppercase tracking-wider font-semibold text-zinc-500 bg-zinc-900 border border-zinc-800 px-2 py-1 rounded-md">Deposit
                        Info</span>
                </div>

                @if(Auth::user()->virtualAccount)
                    <div class="space-y-4">
                        <div>
                            <div class="text-2xl font-mono font-medium text-white tracking-tight">
                                {{ Auth::user()->virtualAccount->account_number }}
                            </div>
                            <div class="text-sm text-zinc-500 mt-1">{{ Auth::user()->virtualAccount->bank_name }}</div>
                        </div>
                        <div class="pt-4 border-t border-zinc-800/50">
                            <div class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Account Name</div>
                            <div class="text-sm text-zinc-300 truncate">{{ Auth::user()->virtualAccount->account_name }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="h-full flex flex-col justify-center">
                        <p class="text-yellow-500/80 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Account generation in progress...
                        </p>
                    </div>
                @endif
            </div>

            <!-- Enroll Action -->
            <div
                class="bg-zinc-900/50 border border-zinc-800/80 rounded-2xl p-8 hover:border-zinc-700 transition-all duration-300 group flex flex-col justify-between backdrop-blur-sm">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="p-2.5 bg-zinc-900 rounded-lg border border-zinc-800 text-zinc-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <span class="relative flex h-2.5 w-2.5">
                            @if(now()->greaterThanOrEqualTo('2026-02-12 12:00:00'))
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            @else
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                            @endif
                        </span>
                    </div>
                    <h3 class="text-xl font-medium text-white mb-2 tracking-tight">2026 Session</h3>
                    @if(now()->greaterThanOrEqualTo('2026-02-12 12:00:00'))
                        <p class="text-zinc-400 text-sm leading-relaxed">Registration for the 2026 academic session has
                            <span class="text-red-400 font-medium">closed</span>.
                        </p>
                    @else
                        <p class="text-zinc-400 text-sm leading-relaxed">Admission is currently ongoing. Secure your spot in
                            the tech school today.</p>
                    @endif
                </div>

                @if(now()->greaterThanOrEqualTo('2026-02-12 12:00:00'))
                    <button disabled
                        class="mt-6 w-full py-3 bg-zinc-800 text-zinc-500 font-semibold text-sm text-center rounded-lg cursor-not-allowed border border-zinc-700">
                        Registration Closed
                    </button>
                @else
                    <a href="{{ route('student.enroll') }}"
                        class="mt-6 w-full py-3 bg-white text-black font-semibold text-sm text-center rounded-lg hover:bg-zinc-200 transition-colors">
                        Enroll Now
                    </a>
                @endif
            </div>
        </div>

        <!-- Lower Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Wallet History Table -->
            <div class="lg:col-span-2 bg-zinc-900/50 border border-zinc-800/80 rounded-2xl p-8 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-medium text-white tracking-tight">Recent Transactions</h3>
                    <a href="{{ route('wallet.history') }}"
                        class="text-sm text-zinc-400 hover:text-white transition-colors">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-zinc-500 text-xs font-medium uppercase tracking-wider">
                                <th class="pb-4 font-normal">Description</th>
                                <th class="pb-4 font-normal text-right">Amount</th>
                                <th class="pb-4 font-normal text-right">Date</th>
                                <th class="pb-4 font-normal text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/50 text-sm">
                            @forelse(Auth::user()->walletHistory()->latest()->take(5)->get() as $history)
                                <tr class="group">
                                    <td class="py-4 text-zinc-300">
                                        <div class="font-medium text-white group-hover:text-primary-400 transition-colors">
                                            {{ $history->description }}
                                        </div>
                                        <div class="text-xs text-zinc-600 font-mono mt-0.5">{{ $history->reference }}</div>
                                    </td>
                                    <td
                                        class="py-4 text-right font-medium {{ $history->type === 'credit' ? 'text-emerald-400' : 'text-zinc-100' }}">
                                        {{ $history->type === 'credit' ? '+' : '-' }}₦{{ number_format($history->amount, 2) }}
                                    </td>
                                    <td class="py-4 text-right text-zinc-500">
                                        {{ $history->created_at->format('M d') }}
                                    </td>
                                    <td class="py-4 text-center">
                                        <div
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $history->type === 'credit' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-red-500/10 text-red-500' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $history->type === 'credit' ? 'M19 14l-7 7m0 0l-7-7m7 7V3' : 'M5 10l7-7m0 0l7 7m-7-7v18' }}">
                                                </path>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-zinc-600 italic">
                                        No recent activity to show.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Profile Summary -->
            <div
                class="bg-zinc-900/50 border border-zinc-800/80 rounded-2xl p-8 backdrop-blur-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-medium text-white mb-6 tracking-tight">Profile Info</h3>

                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-14 h-14 bg-zinc-800 rounded-full flex items-center justify-center text-xl font-medium text-white border border-zinc-700">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-lg text-white leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-zinc-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="group">
                            <div class="text-xs text-zinc-500 uppercase tracking-wide mb-1.5 ml-1">Phone Number</div>
                            <div
                                class="p-3 bg-zinc-950/50 rounded-lg border border-zinc-800/50 text-zinc-300 text-sm group-hover:border-zinc-700 transition-colors">
                                {{ Auth::user()->phone_number }}
                            </div>
                        </div>
                        <div class="group">
                            <div class="text-xs text-zinc-500 uppercase tracking-wide mb-1.5 ml-1">Address</div>
                            <div
                                class="p-3 bg-zinc-950/50 rounded-lg border border-zinc-800/50 text-zinc-300 text-sm group-hover:border-zinc-700 transition-colors leading-relaxed">
                                {{ Auth::user()->address }}
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="mt-8 block w-full py-3 bg-zinc-800 hover:bg-zinc-700 text-white font-medium text-sm text-center rounded-lg border border-zinc-700 transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>