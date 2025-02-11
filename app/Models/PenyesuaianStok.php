<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianStok extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_stok';

    protected $fillable = [
        'no_transaksi',
        'id_barang',
        'stok_total_baik',
        'stok_total_rusak',
        'stok_tersedia',
        'keterangan',
    ];

    /**
     * Relasi ke model DataBarang berdasarkan kode_barang
     */
    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }
}
