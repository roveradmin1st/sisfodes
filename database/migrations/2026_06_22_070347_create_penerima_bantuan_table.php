<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penerima_bantuan', function (Blueprint $table) {
            $table->id('id_penerima');
            $table->foreignId('id_penduduk')->constrained('penduduk', 'id_penduduk')->onDelete('cascade');
            $table->string('program_bantuan', 100);
            $table->string('keterangan', 150)->nullable();
            $table->date('tanggal_terima');
            $table->enum('status', ['diterima', 'dialihkan'])->default('diterima');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};
