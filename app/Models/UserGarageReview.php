<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGarageReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'garage_id',
        'rate',
        'comment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class);
    }
}
