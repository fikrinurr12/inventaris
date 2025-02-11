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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi');
            $table->string('transaksi_keluar_id');
            $table->foreignId('id_barang')->constrained('data_barangs')->onDelete('cascade');
            $table->foreignId('id_peminjam')->constrained('users')->onDelete('cascade');
            $table->integer('kondisi_baik')->default(0); // Jumlah barang yang dikembalikan dalam kondisi baik
            $table->integer('kondisi_rusak')->default(0); // Jumlah barang yang dikembalikan dalam kondisi rusak
            $table->integer('jumlah'); // Jumlah total barang yang dikembalikan
            $table->integer('sisa_pinjam')->default(0);
            $table->string('keterangan');
            $table->date('tgl_pengembalian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
