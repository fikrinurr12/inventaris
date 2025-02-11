<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    
    protected $table = 'peminjamans'; 

    protected $fillable = [
        'id_peminjam',
        'no_transaksi',
        'tgl_peminjaman', 
        'id_barang',
        'jumlah',
        'sisa_pinjam',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_peminjam', 'id');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'transaksi_keluar_id', 'no_transaksi');
    }
}
