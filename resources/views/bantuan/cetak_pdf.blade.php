<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Penerima Bantuan - Desa Sidomulyo</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm 1.5cm 1.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
            padding-bottom: 6px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .header-text {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
        }
        .header-text .line-1 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .header-text .line-2 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .header-text .line-3 {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .header-text .line-4 {
            font-size: 10.5pt;
            margin-bottom: 1px;
        }
        .header-text .line-5 {
            font-size: 10.5pt;
        }

        .title-section {
            text-align: center;
            margin-bottom: 15px;
        }
        .title-section h4 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title-section p {
            margin: 3px 0 0 0;
            font-size: 9.5pt;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .report-table th, 
        .report-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 9pt;
            vertical-align: middle;
        }
        .report-table th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .report-table tr:nth-child(even) td {
            background-color: #fafafa;
        }
        .text-center {
            text-align: center;
        }

        .signature-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
            width: 50%;
            font-size: 10pt;
        }
        .signature-space {
            height: 60px;
        }

        .badge-status {
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI DESA SIDOMULYO -->
    <table class="header-table">
        <tr>
            <td style="width: 12%; text-align: center; vertical-align: middle;">
                @if(file_exists(public_path('storage/logo-deli-serdang.png')))
                    <img src="{{ public_path('storage/logo-deli-serdang.png') }}" class="logo" alt="Logo">
                @endif
            </td>
            <td style="width: 88%; text-align: center; vertical-align: middle;" class="header-text">
                <div class="line-1">PEMERINTAH KABUPATEN DELI SERDANG</div>
                <div class="line-2">KECAMATAN BIRU-BIRU</div>
                <div class="line-3">DESA SIDOMULYO</div>
                <div class="line-4">Jalan Umum Biru-Biru – Delitua Km. 14 Kode Pos : 20358</div>
                <div class="line-5">Email : <span style="text-decoration: underline; color: #0066cc;">sidomulyobirubiru1207@gmail.com</span></div>
            </td>
        </tr>
    </table>

    <!-- JUDUL DOKUMEN LAPORAN -->
    <div class="title-section">
        <h4>LAPORAN DATA PENERIMA BANTUAN DESA</h4>
        <p>
            Status: <strong>{{ $request->filled('status') ? strtoupper($request->status) : 'SEMUA STATUS' }}</strong> | 
            Diurutkan Berdasarkan: <strong>Nama Sesuai Abjad (A-Z)</strong> | 
            Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong>
        </p>
    </div>

    <!-- TABEL DATA PENERIMA BANTUAN -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 160px;">Nama Lengkap</th>
                <th style="width: 110px;">NIK</th>
                <th style="width: 110px;">No. KK</th>
                <th>Dusun / Alamat</th>
                <th style="width: 90px;">Pekerjaan</th>
                <th style="width: 120px;">Program Bantuan</th>
                <th style="width: 85px;">Tgl Terima</th>
                <th style="width: 70px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penerima as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td style="font-weight: bold;">{{ strtoupper(optional($item->penduduk)->nama ?? '-') }}</td>
                <td class="text-center">{{ optional($item->penduduk)->nik ?? '-' }}</td>
                <td class="text-center">{{ optional($item->penduduk)->no_kk ?? '-' }}</td>
                <td>{{ optional($item->penduduk)->dusun ?? '-' }} - {{ optional($item->penduduk)->alamat ?? '-' }}</td>
                <td>{{ optional($item->penduduk)->pekerjaan ?? '-' }}</td>
                <td style="font-weight: 500;">{{ $item->program_bantuan }}</td>
                <td class="text-center">
                    {{ $item->tanggal_terima ? \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center badge-status">
                    {{ ucfirst($item->status) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; font-style: italic;">
                    Tidak ada data penerima bantuan yang ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN KEPALA DESA & KAUR UMUM -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>KEPALA DESA SIDOMULYO</strong>
                <div class="signature-space"></div>
                <strong style="text-decoration: underline;">{{ strtoupper($kepalaDesa->nama ?? 'SATRIAWAN') }}</strong>
            </td>
            <td>
                Sidomulyo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <strong>KAUR UMUM DESA SIDOMULYO</strong>
                <div class="signature-space"></div>
                <strong style="text-decoration: underline;">{{ strtoupper($kaurUmum->nama ?? 'TUTI AMIDAH') }}</strong>
            </td>
        </tr>
    </table>

</body>
</html>
