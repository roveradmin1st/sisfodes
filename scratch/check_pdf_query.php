<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Penduduk;

$query = Penduduk::selectRaw("
    COALESCE(tahun, YEAR(created_at), 2025) as tahun_rekap,
    COUNT(*) as total_penduduk,
    SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) as total_l,
    SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) as total_p,
    SUM(CASE WHEN is_kepala_keluarga = 1 AND jenis_kelamin = 'L' THEN 1 ELSE 0 END) as kk_l,
    SUM(CASE WHEN is_kepala_keluarga = 1 AND jenis_kelamin = 'P' THEN 1 ELSE 0 END) as kk_p,
    SUM(CASE WHEN is_kepala_keluarga = 1 THEN 1 ELSE 0 END) as total_kk
")
->groupByRaw("COALESCE(tahun, YEAR(created_at), 2025)")
->orderByRaw("COALESCE(tahun, YEAR(created_at), 2025) ASC");

$rekapData = $query->get();

echo "=== REKAP DATA PDF ===\n";
foreach($rekapData as $item) {
    echo "Tahun: " . $item->tahun_rekap . " | Total: " . $item->total_penduduk . " | L: " . $item->total_l . " | P: " . $item->total_p . " | KK: " . $item->total_kk . "\n";
}

echo "Grand Total: " . $rekapData->sum('total_penduduk') . "\n";
