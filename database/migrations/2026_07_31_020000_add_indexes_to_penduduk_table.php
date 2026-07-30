<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->index('no_kk');
            $table->index('dusun');
            $table->index('jenis_kelamin');
            $table->index('agama');
            $table->index('pekerjaan');
            $table->index('pendidikan');
            $table->index('status_penduduk');
            $table->index('status_perkawinan');
        });
    }

    public function down()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropIndex(['no_kk']);
            $table->dropIndex(['dusun']);
            $table->dropIndex(['jenis_kelamin']);
            $table->dropIndex(['agama']);
            $table->dropIndex(['pekerjaan']);
            $table->dropIndex(['pendidikan']);
            $table->dropIndex(['status_penduduk']);
            $table->dropIndex(['status_perkawinan']);
        });
    }
};
