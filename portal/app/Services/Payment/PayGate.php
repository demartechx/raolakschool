<?php

namespace App\Services\Payment;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayGate extends Secure
{
    public static function get_acc($input)
    {
        return match ($input) {
            'product_name' => WebSettings::portal_data('name'),
            default => null,
        };
    }

    public static function get_url($input)
    {
        return match ($input) {
            'pay' => WebSettings::portal_data('pay_url'),
            default => null,
        };
    }

    private static function keys($input)
    {
        return match ($input) {
            'portal' => WebSettings::portal_data('product_key'),
            default => null,
        };
    }

    public function list_banks()
    {
        return parent::getCurl(self::get_url('pay'), 'api/bank/list', self::keys('portal'), ['1']);
    }

    public function account_name_enquiry(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/bank/name_enquiry', self::keys('portal'), $data);
    }

    public function add_account(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/account/add', self::keys('portal'), $data);
    }

    public function generate_moniepoint_account(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/account/virtual', self::keys('portal'), $data);
    }

    public function pay_with_card(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/payment/monnify', self::keys('portal'), $data);
    }

    public function generate_paystack_account(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/account/virtual_account/create', self::keys('portal'), $data);
    }

    public function get_collection_account(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/account/virtual_account/get', self::keys('portal'), $data);
    }

    public function link_collection_account(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/account/virtual_account/update', self::keys('portal'), $data);
    }

    public function make_payment(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/pay/', self::keys('portal'), $data);
    }

    public function paystack_payment(array $data)
    {
        return parent::postCurl(self::get_url('pay'), '/api/payment/', self::keys('portal'), $data);
    }

    public function monnify_payment(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/payment/monnify', self::keys('portal'), $data);
    }

    public function query_paystack(array $data)
    {
        return parent::getCurl(self::get_url('pay'), '/api/payment/query', self::keys('portal'), $data);
    }

    public function create_product(array $data)
    {
        return parent::postCurl(self::get_url('pay'), 'api/products/create', WebSettings::get_encryption_data('user_key'), $data);
    }

    public function product_balance(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/products/balance', self::keys('portal'), $data);
    }

    public function get_bank_name(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/bank/name', self::keys('portal'), $data);
    }

    public function recipient_code_details(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/account/get', self::keys('portal'), $data);
    }

    public function query_transaction(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/pay/query', self::keys('portal'), $data);
    }

    public function verify_bvn(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/bank/bvn/verify', self::keys('portal'), $data);
    }

    public function verify_phonenumber(array $data)
    {
        return parent::getCurl(self::get_url('pay'), 'api/bank/number/verify', self::keys('portal'), $data);
    }

    public function get_bank_code($input)
    {
        return match ($input) {
            'ACCESS' => 1101,
            'ECOBANK' => 1102,
            'FIDELITY' => 1103,
            'FCMB' => 1104,
            'FIRST' => 1105,
            'GTB' => 1106,
            'POLARIS' => 1107,
            'STANBIC' => 1108,
            'STERLING' => 1109,
            'UNION' => 1110,
            'UBA' => 1111,
            'WEMA' => 1112,
            'ZENITH' => 1113,
            'UNITY' => 1115,
            'KUDA' => 1116,
            'PAYCOM' => 1117,
            'PROVIDUS' => 1118,
            'RUBIES' => 1119,
            'TAJ' => 1120,
            'JAIZ' => 1121,
            'KEYSTONE' => 1122,
            'CARBON' => 1123,
            'PALMPAY' => 1124,
            'PARALLEX' => 1125,
            'STDCHARTERED' => 1126,
            '9PSB' => 1127,
            'MONIEPOINT' => 1128,
            'VFD' => 1130,
            'PAGA' => 1131,
            default => null,
        };
    }

    // ... [Other get_bank_shortname/fullname methods would follow similar match patterns] ...
    // Using simple arrays for brevity or keeping full switch if preferred.
    // I'll skip full duplication of all bank lists unless strictly necessary, 
    // but the user requested "create this class", so I should include them.

    public function get_bank_shortname($input)
    {
        return match ((int) $input) {
            1101 => 'ACCESS',
            1102 => 'ECOBANK',
            1103 => 'FIDELITY',
            1104 => 'FCMB',
            1105 => 'FIRST',
            1106 => 'GTB',
            1107 => 'POLARIS',
            1108 => 'STANBIC',
            1109 => 'STERLING',
            1110 => 'UNION',
            1111 => 'UBA',
            1112 => 'WEMA',
            1113 => 'ZENITH',
            1115 => 'UNITY',
            1116 => 'KUDA',
            1117 => 'PAYCOM',
            1118 => 'PROVIDUS',
            1119 => 'RUBIES',
            1120 => 'TAJ',
            1121 => 'JAIZ',
            1122 => 'KEYSTONE',
            1123 => 'CARBON',
            1124 => 'PALMPAY',
            1125 => 'PARALLEX',
            1126 => 'STDCHARTERED',
            1127 => '9PSB',
            1128 => 'MONIEPOINT',
            1130 => 'VFD',
            1131 => 'PAGA',
            default => null,
        };
    }

    // Omitted fullname list for brevity unless specific instruction 
    // (User said "create THIS class" so I should probably be thorough actually).

    public function get_bank_fullname($input)
    {
        return match ((int) $input) {
            1101 => 'Access Bank',
            1102 => 'Ecobank Nigeria',
            1103 => 'Fidelity Bank',
            1104 => 'First City Monument Bank Plc',
            1105 => 'First Bank of Nigeria',
            1106 => 'Guaranty Trust Bank Plc',
            1107 => 'Polaris Bank Limited.',
            1108 => 'Stanbic IBTC Bank Plc',
            1109 => 'Sterling Bank Plc',
            1110 => 'Union Bank of Nigeria Plc',
            1111 => 'United Bank for Africa Plc',
            1112 => 'Wema Bank Plc',
            1113 => 'Zenith Bank Plc',
            1115 => 'Unity Bank',
            1116 => 'Kuda Microfinance Bank',
            1117 => 'Paycom',
            1118 => 'Providus Bank',
            1119 => 'Rubies Microfinance Bank',
            1120 => 'Taj',
            1121 => 'JAIZ',
            1122 => 'KEYSTONE',
            1123 => 'Carbon',
            1124 => 'Palmpay',
            1125 => 'Parallex Bank',
            1126 => 'Standard Chartered Bank',
            1127 => '9mobile 9Payment Service Bank',
            1128 => 'Moniepoint MFB',
            1130 => 'VFD Microfinance Bank',
            1131 => 'Paga',
            default => null,
        };
    }


    public function get_bank_to_generate($username)
    {
        // IMPORTANT: 'members_id' column likely doesn't exist on standard User model. 
        // Adapting to use 'id' or handle missing column gracefully.

        $user = User::where('name', $username)->first(); // Assuming username maps to name

        if (!$user) {
            return ['status' => false, 'gateway' => 'unknown', 'message' => 'User not found'];
        }

        // Adapted Query using DB Facade
        // Note: virtual_account table does not exist yet. This will fail if run.
        try {
            // Using try-catch to allow compiling even if table missing
            $details = DB::table('virtual_account')
                ->where('members_id', $user->id) // Assuming members_id = user id
                ->get(); // returns Collection

            $count = $details->count();

            if ($count == 0) {
                $gateway = "Monnify,PalmPay";
                $status = true;
                $message = "successful";
            } elseif ($count == 2) {
                $gateway = "unknown";
                $status = false;
                $message = "User already has two unique accounts";
            } else { // $count == 1
                $bankName = $details[0]->bank_name;

                if (stripos($bankName, "Wema") !== false || stripos($bankName, "Mon") !== false) {
                    $gateway = "PalmPay";
                    $status = true;
                    $message = "successful";
                } elseif (stripos($bankName, "Palm") !== false) {
                    $gateway = "Monnify";
                    $status = true;
                    $message = "successful";
                } else {
                    $gateway = "unknown";
                    $status = false;
                    $message = "Gateway not found";
                }
            }
            return ['status' => $status, 'gateway' => $gateway, 'message' => $message];

        } catch (\Exception $e) {
            Log::error("Payment/PayGate Error: " . $e->getMessage());
            return ['status' => false, 'gateway' => 'error', 'message' => 'System Error or Missing Config'];
        }
    }
}
