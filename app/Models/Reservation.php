<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'car_user_id',
        'slot_id',
        'entered_at',
        'leaved_at',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
