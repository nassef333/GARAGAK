<?php

use App\Http\Controllers\API\Auth\OTPController;
use App\Http\Controllers\API\Auth\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::controller(OTPController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("generate-email-otp", 'generateEmailOTP')->name("generate.email.otp");
        Route::post("validate-email-otp", 'validateEmailOTP')->name("validate.email.otp");
    });
});


Route::controller(PasswordResetController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post("generate-password-otp", 'generatePasswordOTP')->name("generate.password.otp");
        Route::post("validate-password-otp", 'validatePasswordOTP')->name("validate.password.otp");
        Route::post("reset-password", 'resetPassword')->name("reset.password.otp");
    });
});
