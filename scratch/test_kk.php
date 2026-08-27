<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
\Illuminate\Support\Facades\Auth::login($user);

$penduduk = \App\Models\Penduduk::first();
$no_kk = $penduduk->no_kk;

echo "Testing No. KK: {$no_kk}\n";

$req = \Illuminate\Http\Request::create('/penduduk/kk/' . $no_kk, 'GET');
$res = $app->handle($req);

echo "HTTP Status: " . $res->getStatusCode() . "\n";
echo "Contains 'Detail Kartu Keluarga': " . (strpos($res->getContent(), 'Detail Kartu Keluarga') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 'Tambah Anggota Keluarga Ini': " . (strpos($res->getContent(), 'Tambah Anggota Keluarga Ini') !== false ? 'YES' : 'NO') . "\n";
