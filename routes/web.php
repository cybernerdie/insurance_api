<?php

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\QuotationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/register', RegisterController::class)->name('register');
Route::get('/login', LoginController::class)->name('login');
Route::get('/quotation', QuotationController::class)->name('quotation');
