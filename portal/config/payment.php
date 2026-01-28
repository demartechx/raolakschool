<?php

return [
    'name' => env('PORTAL_NAME', 'Raolak School Portal'),
    'pay_url' => env('PAYMENT_GATEWAY_URL', 'https://api.monnify.com'),
    'product_key' => env('PAYMENT_PRODUCT_KEY', ''),
    'user_key' => env('PAYMENT_USER_KEY', ''),
    'secret_key' => env('PAYMENT_GATEWAY_SECRET', ''), // If needed for gateway_keys

    'encryption' => [
        'key' => env('PAYMENT_ENCRYPTION_KEY', ''),
        'iv' => env('PAYMENT_ENCRYPTION_IV', ''),
        'type' => env('PAYMENT_ENCRYPTION_TYPE', 'AES-256-CBC'),
    ],
];
