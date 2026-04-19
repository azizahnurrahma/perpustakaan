<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PengajuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PeminjamanController;
use Symfony\Component\Routing\Route as RoutingRoute;

// 1. Route Public (Bisa diakses tanpa login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Route Protected (Harus Login / Pakai Token)

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- AKSES BUKU ---
    Route::get('/buku', [BukuController::class, 'index']); // Mahasiswa & Admin (Bisa liat daftar)
    Route::post('/buku', [BukuController::class, 'store']); // Kita pagar di Controller
    Route::post('/buku/update/{id}', [BukuController::class, 'update']); // Kita pagar di Controller
    Route::delete('/buku/{id}', [BukuController::class, 'destroy']); // Kita pagar di Controller

    // --- AKSES KATEGORI ---
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/kategori', [KategoriController::class, 'store']);

    // --- HAK AKSES MAHASISWA (PengajuanController) ---
    Route::post('/pengajuan/pinjam', [PengajuanController::class, 'ajukan']);
    Route::get('/pengajuan/riwayat', [PengajuanController::class, 'riwayat']);

    // --- HAK AKSES ADMIN (PeminjamanController) ---
    Route::put('/peminjaman/konfirmasi/{id}', [PeminjamanController::class, 'konfirmasiAdmin']);
});