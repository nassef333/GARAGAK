<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'governate',
        'number_of_slots',
        'available_slots',
        'rate',
        'no_reviews',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function userReviews(): HasMany
    {
        return $this->hasMany(UserGarageReview::class);
    }

    public function transaction():HasOne
    {
        return $this->hasOne(Transaction::class);
    }

}
