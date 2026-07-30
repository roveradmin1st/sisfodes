<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id('id_profil');
            $table->string('nama_desa', 100)->default('Desa Sidomulyo');
            $table->string('kecamatan', 100)->default('Biru-Biru');
            $table->string('kabupaten', 100)->default('Deli Serdang');
            $table->string('provinsi', 100)->default('Sumatera Utara');
            $table->text('alamat');
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('visi');
            $table->text('misi');
            $table->text('sejarah');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_desa');
    }
};
