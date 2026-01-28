<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    /**
     * Credit the user's wallet.
     *
     * @param User $user
     * @param float $amount
     * @param string $description
     * @param string|null $reference
     * @return WalletHistory
     * @throws \Exception
     */
    public static function credit(User $user, float $amount, string $description, ?string $reference = null)
    {
        return DB::transaction(function () use ($user, $amount, $description, $reference) {
            $balanceBefore = $user->wallet_balance;
            $user->wallet_balance += $amount;
            $user->save();

            $history = WalletHistory::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'description' => $description,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->wallet_balance,
                'reference' => $reference ?? 'REF_' . Str::random(10),
            ]);

            return $history;
        });
    }

    /**
     * Debit the user's wallet.
     *
     * @param User $user
     * @param float $amount
     * @param string $description
     * @param string|null $reference
     * @return WalletHistory
     * @throws \Exception
     */
    public static function debit(User $user, float $amount, string $description, ?string $reference = null)
    {
        return DB::transaction(function () use ($user, $amount, $description, $reference) {
            if ($user->wallet_balance < $amount) {
                throw new \Exception("Insufficient wallet balance.");
            }

            $balanceBefore = $user->wallet_balance;
            $user->wallet_balance -= $amount;
            $user->save();

            $history = WalletHistory::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'debit',
                'description' => $description,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->wallet_balance,
                'reference' => $reference ?? 'REF_' . Str::random(10),
            ]);

            return $history;
        });
    }
}
