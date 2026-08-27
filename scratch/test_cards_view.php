<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
\Illuminate\Support\Facades\Auth::login($user);

$req = \Illuminate\Http\Request::create('/penduduk', 'GET');
$res = $app->handle($req);
$content = $res->getContent();

echo "HTTP Status: " . $res->getStatusCode() . "\n";
echo "Contains 7.285 (Total Penduduk): " . (strpos($content, '7.285') !== false || strpos($content, '7,285') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 1.988 (Kepala Keluarga): " . (strpos($content, '1.988') !== false || strpos($content, '1,988') !== false ? 'YES' : 'NO') . "\n";
echo "Contains 886 (Penduduk Lansia): " . (strpos($content, '886') !== false ? 'YES' : 'NO') . "\n";
