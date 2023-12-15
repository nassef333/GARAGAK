<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'total_price',
        'merchantRefNumber',
        'merchantNumber',
        'payment_expiry',
        'status',
        'paid_at',
        'payment_method',
        'customer_profile_id',
        'signature',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
