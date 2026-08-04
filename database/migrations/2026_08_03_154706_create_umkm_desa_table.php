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
        Schema::create('umkm_desa', function (Blueprint $table) {
            $table->id('id_umkm');
            $table->string('nama_usaha', 150);
            $table->string('pemilik', 100);
            $table->string('kategori', 50)->default('Kuliner');
            $table->text('deskripsi')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('harga', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['publish', 'draft'])->default('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_desa');
    }
};
