<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apbdesa', function (Blueprint $table) {
            $table->id('id_apbdesa');
            $table->string('tahun', 4)->default('2025');
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan']);
            $table->string('kategori', 100);
            $table->string('sub_kategori', 150)->nullable();
            $table->string('uraian', 200);
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbdesa');
    }
};
