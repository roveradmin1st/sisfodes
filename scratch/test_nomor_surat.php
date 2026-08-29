<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PermohonanSurat;
use App\Http\Controllers\SuratController;

$permohonan = PermohonanSurat::first();

if ($permohonan) {
    // temporarily clear nomor_surat to test generation
    $clone = clone $permohonan;
    $clone->nomor_surat = null;
    $generated = SuratController::generateNomorSurat($clone);
    echo "Generated Nomor Surat: {$generated}\n";
    echo "Contains /DS/: " . (strpos($generated, '/DS/') !== false ? 'YES' : 'NO') . "\n";
} else {
    echo "No permohonan_surat found in DB.\n";
}
