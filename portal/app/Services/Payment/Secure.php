<?php

namespace App\Services\Payment;

use Exception;
use Illuminate\Support\Facades\Request;

class Secure
{
    private static function data(string $input)
    {
        return match ($input) {
            'key' => WebSettings::get_encryption_data('key'),
            'iv' => WebSettings::get_encryption_data('iv'),
            'encryption_type' => WebSettings::get_encryption_data('encryption_type'),
            default => null,
        };
    }

    /**
     * encrypts data
     * @param string $data
     * @param string $key
     * @return string|false
     * @throws Exception
     */
    public static function encrypt($data, $key)
    {
        try {
            if (self::data('key') === $key) {
                // Determine IV length
                $ivLength = openssl_cipher_iv_length(self::data('encryption_type'));
                $iv = self::data('iv');

                // Ensure IV is correct length (padding or truncation if necessary, though best to set correctly in WebSettings)
                if (strlen($iv) !== $ivLength) {
                    // For now, assume WebSettings returns correct length or handle error
                    // Falling back to substr for safety if too long, pads with null if too short (not ideal but keeps legacy behavior likely)
                    $iv = substr(str_pad($iv, $ivLength, "\0"), 0, $ivLength);
                }

                $encrypted_data = base64_encode(openssl_encrypt($data, self::data('encryption_type'), $key, OPENSSL_RAW_DATA, $iv));
                return $encrypted_data;
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * decrypts data
     * @param string $data
     * @param string $key
     * @return string|false
     * @throws Exception
     */
    public static function decrypt($data, $key)
    {
        try {
            if (self::data('key') === $key) {
                $ivLength = openssl_cipher_iv_length(self::data('encryption_type'));
                $iv = self::data('iv');
                if (strlen($iv) !== $ivLength) {
                    $iv = substr(str_pad($iv, $ivLength, "\0"), 0, $ivLength);
                }

                $message = base64_decode($data ?? '');
                $plainText = openssl_decrypt($message, self::data('encryption_type'), $key, OPENSSL_RAW_DATA, $iv);
                return $plainText;
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function validatePost()
    {
        // In Laravel, we typically use Middleware for CORS, but here is logic preserved
        // Note: modify methods to return data, not echo/exit if possible, or use standard Laravel controllers

        $encoded = file_get_contents("php://input");
        // Or Request::getContent();

        $secret_key = $_SERVER['HTTP_SECRET_KEY'] ?? null;

        // Needed because json_decode return type varies
        $decoded_json = json_decode($encoded, true);
        // If the payload itself is the encrypted string? The original code had confusing logic: 
        // $encoded = json_decode(file_get_contents(...), true) -> passed to decrypt?
        // But decrypt expects string. 
        // Based on original `data = json_decode(self::decrypt($encoded, self::data('key')));`
        // It implies `file_get_contents` returns a JSON string which MIGHT be the encrypted string? 
        // Actually, original code: `$encoded = json_decode(file_get_contents("php://input"), true);` then `decrypt($encoded`
        // `decrypt` expects string. `json_decode` returns array/object/null.
        // It seems the legacy code expects the POST body to be a JSON string like "base64encodedstring"?
        // Or maybe it's just raw string.
        // Let's assume standard behavior: input is the raw encrypted string, or a JSON containing it.
        // Fixing potential legacy bug behavior assuming input is raw string if json_decode fails or if it's just a string.

        // Re-reading legacy: `$encoded = json_decode(file_get_contents("php://input"), true);`
        // If input is `"SGVsbG8="` (json string), `$encoded` becomes `SGVsbG8=`.
        // Then `decrypt` is called on that.

        $rawInput = file_get_contents("php://input");
        $jsonInput = json_decode($rawInput, true);
        $inputToDecrypt = is_string($jsonInput) ? $jsonInput : $rawInput; // heuristic

        // However, let's stick closer to the provided snippet
        // $encoded = json_decode(..., true); 
        // $data = json_decode(self::decrypt($encoded ...));

        // We will return the decrypted data
        if ($inputToDecrypt) {
            $decrypted = self::decrypt($inputToDecrypt, self::data('key'));
            return json_decode($decrypted, true);
        }

        return false;
    }

    // Removed legacy response/header methods as they should be handled by Laravel Controllers
    // But kept postCurl/getCurl helpers

    public static function postCurl(string $domain_url, string $path_url, string $key, $postdata = [])
    {
        $encryptedPostData = self::encrypt(json_encode($postdata), self::data('key'));

        // Ensure URL format
        $url = rtrim($domain_url, '/') . '/' . ltrim($path_url, '/');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($encryptedPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $headers = [
            "secret-key: $key",
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        // Debugging
        // var_dump($response);

        if (!$response)
            return false;

        $data = self::decrypt($response, self::data('key'));
        return $data ? json_decode($data, true) : false; // Usually expect array back
    }

    public static function getCurl(string $domain_url, string $path_url, string $key, $params = [])
    {
        $encryptedParams = self::encrypt(json_encode($params), self::data('key'));
        // In legacy code: $ch = curl_init($domain_url.'/'.$path_url.'?'.$getdata); 
        // $getdata was encoded string.

        $url = rtrim($domain_url, '/') . '/' . ltrim($path_url, '/') . '?' . urlencode($encryptedParams);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $headers = [
            "secret-key: $key",
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response)
            return false;

        $data = self::decrypt($response, self::data('key'));
        return $data ? json_decode($data, true) : false;
    }
}
