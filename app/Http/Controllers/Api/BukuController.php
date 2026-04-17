<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku; //import model buku
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // fungsi buat ngeliat semua daftar buku
    public function index(){
        $semuaBuku = Buku::all();
        // Cek apakah variabel $semuaBuku isinya kosong
        if ($semuaBuku->isEmpty()) {
            return response()->json([
                'pesan' => 'Tidak ada buku yang tersedia',
                'data' => [] // array 
            ], 200);
        }

        return response()->json([
            'pesan' => 'Daftar buku berhasil diambil',
            'data' => $semuaBuku
        ], 200);
    }

    // fungsi buat nambah buku baru
    public function store(Request $request){
        $bukuBaru = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
        ]);

        return response()->json([
            'pesan' => 'Buku berhasil ditambahkan',
            'data' => $bukuBaru
        ],201);
    }

    // fungsi untuk mengedit data buku
    public function update(Request $request, $id)
    {
        // Paksa request dianggap sebagai JSON
        $request->headers->set('Accept', 'application/json');

        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['pesan' => 'Buku tidak ada'], 404);
        }

        $buku->update($request->all());

        return response()->json([
            'pesan' => 'Buku berhasil diupdate!',
            'data' => $buku
        ], 200);
    }

    // Fungsi untuk menghapus buku
    public function destroy($id){
        $buku = Buku::find($id);

        if (!$buku){
            return response()->json(['pesan' => 'Gagal menghapus! Buku tidak ditemukan :) ']);
        }
        $buku->delete();
        return response()->json([
            'pesan' => 'Buku berhasil dihapus!!'
        ], 200);
    }

}
