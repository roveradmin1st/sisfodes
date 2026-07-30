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
                'kategori' => 'Pendapatan Desa',
                'sub_kategori' => 'Transfer',
                'uraian' => 'Dana Desa',
                'jumlah' => 1415611000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pendapatan',
                'kategori' => 'Pendapatan Desa',
                'sub_kategori' => 'Bagi Hasil',
                'uraian' => 'Bagi Hasil Pajak',
                'jumlah' => 179362000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pendapatan',
                'kategori' => 'Pendapatan Desa',
                'sub_kategori' => 'Alokasi Dana',
                'uraian' => 'Alokasi Dana Desa (ADD)',
                'jumlah' => 586767000,
            ],

            // II. BELANJA DESA
            // A. BIDANG PENYELENGGARAAN PEMERINTAHAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'sub_kategori' => 'Pemerintahan',
                'uraian' => 'Penghasilan Tetap dan Tunjangan',
                'jumlah' => 486300000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'sub_kategori' => 'Pemerintahan',
                'uraian' => 'Jaminan Sosial',
                'jumlah' => 41509812,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'sub_kategori' => 'Pemerintahan',
                'uraian' => 'Operasional Perkantoran',
                'jumlah' => 86391220,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'sub_kategori' => 'Pemerintahan',
                'uraian' => 'Operasional BPD',
                'jumlah' => 5000000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'sub_kategori' => 'Pemerintahan',
                'uraian' => 'Sarana dan Prasarana Perkantoran',
                'jumlah' => 75537113,
            ],

            // B. BIDANG PEMBANGUNAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pembangunan Desa',
                'sub_kategori' => 'Pendidikan',
                'uraian' => 'Sub. Bidang Pendidikan',
                'jumlah' => 18751670,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pembangunan Desa',
                'sub_kategori' => 'Kesehatan',
                'uraian' => 'Sub. Bidang Kesehatan',
                'jumlah' => 216980000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pembangunan Desa',
                'sub_kategori' => 'Pemukiman',
                'uraian' => 'Sub. Bidang Pemukiman Umum dan Penataan Ruang',
                'jumlah' => 383848000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pembangunan Desa',
                'sub_kategori' => 'Pemukiman',
                'uraian' => 'Sub. Bidang Pemukiman',
                'jumlah' => 55912000,
            ],

            // C. BIDANG PEMBINAAN KEMASYARAKATAN
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pembinaan Kemasyarakatan',
                'sub_kategori' => 'Kelembagaan',
                'uraian' => 'Sub. Bidang Kelembagaan',
                'jumlah' => 3000000,
            ],

            // D. BIDANG PEMBERDAYAAN MASYARAKAT
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pemberdayaan Masyarakat',
                'sub_kategori' => 'Kapasitas Perangkat',
                'uraian' => 'Sub. Bidang Peningkatan Kapasitas Perangkat',
                'jumlah' => 200000000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Pemberdayaan Masyarakat',
                'sub_kategori' => 'Perempuan & Keluarga',
                'uraian' => 'Sub. Bidang Kelompok Perempuan dan Keluarga',
                'jumlah' => 198128000,
            ],

            // E. BIDANG PENANGGULANGAN BENCANA DARURAT DAN MENDESAK
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penanggulangan Bencana Darurat dan Mendesak',
                'sub_kategori' => 'Bantuan Sosial',
                'uraian' => 'Bantuan Langsung Tunai (BLT - Desa)',
                'jumlah' => 208800000,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'belanja',
                'kategori' => 'Bidang Penanggulangan Bencana Darurat dan Mendesak',
                'sub_kategori' => 'Bencana',
                'uraian' => 'Penanggulangan Bencana',
                'jumlah' => 720000,
            ],

            // III. PEMBIAYAAN DESA
            [
                'tahun' => '2025',
                'jenis' => 'pembiayaan',
                'kategori' => 'Pembiayaan Desa',
                'sub_kategori' => 'Penerimaan',
                'uraian' => 'Penerimaan Pembiayaan (SiLPA)',
                'jumlah' => 88742815,
            ],
            [
                'tahun' => '2025',
                'jenis' => 'pembiayaan',
                'kategori' => 'Pembiayaan Desa',
                'sub_kategori' => 'Pengeluaran',
                'uraian' => 'Pengeluaran Pembiayaan',
                'jumlah' => 283125000,
            ],
        ];

        foreach ($data as $item) {
            Apbdesa::create($item);
        }
    }
}
