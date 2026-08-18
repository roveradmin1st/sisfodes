<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\JenisSurat;
use App\Models\PermohonanSurat;
use Illuminate\Database\Seeder;

class PermohonanSuratSeeder extends Seeder
{
    public function run()
    {
        // Ambil beberapa data penduduk
        $pendudukList = Penduduk::limit(15)->get();
        $jenisSuratList = JenisSurat::all();

        if ($pendudukList->isEmpty() || $jenisSuratList->isEmpty()) {
            return;
        }

        $keperluanList = [
            'Untuk keperluan kelengkapan dokumen administrasi pekerjaan',
            'Pengajuan beasiswa kuliah di perguruan tinggi',
            'Persyaratan pendaftaran bantuan sosial pemerintah',
            'Persyaratan permohonan pinjaman modal usaha kecil',
            'Kelengkapan pengajuan Kredit Kepemilikan Rumah (KPR)',
            'Administrasi pengurusan akta nikah di KUA',
            'Pengurusan pembuatan SKCK di Polsek / Polres',
            'Pengurusan pembuatan paspor dan izin perjalanan',
            'Persyaratan klaim asuransi kesehatan BPJS',
            'Perpindahan domisili ke tempat kediaman baru',
        ];

        $statuses = ['selesai', 'diproses', 'menunggu', 'selesai', 'ditolak'];

        foreach ($pendudukList as $index => $penduduk) {
            $jenisSurat = $jenisSuratList->random();
            $status = $statuses[$index % count($statuses)];
            $keperluan = $keperluanList[$index % count($keperluanList)];

            PermohonanSurat::create([
                'id_penduduk' => $penduduk->id_penduduk,
                'id_jenis_surat' => $jenisSurat->id_jenis_surat,
                'tanggal_pengajuan' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'keperluan' => $keperluan,
                'status_permohonan' => $status,
                'catatan' => $status == 'ditolak' ? 'Dokumen persyaratan kurang lengkap (Fotokopi KK belum dilampirkan)' : ($status == 'selesai' ? 'Surat telah selesai diproses dan disetujui' : 'Dalam proses verifikasi berkas oleh Kaur Umum'),
            ]);
        }
    }
}
