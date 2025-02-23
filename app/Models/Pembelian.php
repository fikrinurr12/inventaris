<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;
    
    protected $table = 'pembelians';

    protected $fillable = [
        'no_transaksi', 
        'id_barang',
        'tgl_transaksi', 
        'no_invoice',
        'jumlah', 
        'harga', 
        'keterangan',
        'supplier_id'
    ];

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'id_barang', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
