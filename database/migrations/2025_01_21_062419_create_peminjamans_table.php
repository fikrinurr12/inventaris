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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id(); // Ini akan menghasilkan unsignedBigInteger
            $table->foreignId('id_peminjam')->constrained('users')->onDelete('cascade');
            $table->string('no_transaksi')->unique();
            $table->date('tgl_peminjaman');
            $table->foreignId('id_barang')->constrained('data_barangs')->onDelete('cascade');
            $table->integer('jumlah');
            $table->integer('sisa_pinjam');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
