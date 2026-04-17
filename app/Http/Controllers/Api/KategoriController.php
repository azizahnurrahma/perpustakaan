<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // 1. Ambil semua daftar kategori
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json([
            'pesan' => 'Daftar kategori berhasil diambil',
            'data' => $kategori
        ], 200);
    }

    // 2. Simpan kategori baru
    public function store(Request $request){
        // Validasi simpel biar nama kategori ngga kosong
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json([
            'pesan' => 'Kategori baru berhasil ditambah!',
            'data' => $kategori
        ], 201);
    }
}
