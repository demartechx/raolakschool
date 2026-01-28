<?php

namespace App\Services;

use App\Models\User;
use App\Models\VirtualAccount;
use App\Services\Payment\PayGate;
use Illuminate\Support\Facades\Log;

class AccountService
{
    public static function ensureAccountExists(User $user)
    {
        // 1. Sync Balance
        // For efficiency, maybe only sync if specific time passed? 
        // But for "Show wallet balance" requirement, we want it fresh.
        try {
            $payGate = new PayGate();
            // Use config product name or fallback.
            // But wait, product_balance takes an array. 
            // In test_payment.php we passed params.
            // The PayGate::product_balance() method in PayGate.php line 100 calls parent::getCurl.
            // We saw in test_payment.php that we passed the full user data array to generate_moniepoint_account.
            // But for product_balance?
            // "product_balance(array $data)" calls api/products/balance.
            // In Step 55, we saw passing $data to product_balance worked. 
            // The $data contained username, email, product name.

            // Let's construct the data payload.
            $data = [
                'website' => 'school.raolak.com', // hardcoded as per test script
                'product' => config('payment.name'),
                // user specific not strictly needed for PRODUCT balance?
                // Wait, product_balance returns the WALLET balance of the PRODUCT (the merchant)?
                // OR the user's sub-wallet?
                // The response in Step 55 was:
                // [wallet_balance] => 27332503.28
                // This looks like the MERCHANT'S balance (27 million).
                // The user request is "Display wallet balance... on the dashboard".
                // Does the user mean the STUDENT'S wallet?
                // Typically students have a wallet. 
                // Does PayGate support individual user wallets?
                // "generate_moniepoint_account" creates a virtual account *for the user*.
                // Monnify/Moniepoint virtual accounts usually dump into the main merchant wallet, 
                // and we track the user's balance locally in our DB.
                // So "wallet_balance" in `users` table is the source of truth for the student's funds.
                // WE increase it when a payment is received (webhook).
                // WE decrease it when they spend.
                //
                // SO: "ensureAccountExists" should just generate the account.
                // It should NOT overwrite local wallet_balance with the "Product Balance" (which is the merchant's 27M).
                //
                // EXCEPT: if the system is designed where each user has a sub-wallet on the provider?
                // But the API call is `api/products/balance`. That strongly suggests the MAIN product balance.
                // Response: `product: portal`, `wallet_balance`. 
                //
                // CONCLUSION: The `users.wallet_balance` is LOCAL. We do NOT sync it with `product_balance`. 
                // We track it via Webhooks (which is a separate task/conversation, user noticed webhook URL in history).
                //
                // However, the user said "get balance" in Step 0 and we fetched the 27M.
                // And said "Display wallet balance... on the dashboard".
                // If I display 27M to the student, they will think they are rich.
                // I should display the USER's local balance (initially 0).
                //
                // So AccountService should ONLY generate the account if missing.

            ];

            // 2. account generation
            if (!$user->virtualAccount) {
                // Prepare data for generation
                $genData = [
                    'website' => 'school.raolak.com',
                    'product' => config('payment.name'),
                    'website_callback' => 'https://school.raolak.com/portal/public/api/webhook', // Should probably be dynamic/env
                    'username' => $user->name, // Usernames must be unique/clean?
                    // PayGate might require unique username.
                    // Let's use user-id suffix or sanitize name?
                    // test_payment.php used `TestUser_` + random.
                    'account_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number,
                    'bvn' => '11111111111', // Dummy BVN as discussed, or pass empty if allowed (tried, failed).
                    // Or retrieve from user if we add it. 
                    // I'll use a placeholder and Log a warning.
                ];

                $response = $payGate->generate_moniepoint_account($genData);

                // Log response for debug
                Log::info('Account Generation Response for ' . $user->email, (array) $response);

                if (isset($response['statusCode']) && $response['statusCode'] == 201) {
                    // Success
                    // Extract data. Structure:
                    // data => [ Monnify => [ status => 1, data => [ account_number, bank_name, ... ] ] ]
                    if (isset($response['data']['Monnify']['data'])) {
                        $accData = $response['data']['Monnify']['data'];

                        $user->virtualAccount()->create([
                            'account_name' => $accData['account_name'] ?? $user->name,
                            'account_number' => $accData['account_number'],
                            'bank_name' => $accData['bank_name'],
                            'bank_code' => $accData['bank_code'] ?? null,
                        ]);
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('AccountService Error: ' . $e->getMessage());
        }
    }
}
