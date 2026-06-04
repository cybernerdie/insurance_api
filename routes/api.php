<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\QuotationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', RegisterController::class)->name('auth.register');
    Route::post('/login', LoginController::class)->name('auth.login');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', LogoutController::class)->middleware('throttle:10,1')->name('auth.logout');
    Route::post('/quotation', QuotationController::class)->middleware('throttle:5,1')->name('quotation.store');
});
