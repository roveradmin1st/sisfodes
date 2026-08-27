<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->string('hubungan_keluarga', 50)->nullable()->after('is_kepala_keluarga');
        });
    }

    public function down()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn('hubungan_keluarga');
        });
    }
};
