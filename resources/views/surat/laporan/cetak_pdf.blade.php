<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Surat</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; color: #000; padding: 15px 25px; }

        /* KOP SURAT */
        .kop { display: table; width: 100%; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 12px; }
        .kop-logo { display: table-cell; width: 75px; vertical-align: middle; text-align: center; }
        .kop-logo img { width: 65px; height: 65px; object-fit: contain; }
        .kop-text { display: table-cell; vertical-align: middle; text-align: center; }
        .kop-text .prov  { font-size: 9.5pt; }
        .kop-text .desa  { font-size: 15pt; font-weight: bold; letter-spacing: 1px; }
        .kop-text .kec   { font-size: 9.5pt; }
        .kop-text .alamat{ font-size: 8pt; margin-top: 2px; }

        /* JUDUL */
        .judul { text-align: center; margin: 10px 0 14px 0; }
        .judul h2 { font-size: 13pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; letter-spacing: 1px; }
        .judul p  { font-size: 10.5pt; margin-top: 3px; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; font-size: 9.5pt; }
        thead th {
            background-color: #d9d9d9;
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: center;
            font-weight: bold;
        }
        tbody td { border: 1px solid #555; padding: 5px 8px; vertical-align: top; }
        tfoot td { border: 1px solid #333; padding: 6px 8px; font-weight: bold; background-color: #efefef; }
        .tc { text-align: center; }
        .tr { text-align: right; }

        /* TANDA TANGAN */
        .ttd { display: table; width: 100%; margin-top: 24px; }
        .ttd-col { display: table-cell; width: 50%; text-align: center; font-size: 10pt; }
        .ttd-name { margin-top: 55px; font-weight: bold; border-top: 1px solid #000; display: inline-block; min-width: 180px; padding-top: 4px; }

        /* FOOTER */
        .footer { text-align: center; font-size: 7.5pt; color: #555; margin-top: 16px; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

{{-- KOP SURAT --}}
<div class="kop">
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
            {{ $profil->alamat_kantor ?? 'Desa Sidomulyo, Kec. Biru-Biru, Kab. Deli Serdang, Sumatera Utara' }}
        </div>
    </div>
    <div class="kop-logo"></div>
</div>

{{-- JUDUL --}}
<div class="judul">
    <h2>Laporan Pengajuan Surat</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($dari)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d-m-Y') }}</p>
</div>

{{-- TABEL --}}
<table>
    <thead>
        <tr>
            <th style="width:30px;">No</th>
            <th style="width:130px;">Pemohon</th>
            <th style="width:130px;">Jenis Surat</th>
            <th>Keperluan</th>
            <th style="width:80px;">Tanggal</th>
            <th style="width:75px;">Status</th>
            <th style="width:130px;">Nomor Surat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($permohonan as $idx => $item)
        <tr>
            <td class="tc">{{ $idx + 1 }}</td>
            <td>
                <strong>{{ strtoupper($item->penduduk->nama ?? '-') }}</strong>
            </td>
            <td>{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
            <td>{{ $item->keperluan }}</td>
            <td class="tc">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
            <td class="tc">{{ ucfirst($item->status_permohonan) }}</td>
            <td class="tc">{{ $item->nomor_surat ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="tc" style="padding: 15px; font-style: italic;">
                Tidak ada data pengajuan surat pada periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
    @if($permohonan->count() > 0)
    <tfoot>
        <tr>
            <td colspan="6" class="tr">Total Pengajuan:</td>
            <td class="tc">{{ $permohonan->count() }} surat</td>
        </tr>
    </tfoot>
    @endif
</table>

{{-- TANDA TANGAN --}}
<div class="ttd">
    <div class="ttd-col">
        <p>Dibuat Oleh,</p>
        <p>Kaur Umum Desa Sidomulyo</p>
        <div class="ttd-name">{{ $kaurUmum->nama ?? '.................................' }}</div>
    </div>
    <div class="ttd-col">
        <p>Sidomulyo, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>Kepala Desa Sidomulyo</p>
        <div class="ttd-name">{{ $kepalaDesa->nama ?? '.................................' }}</div>
    </div>
</div>

{{-- FOOTER --}}
<div class="footer">
    Dicetak pada {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB &mdash; Sistem Informasi Desa Sidomulyo
</div>

</body>
</html>
