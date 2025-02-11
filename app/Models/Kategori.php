<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama'
    ];

    // Relasi dengan DataBarang
    public function dataBarangs()
    {
        return $this->hasMany(DataBarang::class, 'kategori_id');
    }

    public function canBeDeleted(): bool
    {
        return $this->dataBarangs()->doesntExist();
    }
}
