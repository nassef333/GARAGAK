<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordOTP extends Model
{
    use HasFactory;

    protected $table = 'password_otp';

    protected $fillable = [
        'identifier',
        'otp',
        'expire_at',
        'valid',
    ];
}
