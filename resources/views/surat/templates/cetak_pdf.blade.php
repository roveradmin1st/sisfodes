<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $permohonan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</title>
    <style>
        @page {
            margin: 2cm 2cm 2cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo {
            width: 75px;
            height: auto;
        }
        .header-text {
            text-align: center;
        }
        .header-text h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header-text h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header-text p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }
        .title-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .title-section h4 {
            margin: 0;
            font-size: 13pt;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title-section p {
            margin: 0;
            font-size: 11pt;
        }
        .content-section {
            text-align: justify;
            margin-bottom: 20px;
        }
        .data-table {
            width: 100%;
            margin: 15px 0 15px 30px;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        .signature-space {
            height: 75px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                <img src="{{ public_path('storage/logo-deli-serdang.png') }}" class="logo" alt="Logo">
            </td>
            <td style="width: 85%;" class="header-text">
                <h3>PEMERINTAH KABUPATEN DELI SERDANG</h3>
                <h3>KECAMATAN BIRU-BIRU</h3>
                <h2>PEMERINTAH DESA SIDOMULYO</h2>
                <p>Alamat: Jl. Desa Sidomulyo, Kec. Biru-Biru, Kab. Deli Serdang, Kode Pos 20376</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL SURAT -->
    <div class="title-section">
        <h4>{{ strtoupper($permohonan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN') }}</h4>
        <p>Nomor: 470 / {{ str_pad($permohonan->id_permohonan, 4, '0', STR_PAD_LEFT) }} / SDM / {{ date('Y') }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="content-section">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Sidomulyo, Kecamatan Biru-Biru, Kabupaten Deli Serdang, Provinsi Sumatera Utara, dengan ini menerangkan bahwa:</p>

        <table class="data-table">
            <tr>
                <td style="width: 30%;">Nama Lengkap</td>
                <td style="width: 3%;">:</td>
                <td style="width: 67%;"><strong>{{ strtoupper($permohonan->penduduk->nama_lengkap ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td>NIK / No. KTP</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. Kartu Keluarga</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->no_kk ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat / Tgl. Lahir</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->tempat_lahir ?? '-' }}, {{ isset($permohonan->penduduk->tanggal_lahir) ? \Carbon\Carbon::parse($permohonan->penduduk->tanggal_lahir)->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ ($permohonan->penduduk->jenis_kelamin ?? 'L') == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat Dusun</td>
                <td>:</td>
                <td>{{ $permohonan->penduduk->alamat ?? 'Desa Sidomulyo, Kec. Biru-Biru' }}</td>
            </tr>
        </table>

        <p>Bahwa nama yang bersangkutan adalah benar warga bertempat tinggal di Desa Sidomulyo Kecamatan Biru-Biru dan berdsarkan data administrasi kami yang bersangkutan mengajukan permohonan untuk keperluan: <strong>{{ $permohonan->keperluan }}</strong>.</p>

        <p style="margin-top: 15px;">Demikian Surat Keterangan ini diperbuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- BLOK TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td></td>
            <td>
                Sidomulyo, {{ date('d F Y') }}<br>
                <strong>KEPALA DESA SIDOMULYO</strong>
                <div class="signature-space"></div>
                <strong><u>SATRIAWAN</u></strong>
            </td>
        </tr>
    </table>

</body>
</html>
