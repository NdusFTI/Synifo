<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinasiWisata extends Model
{
    protected $table = "destinasi_wisata";

    protected $fillable = [
        'nama_destinasi',
        'lokasi',
        'deskripsi',
        'kategori',
        'rating',
        'gambar_url',
    ];
}
