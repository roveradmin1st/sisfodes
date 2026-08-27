<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Penduduk;

echo "=== CARDS CALCULATION TEST ===\n";

$query = Penduduk::query();

echo "Base Penduduk::query()->count(): " . (clone $query)->count() . "\n";
echo "Base Kepala Keluarga: " . (clone $query)->where('is_kepala_keluarga', 1)->count() . "\n";
echo "Base Penduduk Baru (whereMonth created_at = " . now()->month . "): " . (clone $query)->whereMonth('created_at', now()->month)->count() . "\n";
echo "Base Penduduk Lansia (tanggal_lahir <= " . now()->subYears(60)->format('Y-m-d') . "): " . (clone $query)->where('tanggal_lahir', '<=', now()->subYears(60))->count() . "\n";

// Check created_at months of records in DB
$months = Penduduk::selectRaw("MONTH(created_at) as m, COUNT(*) as cnt")->groupByRaw("MONTH(created_at)")->get();
echo "\nCreated_at Months in DB:\n";
foreach($months as $m) {
    echo "Month: {$m->m} | Count: {$m->cnt}\n";
}

// Check tanggal_lahir values in DB
$lansiaCount = Penduduk::whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60")->count();
echo "\nLansia Count (TIMESTAMPDIFF >= 60): {$lansiaCount}\n";

$kkCount = Penduduk::where('is_kepala_keluarga', 1)->count();
echo "KK Count (is_kepala_keluarga = 1): {$kkCount}\n";
