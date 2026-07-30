<?php

namespace Database\Seeders;

use App\Models\InformasiDesa;
use Illuminate\Database\Seeder;

class InformasiDesaSeeder extends Seeder
{
    public function run(): void
    {
        InformasiDesa::query()->delete();

        $data = [
            [
                'judul' => 'Penyaluran BLT Dana Desa Tahun 2025 Desa Sidomulyo',
                'kategori' => 'berita',
                'isi' => 'Pemerintah Desa Sidomulyo Kecamatan Biru-Biru telah secara resmi menyalurkan Bantuan Langsung Tunai (BLT) Dana Desa Tahun 2025 kepada 58 Keluarga Penerima Manfaat (KPM). Penyaluran dilakukan secara transparan di Balai Desa Sidomulyo dipimpin oleh Kepala Desa Satriawan.',
                'waktu_pelaksanaan' => null,
                'gambar' => null,
                'tanggal_posting' => '2025-03-10',
                'penulis' => 'Kaur Umum',
                'status_publish' => 'publish',
            ],
            [
                'judul' => 'Gotong Royong Kebersihan Lingkungan dan Saluran Air',
                'kategori' => 'berita',
                'isi' => 'Masyarakat Desa Sidomulyo bersama Perangkat Desa melaksanakan kegiatan gotong royong kebersihan lingkungan di wilayah Dusun I hingga Dusun VI guna mengantisipasi genangan air pada musim penghujan.',
                'waktu_pelaksanaan' => null,
                'gambar' => null,
                'tanggal_posting' => '2025-02-15',
                'penulis' => 'Kaur Umum',
                'status_publish' => 'publish',
            ],
            [
                'judul' => 'Pengumuman Pelayanan Administrasi Surat Keterangan Online',
                'kategori' => 'pengumuman',
                'isi' => 'Diberitahukan kepada seluruh warga Desa Sidomulyo bahwa pengurusan Surat Keterangan (Domisili, SKTM, Usaha, Akte Nikah, Belum Menikah, Belum Punya Rumah, Kematian, dan Mandah) kini dapat diajukan secara online melalui Sistem Informasi Desa Sidomulyo.',
                'waktu_pelaksanaan' => null,
                'gambar' => null,
                'tanggal_posting' => '2025-03-01',
                'penulis' => 'Kaur Umum',
                'status_publish' => 'publish',
            ],
            [
                'judul' => 'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) 2025',
                'kategori' => 'agenda',
                'isi' => 'Agenda kegiatan Musrenbangdes Sidomulyo dalam rangka penyusunan rencana kerja pembangunan desa dan penetapan prioritas anggaran tahun mendatang.',
                'waktu_pelaksanaan' => '2025-04-05 09:00:00',
                'gambar' => null,
                'tanggal_posting' => '2025-03-20',
                'penulis' => 'Kaur Umum',
                'status_publish' => 'publish',
            ],
            [
                'judul' => 'Dokumentasi Kantor dan Pelayanan Desa Sidomulyo',
                'kategori' => 'galeri',
                'isi' => 'Dokumentasi suasana kantor dan kegiatan pelayanan administrasi di Kantor Kepala Desa Sidomulyo Kecamatan Biru-Biru.',
                'waktu_pelaksanaan' => null,
                'gambar' => 'profil/kantor-desa.jpeg',
                'tanggal_posting' => '2025-01-01',
                'penulis' => 'Kaur Umum',
                'status_publish' => 'publish',
            ],
        ];

        foreach ($data as $item) {
            InformasiDesa::create($item);
        }
    }
}
