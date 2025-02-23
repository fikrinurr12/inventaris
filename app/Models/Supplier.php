<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'nama',
        'no_telepon',
        'alamat'
    ];

    // Relasi dengan pembelians
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id', 'id');
    }

    public function canBeDeleted(): bool
    {
        return $this->pembelians()->doesntExist();
    }
}
