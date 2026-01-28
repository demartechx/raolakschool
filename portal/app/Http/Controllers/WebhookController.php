<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle the incoming webhook.
     */
    public function handle(Request $request)
    {
        // 1. Get the raw payload
        $payload = @file_get_contents("php://input");
        $data = json_decode($payload);

        Log::info('Webhook received', (array) $data);

        if (!$data || !isset($data->account_number) || !isset($data->amount)) {
            Log::warning('Webhook received invalid data structure');
            return response()->json(['status' => 'failed', 'message' => 'Invalid data'], 400);
        }

        // 2. Identify the user via Virtual Account
        $virtualAccount = \App\Models\VirtualAccount::where('account_number', $data->account_number)->first();

        if (!$virtualAccount) {
            Log::error("Webhook: Virtual Account not found for account number: {$data->account_number}");
            return response()->json(['status' => 'failed', 'message' => 'Account not found'], 404);
        }

        // 3. Credit the user's wallet
        $user = $virtualAccount->user;

        if (!$user) {
            Log::error("Webhook: User not found for virtual account: {$virtualAccount->id}");
            return response()->json(['status' => 'failed', 'message' => 'User not found'], 404);
        }

        try {
            // Check for duplicate reference if provided in payload, to be safe (optional but good practice)
            // For now, assuming distinct transactions or handled by payment provider logic.
            // We'll use the payload's ID or generate a reference.
            $reference = isset($data->reference) ? $data->reference : 'WH_' . \Illuminate\Support\Str::random(12);

            \App\Services\WalletService::credit(
                $user,
                (float) $data->amount,
                "Wallet Funding via Transfer ({$data->bank_name})",
                $reference
            );

            Log::info("Webhook: Wallet credited for user {$user->id} with amount {$data->amount}");

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error("Webhook error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
