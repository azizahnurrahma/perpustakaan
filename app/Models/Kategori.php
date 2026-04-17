<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Tambahkan ini biar bisa input data lewat Postman
    protected $fillable = ['nama_kategori'];

    // Relasi ke Buku (Satu kategori punya banyak buku)
    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
