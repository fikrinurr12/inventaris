<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration
{
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama')->unique(); // Nama kategori
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('data_barangs', function (Blueprint $table) {
            if (!Schema::hasColumn('data_barangs', 'kategori')) {
                $table->string('kategori')->after('merk'); // Tambahkan kembali kolom kategori
            }
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::dropIfExists('kategoris');
    }
}
