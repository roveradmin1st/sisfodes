<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat Keterangan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            padding: 20px 30px;
        }

        /* ===== HEADER KOP SURAT ===== */
        .kop-surat {
            display: table;
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .kop-logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
        }
        .kop-logo img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }
        .kop-text .prov { font-size: 10pt; }
        .kop-text .desa { font-size: 16pt; font-weight: bold; letter-spacing: 1px; }
        .kop-text .kec  { font-size: 10pt; }
        .kop-text .alamat { font-size: 8.5pt; margin-top: 2px; }

        /* ===== JUDUL LAPORAN ===== */
        .judul-laporan {
            text-align: center;
            margin: 12px 0 16px 0;
        }
        .judul-laporan h2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .judul-laporan p {
            font-size: 11pt;
            margin-top: 4px;
        }

        /* ===== TABEL ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10.5pt;
        }
        thead th {
            background-color: #e0e0e0;
            border: 1px solid #333;
            padding: 7px 10px;
            text-align: center;
            font-weight: bold;
        }
        tbody td {
            border: 1px solid #555;
            padding: 6px 10px;
            vertical-align: middle;
        }
        tfoot td {
            border: 1px solid #333;
            padding: 7px 10px;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        /* ===== TANDA TANGAN ===== */
        .ttd-area {
            display: table;
            width: 100%;
            margin-top: 30px;
        }
        .ttd-left, .ttd-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .ttd-name {
            margin-top: 60px;
            font-weight: bold;
            border-top: 1px solid #000;
            display: inline-block;
            min-width: 180px;
            padding-top: 4px;
        }

        /* ===== FOOTER KECIL ===== */
        .page-footer {
            text-align: center;
            font-size: 8pt;
            color: #555;
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <div class="kop-logo">
            @php
                $logoPath = public_path('storage/logo-deli-serdang.png');
                $logoBase64 = '';
                if (file_exists($logoPath)) {
                    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                }
            @endphp
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Logo">
            @endif
        </div>
        <div class="kop-text">
            <div class="prov">PEMERINTAH KABUPATEN DELI SERDANG</div>
            <div class="desa">KANTOR KEPALA DESA SIDOMULYO</div>
            <div class="kec">KECAMATAN BIRU-BIRU</div>
            <div class="alamat">
                @if($profil)
                    {{ $profil->alamat_kantor ?? 'Desa Sidomulyo, Kec. Biru-Biru, Kab. Deli Serdang, Sumatera Utara' }}
                @else
                    Desa Sidomulyo, Kec. Biru-Biru, Kab. Deli Serdang, Sumatera Utara
                @endif
            </div>
        </div>
        <div class="kop-logo">
            {{-- Placeholder kanan jika ada logo kab --}}
        </div>
    </div>

    {{-- JUDUL --}}
    <div class="judul-laporan">
        <h2>Laporan Pengurusan Surat Keterangan</h2>
        <p>Bulan {{ $namaBulan }} Tahun {{ $tahun }}</p>
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Jenis Surat Keterangan</th>
                <th style="width: 110px;">Total Pengajuan</th>
                <th style="width: 90px;">Diproses</th>
                <th style="width: 80px;">Selesai</th>
                <th style="width: 80px;">Ditolak</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $totalSemua = 0;
                $totalProses = 0;
                $totalSelesai = 0;
                $totalTolak = 0;
            @endphp
            @forelse($laporan as $data)
                @php
                    $totalSemua   += $data['total'];
                    $totalProses  += $data['diproses'];
                    $totalSelesai += $data['selesai'];
                    $totalTolak   += $data['ditolak'];
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $data['nama_surat'] }}</td>
                    <td class="text-center"><strong>{{ $data['total'] }}</strong></td>
                    <td class="text-center">{{ $data['diproses'] }}</td>
                    <td class="text-center">{{ $data['selesai'] }}</td>
                    <td class="text-center">{{ $data['ditolak'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; font-style: italic;">
                        Tidak ada data permohonan surat pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-center">{{ $totalSemua }}</td>
                <td class="text-center">{{ $totalProses }}</td>
                <td class="text-center">{{ $totalSelesai }}</td>
                <td class="text-center">{{ $totalTolak }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="ttd-area">
        <div class="ttd-left">
            <p>Dibuat Oleh,</p>
            <p>Kaur Umum</p>
            <div class="ttd-name">
                {{ $kaurUmum->nama ?? '............................' }}
            </div>
        </div>
        <div class="ttd-right">
            <p>Sidomulyo, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p>Kepala Desa Sidomulyo</p>
            <div class="ttd-name">
                {{ $kepalaDesa->nama ?? '............................' }}
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="page-footer">
        Dicetak pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB &mdash; Sistem Informasi Desa Sidomulyo
    </div>

</body>
</html>
