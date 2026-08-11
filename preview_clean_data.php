<?php
require 'vendor/autoload.php';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('D:\Projects\skripsi_4\DATA SIDOMULYO\Data Penduduk Penerima BLT Dana Desa Tahun 2025.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$i = 0;

$cleanedData = [];

// Fungsi untuk generate data realistis
function getRandomAgama() {
    $rand = rand(1, 100);
    if ($rand <= 80) return 'Islam';
    if ($rand <= 95) return 'Kristen';
    return 'Katolik';
}

function getRandomGender() {
    return rand(0, 1) ? 'L' : 'P';
}

function getStatusKawin($umur) {
    if ($umur < 19) return 'Belum Kawin';
    return rand(1, 100) <= 85 ? 'Kawin' : 'Belum Kawin';
}

foreach ($worksheet->getRowIterator() as $row) {
    $i++;
    if ($i < 8) continue; // Skip header
    
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    $rowArray = [];
    foreach ($cellIterator as $cell) {
        $rowArray[] = $cell->getValue();
    }
    
    $nama = trim((string)$rowArray[2]);
    if (empty($nama)) continue; 
    
    $umur = trim((string)$rowArray[3]);
    $nik = trim(preg_replace('/[^0-9]/', '', (string)$rowArray[4]));
    $nkk = trim(preg_replace('/[^0-9]/', '', (string)$rowArray[5]));
    $alamat = trim(strtoupper((string)$rowArray[6]));
    $pekerjaan = trim(strtoupper((string)$rowArray[7]));
    
    // Validasi Pembersihan
    if (strlen($nik) !== 16 || strlen($nkk) !== 16) {
        continue; // Abaikan baris kotor / summary
    }
    
    if (!is_numeric($umur) || $umur <= 0) {
        $umur = rand(25, 60); // Fallback umur
    }
    
    // Generate Realistic Dummy Data untuk kolom yang kosong
    $tahunLahir = 2025 - $umur; // Data tahun 2025
    $bulanLahir = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
    $hariLahir = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
    $tanggalLahir = "$tahunLahir-$bulanLahir-$hariLahir";
    
    $jenisKelamin = getRandomGender();
    
    $cleanedData[] = [
        'NIK' => $nik,
        'NKK' => $nkk,
        'Nama' => $nama,
        'Tmpt/Tgl Lahir' => "DELI SERDANG, $tanggalLahir",
        'J.Kelamin' => $jenisKelamin,
        'Agama' => getRandomAgama(),
        'Status' => getStatusKawin($umur),
        'Pekerjaan' => $pekerjaan,
        'Alamat' => $alamat
    ];
}

echo "=== PREVIEW 10 DATA PENDUDUK BERSIH ===\n";
echo "Total Data Bersih yang Berhasil Diekstrak: " . count($cleanedData) . " data\n\n";

foreach (array_slice($cleanedData, 0, 10) as $index => $data) {
    echo ($index + 1) . ". NIK: " . $data['NIK'] . "\n";
    echo "   Nama        : " . $data['Nama'] . "\n";
    echo "   Tgl Lahir   : " . $data['Tmpt/Tgl Lahir'] . "\n";
    echo "   J.Kelamin   : " . $data['J.Kelamin'] . "\n";
    echo "   Agama       : " . $data['Agama'] . "\n";
    echo "   Pekerjaan   : " . $data['Pekerjaan'] . "\n";
    echo "   Alamat      : " . $data['Alamat'] . "\n";
    echo "------------------------------------------------\n";
}
