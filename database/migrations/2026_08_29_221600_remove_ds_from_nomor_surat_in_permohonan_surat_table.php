<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("UPDATE permohonan_surat SET nomor_surat = REPLACE(nomor_surat, '/DS/', '/') WHERE nomor_surat LIKE '%/DS/%';");
        DB::statement("UPDATE permohonan_surat SET nomor_surat = REPLACE(nomor_surat, '/DS', '') WHERE nomor_surat LIKE '%/DS';");
    }

    public function down()
    {
        // No revert needed
    }
};
