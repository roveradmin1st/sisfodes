<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->boolean('is_kepala_keluarga')->default(false)->after('status_penduduk');
        });
    }

    public function down()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn('is_kepala_keluarga');
        });
    }
};