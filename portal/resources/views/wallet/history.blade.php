<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-light text-2xl text-white tracking-tight">
                    Wallet History
                </h2>
                <a href="{{ route('dashboard') }}" class="text-sm text-zinc-400 hover:text-white transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Overview
                </a>
            </div>

            <div class="bg-zinc-900 overflow-hidden shadow-lg sm:rounded-xl border border-zinc-800/80">
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-zinc-500 text-xs font-medium uppercase tracking-wider border-b border-zinc-800/80 bg-zinc-950/30">
                                    <th class="py-4 px-6">Transaction Details</th>
                                    <th class="py-4 px-6 text-right">Amount</th>
                                    <th class="py-4 px-6 text-right hidden sm:table-cell">Balance</th>
                                    <th class="py-4 px-6 text-right">Date</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800/50 text-sm">
                                @forelse($histories as $history)
                                    <tr class="group hover:bg-zinc-800/30 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $history->type === 'credit' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-red-500/10 text-red-500' }}">
                                                    @if($history->type === 'credit')
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                    @else
                                                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-zinc-200 group-hover:text-white transition-colors">{{ $history->description }}</div>
                                                    <div class="text-xs text-zinc-500 font-mono mt-0.5">{{ $history->reference }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <span class="font-medium {{ $history->type === 'credit' ? 'text-emerald-400' : 'text-zinc-200' }}">
                                                {{ $history->type === 'credit' ? '+' : '-' }}₦{{ number_format($history->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right text-zinc-500 font-mono hidden sm:table-cell">
                                            ₦{{ number_format($history->balance_after, 2) }}
                                        </td>
                                        <td class="py-4 px-6 text-right text-zinc-400">
                                            {{ $history->created_at->format('M d, Y') }}<br>
                                            <span class="text-xs text-zinc-600">{{ $history->created_at->format('h:i A') }}</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $history->type === 'credit' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border border-zinc-700' }}">
                                                Successful
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-zinc-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-zinc-800 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <p>No transactions found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($histories->hasPages())
                        <div class="border-t border-zinc-800/80 px-6 py-4 bg-zinc-900">
                            {{ $histories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>