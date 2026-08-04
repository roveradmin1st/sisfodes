<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jenis = App\Models\JenisSurat::whereNotNull('template_surat')->first();
$path = storage_path('app/public/' . $jenis->template_surat);

echo "Testing template: {$path}\n";

$start = microtime(true);
try {
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($path);
    $templateProcessor->setValue('nama', 'BUDI SANTOSO');
    $templateProcessor->setValue('nik', '1234567890123456');
    $templateProcessor->setValue('no_kk', '1234567890123456');
    $templateProcessor->setValue('tempat_lahir', 'Medan');
    $templateProcessor->setValue('tanggal_lahir', '01 Januari 1990');
    $templateProcessor->setValue('jenis_kelamin', 'Laki-Laki');
    $templateProcessor->setValue('agama', 'Islam');
    $templateProcessor->setValue('pekerjaan', 'Petani');
    $templateProcessor->setValue('kewarganegaraan', 'Warga Negara Indonesia');
    $templateProcessor->setValue('status_perkawinan', 'Belum Kawin');
    $templateProcessor->setValue('alamat', 'Dusun I');
    $templateProcessor->setValue('keperluan', 'Persyaratan Administrasi');
    $templateProcessor->setValue('tanggal_cetak', date('d F Y'));

    $tempDocx = tempnam(sys_get_temp_dir(), 'word_') . '.docx';
    $templateProcessor->saveAs($tempDocx);

    $tempPdf = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';

    \PhpOffice\PhpWord\Settings::setPdfRendererName(\PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF);
    \PhpOffice\PhpWord\Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

    $phpWord = \PhpOffice\PhpWord\IOFactory::load($tempDocx);
    $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
    $pdfWriter->save($tempPdf);

    @unlink($tempDocx);
    echo "Success! PDF generated in " . round(microtime(true) - $start, 2) . "s. Size: " . filesize($tempPdf) . " bytes\n";
    @unlink($tempPdf);
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
