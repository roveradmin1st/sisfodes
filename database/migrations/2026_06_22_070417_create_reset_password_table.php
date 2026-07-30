<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reset_password', function (Blueprint $table) {
            $table->id('id_reset');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('email', 100);
            $table->string('token', 225);
            $table->datetime('expired_at');
            $table->enum('status', ['pending', 'used'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reset_password');
    }
};
