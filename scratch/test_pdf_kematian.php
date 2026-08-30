<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PermohonanSurat;
use App\Models\JenisSurat;
use App\Models\Penduduk;

$jenisKematian = JenisSurat::where('nama_surat', 'LIKE', '%kematian%')->first();
$penduduk = Penduduk::first();

if ($jenisKematian && $penduduk) {
    $permohonan = PermohonanSurat::firstOrNew(['id_jenis_surat' => $jenisKematian->id_jenis_surat]);
    $permohonan->id_penduduk = $penduduk->id_penduduk;
    $permohonan->id_jenis_surat = $jenisKematian->id_jenis_surat;
    $permohonan->tanggal_pengajuan = now();
    $permohonan->keperluan = 'Persyaratan Administrasi';
    $permohonan->tanggal_meninggal = '2026-08-15';
    $permohonan->tempat_meninggal = 'Rumah Duka Desa Sidomulyo';
    $permohonan->nomor_surat = '474.3/001/VIII/2026';
    $permohonan->save();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.templates.cetak_pdf', compact('permohonan'));
    $output = $pdf->output();

    echo "PDF Generated Successfully! Size: " . strlen($output) . " bytes\n";
} else {
    echo "Jenis Surat Kematian / Penduduk not found.\n";
}
