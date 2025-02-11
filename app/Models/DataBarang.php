<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataBarang extends Model
{
    use HasFactory;

    protected $table = 'data_barangs';

    protected $fillable = [
        'kode', 
        'foto', 
        'nama', 
        'merk', 
        'kategori_id', 
        'spesifikasi', 
        'keterangan', 
        'harga_terakhir', 
        'stok_total_baik', 
        'stok_total_rusak', 
        'stok_tersedia',
    ];

    protected $casts = [
        'harga_terakhir' => 'decimal:2',
        'stok_total_baik' => 'integer',
        'stok_total_rusak' => 'integer',
        'stok_tersedia' => 'integer',
    ];

    public $timestamps = true; // Pastikan timestamps aktif

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_barang', 'id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_barang', 'id');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_barang', 'id');
    }

    public function penyesuaian_stok()
    {
        return $this->hasMany(PenyesuaianStok::class, 'id_barang', 'id');
    }

    public function canBeDeleted(): bool
    {
        return !$this->pembelian()->exists() &&
            !$this->peminjaman()->exists() &&
            !$this->pengembalian()->exists() &&
            !$this->penyesuaian_stok()->exists();
    }

}
