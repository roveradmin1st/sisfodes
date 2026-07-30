<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id('id_jenis_surat');
            $table->string('nama_surat', 200);
            $table->text('deskripsi');
            $table->text('syarat');
            $table->string('template_surat')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_surat');
    }
};
