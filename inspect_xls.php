<?php
require 'vendor/autoload.php';

$filePath = 'D:\Projects\skripsi_4\DATA SIDOMULYO\Data Penduduk Desa Sidomulyo Tahun 2025.xls';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
$worksheet = $spreadsheet->getActiveSheet();

echo "Memeriksa file: " . $filePath . "\n\n";

$i = 0;
foreach ($worksheet->getRowIterator() as $row) {
    $i++;
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);
    $rowArray = [];
    foreach ($cellIterator as $cell) {
        $rowArray[] = $cell->getValue();
    }
    
    if ($i == 2) {
        echo "Baris $i: \n";
        foreach ($rowArray as $idx => $val) {
            echo "Index $idx: $val \n";
        }
        break;
    }
}
