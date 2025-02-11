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
        Schema::create('data_barangs', function (Blueprint $table) {
            $table->id(); // Defaultnya adalah unsignedBigInteger
            $table->string('kode')->unique();
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->string('merk');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->text('spesifikasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('harga_terakhir');
            $table->integer('stok_total_baik')->default(0);
            $table->integer('stok_total_rusak')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_barangs');
    }
};
