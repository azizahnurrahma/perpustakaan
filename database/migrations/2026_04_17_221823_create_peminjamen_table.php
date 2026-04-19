<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Siapa yang pinjam)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Relasi ke Buku (Buku apa yang dipinjam)
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            
            $table->date('tanggal_pinjam')->nullable(); // Diisi pas admin konfirmasi
            $table->date('tanggal_kembali')->nullable(); // Ini jadi jatuh tempo (tgl_pinjam + 4 hari)
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
