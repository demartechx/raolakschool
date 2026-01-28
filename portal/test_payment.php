<?php

use App\Services\Payment\PayGate;
use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$payGate = new PayGate();

$data = [
    'website' => 'mobilenig.com',
    'product' => config('payment.name'),
    'website_callback' => 'https://mobilenig.org/webhook/pay',
    'username' => 'TestUser_' . Str::random(5),
    'account_name' => 'Test Name ' . Str::random(3),
    'email' => 'test_' . Str::random(5) . '@example.com',
    'phone' => '080' . rand(10000000, 99999999),
    'bvn' => '22222222222', // Dummy BVN
];

echo "Sending Data:\n";
print_r($data);

echo "\nResponse:\n";
try {
    $response = $payGate->generate_moniepoint_account($data);
    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
