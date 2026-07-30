<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kritik_saran', function (Blueprint $table) {
            $table->id('id_pesan');
            $table->string('nama_pengirim', 100);
            $table->string('email', 100)->nullable();
            $table->text('isi_pesan');
            $table->enum('status', ['dibaca', 'dibalas'])->default('dibaca');
            $table->text('balasan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kritik_saran');
    }
};
