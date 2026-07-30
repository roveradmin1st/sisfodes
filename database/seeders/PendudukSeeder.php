<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Penduduk::query()->truncate();
        
        $json = file_get_contents(database_path('seeders/penduduk.json'));
        $data = json_decode($json, true);
        
        $uniqueData = [];
        $seenNiks = [];
        foreach ($data as $row) {
            if (!in_array($row['nik'], $seenNiks)) {
                $seenNiks[] = $row['nik'];
                $row['status_penduduk'] = 'tetap';
                $uniqueData[] = $row;
            }
        }
        
        $chunks = array_chunk($uniqueData, 500);
        foreach ($chunks as $chunk) {
            \App\Models\Penduduk::insert($chunk);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
