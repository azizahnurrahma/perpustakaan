<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    // Mahasiswa ngajuin pinjam
    public function ajukan(Request $request)
    {
        $request->validate([
            'buku_id' => 'required',
        ]);

        $buku = Buku::find($request->buku_id);
        if (!$buku || $buku->stok <= 0) {
            return response()->json(['pesan' => 'Stok buku habis!'], 400);
        }

        $pengajuan = Peminjaman::create([
            'user_id' => $request->user()->id,
            'buku_id' => $request->buku_id,
            'status'  => 'pending',
        ]);

        return response()->json([
            'pesan' => 'Pengajuan berhasil dikirim!',
            'data'  => $pengajuan
        ], 201);
    }

    // Mahasiswa liat riwayat & denda dia sendiri
    public function riwayat(Request $request)
    {
        $riwayat = Peminjaman::with('buku')
            ->where('user_id', $request->user()->id)
            ->get();

        $data = $riwayat->map(function ($item) {
            $denda = 0;
            if ($item->status === 'dipinjam') {
                $tglHarusKembali = Carbon::parse($item->tanggal_kembali);
                $hariIni = Carbon::now();
                if ($hariIni->gt($tglHarusKembali)) {
                    $selisih = $hariIni->diffInDays($tglHarusKembali);
                    $denda = $selisih * 2000;
                }
            }
            return [
                'id_pinjam' => $item->id,
                'judul_buku' => $item->buku->judul,
                'status' => $item->status,
                'tgl_pinjam' => $item->tanggal_pinjam,
                'tgl_kembali' => $item->tanggal_kembali,
                'denda' => "Rp " . number_format($denda, 0, ',', '.')
            ];
        });

        return response()->json(['data' => $data]);
    }
}