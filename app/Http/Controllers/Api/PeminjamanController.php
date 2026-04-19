<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // Admin konfirmasi pengambilan buku
    public function konfirmasiAdmin(Request $request, $id)
    {
        // PAGAR: Cek Admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['pesan' => 'Akses Ditolak!'], 403);
        }

        $pinjam = Peminjaman::find($id);
        if (!$pinjam || $pinjam->status !== 'pending') {
            return response()->json(['pesan' => 'Data tidak ditemukan/sudah diproses'], 404);
        }

        $buku = Buku::find($pinjam->buku_id);
        if ($buku->stok <= 0) {
            $pinjam->update(['status' => 'ditolak']);
            return response()->json(['pesan' => 'Stok tiba-tiba habis!'], 400);
        }

        $tglPinjam = Carbon::now();
        $tglKembali = $tglPinjam->copy()->addDays(4);

        $pinjam->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => $tglPinjam,
            'tanggal_kembali' => $tglKembali,
        ]);

        $buku->decrement('stok');

        return response()->json(['pesan' => 'Buku dikonfirmasi oleh Admin!']);
    }
}