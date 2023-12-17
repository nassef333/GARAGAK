<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'no_hours',
        'hour_price',
    ];

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class);
    }

}
