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
    
    //     {"username":"Adeagbo Matthew Damilare","account_number":"6577751982","account_name":"Adeagbo Matthew Damilare","amount":100,"charges":1,"credited_amount":99,"means":"Monnify","type":"Funding","paymentreference":"MNFY|40|20260128180532|003502","paidOn":"2026-01-28 18:05:33.281","product_balance":99,"retailer":null} 

        // 1. Get the raw payload

    $data = (object) $request->all();

    Log::info('Webhook received', $request->all());
    

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
                "Wallet Funding via Transfer ({$data->means})",
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
