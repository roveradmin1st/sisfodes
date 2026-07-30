<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id('id_perangkat');
            $table->string('nama', 100);
            $table->string('jabatan', 100);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_desa');
    }
};
