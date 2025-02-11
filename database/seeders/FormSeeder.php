<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FormSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Misalnya, buat data untuk 10 form
        for ($i = 0; $i < 10; $i++) {
            \DB::table('data_barangs')->insert([
                'kode' => $faker->bothify('???###'),  // Contoh kode acak: ABC123
                'foto' => $faker->imageUrl(),  // URL gambar palsu
                'nama' => $faker->word,  // Nama produk
                'merk' => $faker->company,  // Nama merk produk
                'kategori_id' => $faker->numberBetween(1, 5),  // ID kategori antara 1 dan 5
                'spesifikasi' => $faker->sentence,  // Spesifikasi produk
                'keterangan' => $faker->paragraph,  // Keterangan produk
                'harga_terakhir' => $faker->randomFloat(2, 100, 1000),  // Harga antara 100 dan 1000
                'stok_total_baik' => $faker->numberBetween(1, 100),  // Stok total baik
                'stok_total_rusak' => $faker->numberBetween(1, 10),  // Stok total rusak
                'stok_tersedia' => $faker->numberBetween(1, 90),  // Stok tersedia
            ]);
        }
    }
}
