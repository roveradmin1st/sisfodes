<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            $table->string('luas_wilayah')->nullable()->after('alamat');
            $table->string('map')->nullable()->after('logo');
        });
    }

    public function down()
    {
        Schema::table('profil_desa', function (Blueprint $table) {
            $table->dropColumn(['luas_wilayah', 'map']);
        });
    }
};