<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonan_surat', function (Blueprint $table) {
            $table->date('tanggal_meninggal')->nullable()->after('keperluan');
            $table->string('tempat_meninggal', 255)->nullable()->after('tanggal_meninggal');
        });
    }

    public function down()
    {
        Schema::table('permohonan_surat', function (Blueprint $table) {
            $table->dropColumn(['tanggal_meninggal', 'tempat_meninggal']);
        });
    }
};
