<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;
    
    protected $table = 'pengembalians'; 

    protected $fillable = [
        'no_transaksi',
        'transaksi_keluar_id',
        'id_barang',
        'id_peminjam',
        'kondisi_baik', 
        'kondisi_rusak',
        'jumlah',
        'sisa_pinjam',
        'keterangan',
        'tgl_pengembalian'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'transaksi_keluar_id', 'no_transaksi');
    }

    // Relasi ke DataBarang (jika ada perubahan data barang)
    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_peminjam', 'id');
    }
}
