<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as RoutingRoute;

// Jalur untuk Daftar Akun
Route::post('/register', [AuthController::class, 'register']);

// Jalur untuk Masuk
Route::post('/login', [AuthController::class, 'login']);

// jalur untuk buku
Route::get('/buku',[BukuController::class, 'index']); // untuk liaat semua daftar buku
Route::post('/buku', [BukuController::class, 'store']); //untuk tambah buku baru
    // jalur edit (pake put) dan hapus (pake delete)
    Route::post('/buku/update/{id}', [BukuController::class, 'update']);
    Route::delete('/buku/{id}', [BukuController::class, 'destroy']);