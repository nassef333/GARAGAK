<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->as('admin.')->controller(AuthController::class)->group(function () {
    //Auth Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("user", 'user')->name("user");
        Route::post("logout", 'logout')->name("logout");
    });
    //Guest Routes
    Route::middleware('guest')->group(function () {
        Route::post("login", 'login')->name("login");
        Route::post("register", 'register')->name("register");
    });
});


Route::controller(AuthController::class)->group(function () {
    //Auth Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post("user", 'user')->name("user");
        Route::post("logout", 'logout')->name("logout");
    });
    //Guest Routes
    Route::middleware('guest')->group(function () {
        Route::post("login", 'login')->name("login");
        Route::post("register", 'register')->name("register");
    });
});

Route::controller(ProfileController::class)->group(function () {
    //Auth Routes
    Route::middleware('auth:sanctum')->prefix('profile')->as('profile.')->group(function () {
        Route::post("upload-image", 'updateImage')->name("upload.image");
        Route::post("update", 'update')->name("update");
        Route::get("show", 'show')->name("show");
    });
});
