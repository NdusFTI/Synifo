<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DestinasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namaDestinasi = [
            'Senso-ji Temple', 'Fushimi Inari Taisha', 'Kinkaku-ji Temple', 'Tokyo Tower',
            'Mount Fuji', 'Arashiyama Bamboo Grove', 'Shibuya Crossing', 'Osaka Castle',
            'Nara Park', 'Himeji Castle', 'Todai-ji Temple', 'Meiji Shrine',
            'Kiyomizu-dera Temple', 'Hakone Hot Springs', 'Gion District', 'Nikko Toshogu Shrine',
            'Kamakura Great Buddha', 'Miyajima Island', 'Tokyo Skytree', 'Takayama Old Town',
            'Kenroku-en Garden', 'Shinjuku Gyoen', 'Ueno Park', 'Kyoto Imperial Palace',
            'Nagoya Castle', 'Sapporo Snow Festival Site', 'Okinawa Churaumi Aquarium',
            'Tsukiji Outer Market', 'Akihabara District', 'Yokohama Chinatown',
            'Kumamoto Castle', 'Matsumoto Castle', 'Kanazawa Castle', 'Hiroshima Peace Memorial',
            'Itsukushima Shrine', 'Ryoan-ji Temple', 'Byodo-in Temple', 'Katsura Imperial Villa',
            'Harajuku District', 'Roppongi Hills', 'Odaiba Seaside Park', 'Enoshima Island',
            'Lake Kawaguchi', 'Jigokudani Monkey Park', 'Shirakawa-go Village', 'Takao Mountain',
            'Kamikochi Valley', 'Aso Volcano', 'Daisetsuzan National Park', 'Oirase Stream'
        ];

        $lokasi = [
            'Tokyo', 'Kyoto', 'Osaka', 'Nara', 'Hiroshima', 'Hokkaido', 'Yokohama',
            'Nagoya', 'Fukuoka', 'Sapporo', 'Kobe', 'Kanazawa', 'Takayama', 'Nikko',
            'Kamakura', 'Hakone', 'Okinawa', 'Miyajima', 'Gifu', 'Matsumoto'
        ];

        $deskripsiTemplates = [
            'Destinasi wisata yang sangat populer di Jepang dengan pemandangan yang menakjubkan dan nilai sejarah yang tinggi.',
            'Tempat yang sempurna untuk merasakan budaya Jepang tradisional dengan arsitektur klasik yang memukau.',
            'Salah satu landmark paling ikonik dengan jutaan pengunjung setiap tahunnya dari seluruh dunia.',
            'Spot foto Instagram yang terkenal dengan keindahan alam dan suasana yang damai.',
            'Warisan budaya dunia UNESCO yang wajib dikunjungi saat berada di Jepang.',
            'Destinasi favorit wisatawan dengan fasilitas lengkap dan akses transportasi yang mudah.',
            'Tempat yang menawarkan pengalaman unik dengan pemandangan musiman yang berbeda sepanjang tahun.',
            'Lokasi bersejarah yang memiliki cerita menarik dan arsitektur Jepang yang autentik.',
            'Destinasi alam yang menawarkan ketenangan dan kesempatan untuk menikmati keindahan Jepang.',
            'Pusat aktivitas budaya dengan berbagai atraksi dan acara tradisional yang menarik.'
        ];

        $kategori = ['Kuil', 'Taman', 'Museum', 'Pantai', 'Gunung', 'Kastil', 'Distrik', 'Pulau', 'Onsen', 'Kuil'];

        $faker = Faker::create('id_ID');

        shuffle($namaDestinasi);

        for ($i = 0; $i < 50; $i++) {
            $nama = $i < count($namaDestinasi) 
                ? $namaDestinasi[$i] 
                : $faker->randomElement($namaDestinasi);

            DB::table('destinasi_wisata')->insert([
                'nama_destinasi' => $nama,
                'lokasi' => $faker->randomElement($lokasi),
                'deskripsi' => $faker->randomElement($deskripsiTemplates) . ' ' . $faker->sentence(8),
                'kategori' => $faker->randomElement($kategori),
                'rating' => $faker->randomFloat(1, 3.5, 5),
                'gambar_url' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
