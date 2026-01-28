<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'balance_before',
        'balance_after',
        'reference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
