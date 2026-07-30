<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaBantuanSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\PenerimaBantuan::query()->truncate();
        
        $json = file_get_contents(database_path('seeders/bantuan.json'));
        $data = json_decode($json, true);
        
        foreach ($data as $item) {
            $nik = $item['nik'];
            $nama = $item['nama'];
            $alamat = $item['alamat'] ?? 'Dusun I';
            
            $penduduk = \App\Models\Penduduk::where('nik', $nik)->orWhere('nama', 'like', "%{$nama}%")->first();
            
            if (!$penduduk) {
                // Fallback create penduduk
                $penduduk = \App\Models\Penduduk::create([
                    'nik' => $nik,
                    'no_kk' => '0000000000000000',
                    'nama' => $nama,
                    'tempat_lahir' => 'Sidomulyo',
                    'tanggal_lahir' => '1990-01-01',
                    'jenis_kelamin' => 'L',
                    'agama' => 'Islam',
                    'pendidikan' => '-',
                    'pekerjaan' => '-',
                    'status_perkawinan' => '-',
                    'kewarganegaraan' => 'WNI',
                    'alamat' => $alamat,
                    'dusun' => $alamat,
                    'rt' => '001',
                    'rw' => '001',
                    'status_penduduk' => 'tetap',
                    'is_kepala_keluarga' => false
                ]);
            } else {
                $penduduk->update(['alamat' => $alamat]);
            }
            
            \App\Models\PenerimaBantuan::create([
                'id_penduduk' => $penduduk->id_penduduk,
                'program_bantuan' => 'BLT Dana Desa 2025',
                'keterangan' => 'Penerima Aktif',
                'tanggal_terima' => '2025-01-01',
                'status' => 'Diterima',
            ]);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
