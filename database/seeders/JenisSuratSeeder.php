<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run()
    {
        JenisSurat::query()->delete();

        $jenisSurat = [
            [
                'id_jenis_surat' => 1,
                'nama_surat' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan domisili digunakan untuk menyatakan bahwa seseorang bertempat tinggal di Desa Sidomulyo',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Surat Pengantar Kepala Dusun (jika diperlukan)",
            ],
            [
                'id_jenis_surat' => 2,
                'nama_surat' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan tidak mampu untuk keperluan bantuan sosial, pendidikan, atau kesehatan',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Dokumen Pendukung (foto rumah yang bersangkutan)",
            ],
            [
                'id_jenis_surat' => 3,
                'nama_surat' => 'Surat Keterangan Akte Nikah',
                'deskripsi' => 'Surat yang digunakan sebagai pengantar atau pelengkap administrasi dalam pengurusan akta nikah atau dokumen pernikahan',
                'syarat' => "1. Fotokopi KTP Suami dan Istri\n2. Fotokopi Kartu Keluarga\n3. Fotokopi Buku Nikah\n4. Pas Foto Suami dan Istri",
            ],
            [
                'id_jenis_surat' => 4,
                'nama_surat' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat yang menerangkan bahwa seseorang memiliki atau menjalankan usaha di wilayah Desa Sidomulyo',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Dokumen Pendukung (foto bukti usaha)",
            ],
            [
                'id_jenis_surat' => 5,
                'nama_surat' => 'Surat Keterangan Belum Menikah',
                'deskripsi' => 'Surat keterangan yang menerangkan bahwa seseorang belum pernah menikah untuk pengajuan KPR atau administrasi',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Pas foto terbaru",
            ],
            [
                'id_jenis_surat' => 6,
                'nama_surat' => 'Surat Keterangan Belum Punya Rumah',
                'deskripsi' => 'Surat yang menyatakan bahwa seseorang belum memiliki rumah pribadi untuk pengajuan rumah subsidi',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Dokumen Pendukung (jika diperlukan)",
            ],
            [
                'id_jenis_surat' => 7,
                'nama_surat' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan kematian untuk keperluan administrasi kependudukan dan keluarga',
                'syarat' => "1. Fotokopi KTP Almarhum\n2. Fotokopi Kartu Keluarga\n3. Surat keterangan dari rumah sakit",
            ],
            [
                'id_jenis_surat' => 8,
                'nama_surat' => 'Surat Mandah',
                'deskripsi' => 'Surat yang digunakan sebagai pengantar perpindahan penduduk dari Desa Sidomulyo ke daerah lain',
                'syarat' => "1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Alamat Tujuan Pindah\n4. Surat Pengantar Kepala Dusun",
            ],
        ];

        foreach ($jenisSurat as $item) {
            JenisSurat::create($item);
        }
    }
}
