<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_surat', function (Blueprint $table) {
            $table->id('id_permohonan');
            $table->foreignId('id_penduduk')->constrained('penduduk', 'id_penduduk')->onDelete('cascade');
            $table->foreignId('id_jenis_surat')->constrained('jenis_surat', 'id_jenis_surat')->onDelete('cascade');
            $table->date('tanggal_pengajuan');
            $table->text('keperluan');
            $table->string('file_persyaratan')->nullable();
            $table->string('file_surat_scan')->nullable();
            $table->enum('status_permohonan', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_surat');
    }
};
