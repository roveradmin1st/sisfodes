<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class PendudukExcelSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '-1'); // Bypass memory limit for huge excel parsing
        $this->command->info('Membaca file Excel Master Penduduk...');
        
        $filePath = 'D:\projek 2026\Data Penduduk Desa Sidomulyo Tahun 2025.xls';
        if (!file_exists($filePath)) {
            $this->command->error("File Excel tidak ditemukan di: $filePath");
            return;
        }

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $i = 0;
        $insertedCount = 0;

        // Kosongkan tabel penduduk
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Penduduk::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Tabel Penduduk berhasil dikosongkan (truncated). Memulai import 7000+ data...');

        $insertData = [];
        $now = now();

        foreach ($worksheet->getRowIterator() as $row) {
            $i++;
            if ($i < 2) continue; // Skip header
            
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $rowArray = [];
            foreach ($cellIterator as $cell) {
                $rowArray[] = $cell->getValue();
            }
            
            // Format Data
            $nik = preg_replace('/[^0-9]/', '', (string)($rowArray[7] ?? ''));
            $nkk = preg_replace('/[^0-9]/', '', (string)($rowArray[4] ?? ''));
            $nama = trim((string)($rowArray[8] ?? ''));
            
            if (empty($nama) || strlen($nik) !== 16 || strlen($nkk) !== 16) {
                continue; 
            }
            
            $alamat = trim(strtoupper((string)($rowArray[3] ?? '')));
            $dusunVal = str_replace('DUSUN ', 'Dusun ', $alamat);
            if (preg_match('/^(?:DUSUN\s+)?([IVX]+)(?:\s+.*)?$/i', $alamat, $matches)) {
                $dusunVal = 'Dusun ' . $matches[1];
            }
            
            $jk = (trim(strtoupper((string)($rowArray[9] ?? ''))) === 'PEREMPUAN') ? 'P' : 'L';
            $isKepala = (stripos((string)($rowArray[10] ?? ''), 'Kepala Keluarga') !== false) ? 1 : 0;
            
            $tanggalLahirRaw = trim((string)($rowArray[12] ?? ''));
            $tanggalLahir = '1980-01-01'; // Default Fallback
            if (preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $tanggalLahirRaw, $matches)) {
                $tanggalLahir = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
            } elseif (is_numeric($tanggalLahirRaw)) {
                try {
                    $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalLahirRaw)->format('Y-m-d');
                } catch (\Exception $e) {}
            }
            
            $insertData[] = [
                'nik' => $nik,
                'no_kk' => $nkk,
                'nama' => $nama,
                'tempat_lahir' => trim((string)($rowArray[11] ?? '')) ?: 'DELI SERDANG',
                'tanggal_lahir' => $tanggalLahir,
                'jenis_kelamin' => $jk,
                'agama' => trim((string)($rowArray[15] ?? '')) ?: 'Islam',
                'pekerjaan' => trim((string)($rowArray[20] ?? '')) ?: 'BELUM/TIDAK BEKERJA',
                'status_perkawinan' => trim((string)($rowArray[14] ?? '')) ?: 'Belum Kawin',
                'kewarganegaraan' => 'WNI',
                'alamat' => $alamat,
                'dusun' => substr($dusunVal, 0, 20), // Prevent constraint error
                'status_penduduk' => 'tetap',
                'is_kepala_keluarga' => $isKepala,
                'created_at' => $now,
                'updated_at' => $now
            ];
            
            $insertedCount++;

            // Chunk insert per 500 rows to optimize speed
            if (count($insertData) >= 500) {
                Penduduk::insertOrIgnore($insertData);
                $insertData = [];
                $this->command->info("Telah memproses $insertedCount data...");
            }
        }

        // Insert remaining rows
        if (count($insertData) > 0) {
            Penduduk::insertOrIgnore($insertData);
        }

        $this->command->info("Selesai! Total $insertedCount data berhasil dimasukkan ke database.");
    }
}
