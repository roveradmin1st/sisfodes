<?php
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('D:\Projects\skripsi_4\DATA SIDOMULYO\Data Penduduk Penerima BLT Dana Desa Tahun 2025.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$data = [];
$i = 0;
foreach ($worksheet->getRowIterator() as $row) {
    $i++;
    if ($i < 8) continue;
    if ($i > 15) break;
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    $rowArray = [];
    foreach ($cellIterator as $cell) {
        $rowArray[] = $cell->getValue();
    }
    $data[] = $rowArray;
}
echo json_encode($data, JSON_PRETTY_PRINT);
