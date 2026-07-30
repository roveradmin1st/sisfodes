<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id('id_penduduk');
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama', 20);
            $table->string('pendidikan', 50)->nullable();
            $table->string('pekerjaan', 50)->nullable();
            $table->string('status_perkawinan', 20)->nullable();
            $table->string('kewarganegaraan', 20)->default('WNI');
            $table->text('alamat');
            $table->string('dusun', 100)->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->enum('status_penduduk', ['tetap', 'sementara'])->default('tetap');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penduduk');
    }
};
