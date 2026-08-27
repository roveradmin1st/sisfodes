<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Penduduk;

echo "=== CHECK PENDUDUK DATABASE ===\n";
echo "Aktif count: " . Penduduk::count() . "\n";
echo "SoftDeleted count: " . Penduduk::onlyTrashed()->count() . "\n";
echo "WithTrashed count: " . Penduduk::withTrashed()->count() . "\n";

$byYear = Penduduk::withTrashed()
    ->selectRaw("COALESCE(tahun, YEAR(created_at), 2025) as thn, COUNT(*) as cnt")
    ->groupByRaw("COALESCE(tahun, YEAR(created_at), 2025)")
    ->get();

echo "\nGroup by year (withTrashed):\n";
foreach($byYear as $r) {
    echo "Tahun: {$r->thn} | Jumlah: {$r->cnt}\n";
}
