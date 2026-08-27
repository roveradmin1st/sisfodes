<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $profil = \Illuminate\Support\Facades\DB::table('profil_desa')->first();
    echo "SUCCESS! Profil Desa loaded: " . ($profil->nama_desa ?? 'Ada') . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
