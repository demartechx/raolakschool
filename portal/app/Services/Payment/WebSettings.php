<?php

namespace App\Services\Payment;

class WebSettings
{
    public static function portal_data($key)
    {
        return match ($key) {
            'name' => config('payment.name'), //portal
            'pay_url' => config('payment.pay_url'), //https://pay.mobilenig.org'
            'product_key' => config('payment.product_key'), //6pidZYEO3MCk1WH08NrwASRte
            default => null,
        };
    }

    public static function get_encryption_data($key)
    {
        return match ($key) {
            'key' => config('payment.encryption.key'), //Fk6eQkHVwQe5JkZXQu4wAE1T3blxc3gR
            'iv' => config('payment.encryption.iv'), //Rao$laK#TECH!12@
            'encryption_type' => config('payment.encryption.type'), //aes-256-ctr
            'user_key' => config('payment.user_key'), //QkNK24mfpnldAXRCPSZwweweFcoaJ
            default => null,
        };
    }
	 


    public static function gateway_keys($key)
    {
        // Assuming this maps to the secret key, though original code had 'paystack_secret_key' as arg
        return config('payment.secret_key');
    }
}
