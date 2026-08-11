<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('D:\Projects\skripsi_4\DATA SIDOMULYO\Data Penduduk Penerima BLT Dana Desa Tahun 2025.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$i = 0;
$anomalies = [
    'nik_not_16' => [],
    'nkk_not_16' => [],
    'umur_invalid' => [],
    'alamat_unique' => [],
    'pekerjaan_unique' => [],
    'empty_names' => []
];

foreach ($worksheet->getRowIterator() as $row) {
    $i++;
    if ($i < 8) continue; // skip header
    
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    $rowArray = [];
    foreach ($cellIterator as $cell) {
        $rowArray[] = $cell->getValue();
    }
    
    // Column Mapping based on previous check:
    // 0 = empty, 1 = NO, 2 = NAMA, 3 = UMUR, 4 = NIK, 5 = NKK, 6 = ALAMAT, 7 = PEKERJAAN
    
    $nama = trim((string)$rowArray[2]);
    if (empty($nama)) continue; // end of data or empty row
    
    $umur = trim((string)$rowArray[3]);
    $nik = trim(preg_replace('/[^0-9]/', '', (string)$rowArray[4]));
    $nkk = trim(preg_replace('/[^0-9]/', '', (string)$rowArray[5]));
    $alamat = trim(strtoupper((string)$rowArray[6]));
    $pekerjaan = trim(strtoupper((string)$rowArray[7]));
    
    if (strlen($nik) !== 16) {
        $anomalies['nik_not_16'][] = "Baris $i: $nama (NIK: $nik)";
    }
    
    if (strlen($nkk) !== 16) {
        $anomalies['nkk_not_16'][] = "Baris $i: $nama (NKK: $nkk)";
    }
    
    if (!is_numeric($umur) || $umur <= 0 || $umur > 120) {
        $anomalies['umur_invalid'][] = "Baris $i: $nama (Umur: $umur)";
    }
    
    if (!in_array($alamat, $anomalies['alamat_unique'])) {
        $anomalies['alamat_unique'][] = $alamat;
    }
    
    if (!in_array($pekerjaan, $anomalies['pekerjaan_unique'])) {
        $anomalies['pekerjaan_unique'][] = $pekerjaan;
    }
}

echo "=== HASIL ANALISA DATA EXCEL ===\n\n";
echo "1. Anomali NIK (Tidak 16 digit): " . count($anomalies['nik_not_16']) . " data\n";
if (count($anomalies['nik_not_16']) > 0) {
    echo implode("\n", array_slice($anomalies['nik_not_16'], 0, 5)) . (count($anomalies['nik_not_16']) > 5 ? "\n...dan lainnya" : "") . "\n";
}
echo "\n2. Anomali NKK (Tidak 16 digit): " . count($anomalies['nkk_not_16']) . " data\n";
if (count($anomalies['nkk_not_16']) > 0) {
    echo implode("\n", array_slice($anomalies['nkk_not_16'], 0, 5)) . (count($anomalies['nkk_not_16']) > 5 ? "\n...dan lainnya" : "") . "\n";
}
echo "\n3. Anomali Umur (Tidak valid): " . count($anomalies['umur_invalid']) . " data\n";
if (count($anomalies['umur_invalid']) > 0) {
    echo implode("\n", array_slice($anomalies['umur_invalid'], 0, 5)) . (count($anomalies['umur_invalid']) > 5 ? "\n...dan lainnya" : "") . "\n";
}

echo "\n4. Variasi Alamat yang Ditemukan (" . count($anomalies['alamat_unique']) . " jenis):\n";
echo implode(", ", $anomalies['alamat_unique']) . "\n";

echo "\n5. Variasi Pekerjaan yang Ditemukan (" . count($anomalies['pekerjaan_unique']) . " jenis):\n";
echo implode(", ", array_slice($anomalies['pekerjaan_unique'], 0, 10)) . (count($anomalies['pekerjaan_unique']) > 10 ? ", dll" : "") . "\n";

