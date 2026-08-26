<?php

namespace Database\Seeders;

use App\Models\Apbdesa;
use Illuminate\Database\Seeder;

class ApbdesaSeeder extends Seeder
{
    public function run(): void
    {
        Apbdesa::query()->delete();

        $data = [
            // I. PENDAPATAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'pendapatan',
                'kategori' => 'PENDAPATAN DESA',
                'sub_kategori' => 'Transfer / Bagi Hasil',
                'uraian' => 'DANA DESA',
                'jumlah' => 1415611000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pendapatan',
                'kategori' => 'PENDAPATAN DESA',
                'sub_kategori' => 'Transfer / Bagi Hasil',
                'uraian' => 'BAGI HASIL PAJAK',
                'jumlah' => 179361000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pendapatan',
                'kategori' => 'PENDAPATAN DESA',
                'sub_kategori' => 'Transfer / Bagi Hasil',
                'uraian' => 'ALOKASI DANA DESA',
                'jumlah' => 586768000,
            ],

            // II. BELANJA DESA
            // A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'sub_kategori' => 'A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'uraian' => 'Penghasilan Tetap dan Tunjangan',
                'jumlah' => 486300000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'sub_kategori' => 'A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'uraian' => 'Jaminan Sosial',
                'jumlah' => 41509812,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'sub_kategori' => 'A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'uraian' => 'Operasional Perkantoran',
                'jumlah' => 86391220,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'sub_kategori' => 'A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'uraian' => 'Operasional BPD',
                'jumlah' => 5000000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'sub_kategori' => 'A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA',
                'uraian' => 'Sarana dan Prasarana Perkantoran',
                'jumlah' => 75537113,
            ],

            // B. BIDANG PEMBANGUNAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBANGUNAN DESA',
                'sub_kategori' => 'B. BIDANG PEMBANGUNAN DESA',
                'uraian' => 'Sub. Bidang Pendidikan',
                'jumlah' => 18751670,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBANGUNAN DESA',
                'sub_kategori' => 'B. BIDANG PEMBANGUNAN DESA',
                'uraian' => 'Sub. Bidang Kesehatan',
                'jumlah' => 216980000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBANGUNAN DESA',
                'sub_kategori' => 'B. BIDANG PEMBANGUNAN DESA',
                'uraian' => 'Sub. Bidang Pemukiman Umum dan Penataan Ruang',
                'jumlah' => 383848000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBANGUNAN DESA',
                'sub_kategori' => 'B. BIDANG PEMBANGUNAN DESA',
                'uraian' => 'Sub. Bidang Pemukiman',
                'jumlah' => 55912000,
            ],

            // C. BIDANG PEMBINAAN KEMASYARAKATAN
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBINAAN KEMASYARAKATAN',
                'sub_kategori' => 'C. BIDANG PEMBINAAN KEMASYARAKATAN',
                'uraian' => 'Sub. Bidang Kelembagaan',
                'jumlah' => 3000000,
            ],

            // D. BIDANG PEMBERDAYAAN MASYARAKAT
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBERDAYAAN MASYARAKAT',
                'sub_kategori' => 'D. BIDANG PEMBERDAYAAN MASYARAKAT',
                'uraian' => 'Sub. Bidang Peningkatan Kapasitas Perangkat',
                'jumlah' => 200000000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PEMBERDAYAAN MASYARAKAT',
                'sub_kategori' => 'D. BIDANG PEMBERDAYAAN MASYARAKAT',
                'uraian' => 'Sub. Bidang Kelompok Perempuan dan Keluarga',
                'jumlah' => 198128000,
            ],

            // E. BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK',
                'sub_kategori' => 'E. BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK',
                'uraian' => 'Bantuan Langsung Tunai (BLT - Desa)',
                'jumlah' => 208800000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK',
                'sub_kategori' => 'E. BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK',
                'uraian' => 'Penanggulangan Bencana',
                'jumlah' => 7200000,
            ],

            // III. PEMBIAYAAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'pembiayaan',
                'kategori' => 'PEMBIAYAAN DESA',
                'sub_kategori' => 'Penerimaan Pembiayaan',
                'uraian' => 'Penerimaan Pembiayaan',
                'jumlah' => 88742815,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pembiayaan',
                'kategori' => 'PEMBIAYAAN DESA',
                'sub_kategori' => 'Pengeluaran Pembiayaan',
                'uraian' => 'Pengeluaran Pembiayaan',
                'jumlah' => 283125000,
            ],
        ];

        foreach ($data as $item) {
            Apbdesa::create($item);
        }
    }
}
