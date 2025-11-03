<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinasiWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinasi_wisata', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_destinasi');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable();
            $table->float('rating')->nullable();
            $table->string('gambar_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinasi_wisata');
    }
}
