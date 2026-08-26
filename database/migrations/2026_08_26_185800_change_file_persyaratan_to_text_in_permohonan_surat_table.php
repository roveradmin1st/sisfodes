<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE permohonan_surat MODIFY file_persyaratan TEXT NULL;');
    }

    public function down()
    {
        DB::statement('ALTER TABLE permohonan_surat MODIFY file_persyaratan VARCHAR(255) NULL;');
    }
};
