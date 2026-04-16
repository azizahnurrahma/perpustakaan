<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Jalur untuk Daftar Akun
Route::post('/register', [AuthController::class, 'register']);

// Jalur untuk Masuk
Route::post('/login', [AuthController::class, 'login']);