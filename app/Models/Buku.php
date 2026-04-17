<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // ngasih tau laravel nama tabelnya buku
    protected $table = 'buku';

    // kolom yang boleh diisi
    protected $fillable = ['judul', 'penulis', 'deskripsi', 'stok'];
}
