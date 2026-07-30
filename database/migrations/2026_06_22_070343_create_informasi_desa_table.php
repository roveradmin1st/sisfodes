<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('informasi_desa', function (Blueprint $table) {
            $table->id('id_informasi');
            $table->string('judul', 200);
            $table->enum('kategori', ['berita', 'pengumuman', 'agenda', 'galeri']);
            $table->text('isi');
            $table->dateTime('waktu_pelaksanaan')->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggal_posting');
            $table->string('penulis', 100);
            $table->enum('status_publish', ['publish', 'draft'])->default('publish');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informasi_desa');
    }
};
