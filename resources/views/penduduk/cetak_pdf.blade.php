<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Data Penduduk - Desa Sidomulyo</title>
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

        /* ===== KOP SURAT ===== */
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

        /* ===== TITLE ===== */
        .title-section {
            text-align: center;
            margin-bottom: 18px;
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
            font-size: 10pt;
        }

        /* ===== DATA TABLE ===== */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .content-table th, 
        .content-table td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: center;
            vertical-align: middle;
            font-size: 9.5pt;
        }
        .content-table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .content-table tfoot th {
            background-color: #e6e6e6;
            font-weight: bold;
        }

        /* ===== SIGNATURE BLOCK ===== */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            width: 50%;
            text-align: center;
            font-size: 10pt;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI DESA SIDOMULYO -->
    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                @if(file_exists(public_path('storage/logo-deli-serdang.png')))
                    <img src="{{ public_path('storage/logo-deli-serdang.png') }}" class="logo" alt="Logo Deli Serdang">
                @else
                    <div style="font-weight: bold; font-size: 8pt;">[LOGO DESA]</div>
                @endif
            </td>
            <td style="width: 85%;">
                <div class="header-text">
                    <div class="line-1">PEMERINTAH KABUPATEN DELI SERDANG</div>
                    <div class="line-2">KECAMATAN BIRU-BIRU</div>
                    <div class="line-3">DESA SIDOMULYO</div>
                    <div class="line-4">Jalan Umum Biru-Biru – Delitua Km. 14 Kode Pos : 20358</div>
                    <div class="line-5">Email : <span style="text-decoration: underline; color: blue;">sidomulyobirubiru1207@gmail.com</span></div>
                </div>
            </td>
        </tr>
    </table>

    <!-- JUDUL LAPORAN -->
    <div class="title-section">
        <h4>LAPORAN REKAPITULASI DATA PENDUDUK PER TAHUN</h4>
        <p>Pemerintah Desa Sidomulyo Kecamatan Biru-Biru</p>
    </div>

    <!-- TABEL DATA REKAPITULASI PENDUDUK (SESUAI GAMBAR) -->
    <table class="content-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 12%;">Tahun</th>
                <th colspan="2">Jenis Kelamin</th>
                <th colspan="2">Kepala Keluarga (KK)</th>
                <th rowspan="2" style="width: 18%;">Total Kepala Keluarga</th>
                <th rowspan="2" style="width: 18%;">Total Penduduk</th>
            </tr>
            <tr>
                <th style="width: 14%;">Laki-Laki</th>
                <th style="width: 14%;">Perempuan</th>
                <th style="width: 14%;">Laki-Laki</th>
                <th style="width: 14%;">Perempuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapData as $row)
            <tr>
                <td><strong>{{ $row->tahun }}</strong></td>
                <td>{{ number_format($row->total_l, 0, ',', '.') }}</td>
                <td>{{ number_format($row->total_p, 0, ',', '.') }}</td>
                <td>{{ number_format($row->kk_l, 0, ',', '.') }}</td>
                <td>{{ number_format($row->kk_p, 0, ',', '.') }}</td>
                <td><strong>{{ number_format($row->total_kk, 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format($row->total_penduduk, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 20px;">Data rekapitulasi penduduk tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($rekapData) > 0)
        <tfoot>
            <tr>
                <th>JUMLAH</th>
                <th>{{ number_format($grandTotal->total_l, 0, ',', '.') }}</th>
                <th>{{ number_format($grandTotal->total_p, 0, ',', '.') }}</th>
                <th>{{ number_format($grandTotal->kk_l, 0, ',', '.') }}</th>
                <th>{{ number_format($grandTotal->kk_p, 0, ',', '.') }}</th>
                <th>{{ number_format($grandTotal->total_kk, 0, ',', '.') }}</th>
                <th>{{ number_format($grandTotal->total_penduduk, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- TANDA TANGAN PERANGKAT DESA -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala Desa Sidomulyo</strong>
                <div class="signature-space"></div>
                <strong><u>{{ strtoupper($kepalaDesa->nama ?? 'SATRIAWAN') }}</u></strong>
            </td>
            <td>
                Sidomulyo, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                <strong>Kaur Umum Desa Sidomulyo</strong>
                <div class="signature-space"></div>
                <strong><u>{{ strtoupper($kaurUmum->nama ?? 'TUTI AMIDAH') }}</u></strong>
            </td>
        </tr>
    </table>

</body>
</html>
