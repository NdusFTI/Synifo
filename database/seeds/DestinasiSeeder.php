<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DestinasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        for ($i = 0; $i < 50; $i++) {
            DB::table('destinasi_wisata')->insert([
                'nama_destinasi' => $faker->city . ' ' . $faker->word,
                'lokasi' => $faker->city,
                'deskripsi' => $faker->sentence(10),
                'kategori' => $faker->randomElement(['Kuil', 'Taman', 'Museum', 'Pantai', 'Gunung']),
                'rating' => $faker->randomFloat(1, 3, 5),
                'gambar_url' => $faker->imageUrl(640, 480, 'nature'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
