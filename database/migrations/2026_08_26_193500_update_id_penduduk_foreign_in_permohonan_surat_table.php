<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ubah kolom id_penduduk menjadi NULL dan constraint ON DELETE SET NULL
        DB::statement('ALTER TABLE permohonan_surat MODIFY id_penduduk BIGINT UNSIGNED NULL;');
        
        try {
            DB::statement('ALTER TABLE permohonan_surat DROP FOREIGN KEY permohonan_surat_id_penduduk_foreign;');
        } catch (\Exception $e) {
            // Ignore if foreign key name is different
        }

        try {
            DB::statement('ALTER TABLE permohonan_surat ADD CONSTRAINT permohonan_surat_id_penduduk_foreign FOREIGN KEY (id_penduduk) REFERENCES penduduk(id_penduduk) ON DELETE SET NULL;');
        } catch (\Exception $e) {
            // Ignore if already set
        }
    }

    public function down()
    {
        // Revert
    }
};
