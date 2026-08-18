<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('penduduk', 'tahun')) {
            Schema::table('penduduk', function (Blueprint $table) {
                $table->integer('tahun')->nullable()->default(2025)->after('status_penduduk');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('penduduk', 'tahun')) {
            Schema::table('penduduk', function (Blueprint $table) {
                $table->dropColumn('tahun');
            });
        }
    }
};
