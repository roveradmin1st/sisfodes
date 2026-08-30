<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $permohonan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</title>
    <style>
        @page {
            margin: 1.8cm 2cm 1.8cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.4;
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
            margin: 3px 0 0 0;
            font-size: 11pt;
        }
        .content-section {
            text-align: justify;
            margin-bottom: 20px;
        }
        .data-table {
            width: 100%;
            margin: 10px 0 10px 15px;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .signature-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
        }
        .signature-space {
            height: 75px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI DESA SIDOMULYO -->
    <table class="header-table">
        <tr>
            <td style="width: 12%; text-align: center; vertical-align: middle;">
                @if(file_exists(public_path('storage/logo-deli-serdang.png')))
                    <img src="{{ public_path('storage/logo-deli-serdang.png') }}" style="width: 80px; height: auto;" alt="Logo">
                @endif
            </td>
            <td style="width: 88%; text-align: center; vertical-align: middle; font-family: 'Times New Roman', Times, serif; color: #000;">
                <div style="font-size: 14pt; font-weight: bold; letter-spacing: 0.5px; margin-bottom: 1px;">PEMERINTAH KABUPATEN DELI SERDANG</div>
                <div style="font-size: 14pt; font-weight: bold; letter-spacing: 0.5px; margin-bottom: 1px;">KECAMATAN BIRU-BIRU</div>
                <div style="font-size: 18pt; font-weight: bold; letter-spacing: 1px; margin-bottom: 2px;">DESA SIDOMULYO</div>
                <div style="font-size: 10.5pt; margin-bottom: 1px;">Jalan Umum Biru-Biru – Delitua Km. 14 Kode Pos : 20358</div>
                <div style="font-size: 10.5pt;">Email : <span style="text-decoration: underline; color: #0066cc;">sidomulyobirubiru1207@gmail.com</span></div>
            </td>
        </tr>
    </table>

    @php
        $isKematian = stripos($permohonan->jenisSurat->nama_surat ?? '', 'kematian') !== false;
    @endphp

    @if($isKematian)
        <!-- ============================================================ -->
        <!-- TEMPLATE KHUSUS: SURAT KETERANGAN KEMATIAN                   -->
        <!-- ============================================================ -->
        <div class="title-section">
            <h4>SURAT KETERANGAN KEMATIAN</h4>
            <p>Nomor: {{ $permohonan->nomor_surat ?? \App\Http\Controllers\SuratController::generateNomorSurat($permohonan) }}</p>
        </div>

        <div class="content-section">
            <p style="margin-bottom: 10px;">Yang bertanda tangan dibawah ini :</p>

            <table style="width: 100%; margin-left: 15px; margin-bottom: 15px; border-collapse: collapse;">
                <tr>
                    <td style="width: 22%; vertical-align: top;">Nama</td>
                    <td style="width: 3%; vertical-align: top;">:</td>
                    <td style="width: 75%; vertical-align: top;"><strong>SATRIAWAN</strong></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Jabatan</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;">Kepala Desa Sidomulyo Kec. Biru-Biru Kab. Deli Serdang</td>
                </tr>
            </table>

            <p style="margin-bottom: 10px;">Dengan ini menerangkan bahwa :</p>

            <table style="width: 100%; margin-left: 15px; margin-bottom: 15px; border-collapse: collapse;">
                <tr>
                    <td style="width: 4%; vertical-align: top;">1.</td>
                    <td style="width: 25%; vertical-align: top;">Nama Lengkap</td>
                    <td style="width: 3%; vertical-align: top;">:</td>
                    <td style="width: 68%; vertical-align: top;"><strong>{{ strtoupper($permohonan->penduduk->nama ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top;">Jenis Kelamin</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;">{{ ($permohonan->penduduk->jenis_kelamin ?? 'L') == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top;">Bangsa / Agama</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;">{{ ($permohonan->penduduk->kewarganegaraan ?? 'WNI') == 'WNI' ? 'Indonesia' : $permohonan->penduduk->kewarganegaraan }} / {{ $permohonan->penduduk->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top;">Alamat</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;">{{ $permohonan->penduduk->alamat ?? 'Desa Sidomulyo, Kec. Biru-Biru' }}</td>
                </tr>
            </table>

            <table style="width: 100%; margin-left: 15px; margin-bottom: 15px; border-collapse: collapse;">
                <tr>
                    <td style="width: 4%; vertical-align: top;">2.</td>
                    <td style="width: 96%; vertical-align: top;">Benar nama tersebut diatas adalah benar Penduduk Desa Sidomulyo Kecamatan Biru-Biru Kabupaten Deli Serdang Provinsi Sumatera Utara.</td>
                </tr>
            </table>

            <table style="width: 100%; margin-left: 15px; margin-bottom: 15px; border-collapse: collapse;">
                <tr>
                    <td style="width: 4%; vertical-align: top;">3.</td>
                    <td style="width: 96%; vertical-align: top;" colspan="3">Benar nama tersebut diatas telah meninggal dunia pada :</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 25%; vertical-align: top; padding-left: 10px;">Tanggal</td>
                    <td style="width: 3%; vertical-align: top;">:</td>
                    <td style="width: 68%; vertical-align: top;"><strong>{{ $permohonan->tanggal_meninggal ? \Carbon\Carbon::parse($permohonan->tanggal_meninggal)->translatedFormat('d F Y') : ($permohonan->deleted_at ? \Carbon\Carbon::parse($permohonan->deleted_at)->translatedFormat('d F Y') : '..........................................................') }}</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top; padding-left: 10px;">Meninggal di</td>
                    <td style="vertical-align: top;">:</td>
                    <td style="vertical-align: top;"><strong>{{ $permohonan->tempat_meninggal ?? '..........................................................' }}</strong></td>
                </tr>
            </table>

            <p style="margin-top: 15px; margin-bottom: 25px;">Demikian Surat Keterangan ini diperbuat dengan sebenarnya agar yang berkepentingan dapat mempergunakan seperlunya.</p>
        </div>

        <!-- BLOK TANDA TANGAN KEMATIAN -->
        <table class="signature-table">
            <tr>
                <td style="width: 45%;"></td>
                <td style="width: 55%; text-align: left; vertical-align: top; padding-left: 30px;">
                    Dikeluarkan di : Sidomulyo<br>
                    <u>Pada Tanggal : {{ $permohonan->tanggal_pengajuan ? \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}</u><br>
                    Kepala Desa Sidomulyo<br>
                    Kecamatan Biru-Biru
                    <div class="signature-space"></div>
                    <strong>( SATRIAWAN )</strong>
                </td>
            </tr>
        </table>

    @else
        <!-- ============================================================ -->
        <!-- TEMPLATE UMUM SURAT KETERANGAN                               -->
        <!-- ============================================================ -->
        <div class="title-section">
            <h4>{{ strtoupper($permohonan->jenisSurat->nama_surat ?? 'SURAT KETERANGAN') }}</h4>
            <p>Nomor : {{ $permohonan->nomor_surat ?? \App\Http\Controllers\SuratController::generateNomorSurat($permohonan) }}</p>
        </div>

        <div class="content-section">
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidomulyo, Kecamatan Biru-Biru, Kabupaten Deli Serdang, Provinsi Sumatera Utara, dengan ini menerangkan bahwa:</p>

            <table class="data-table">
                <tr>
                    <td style="width: 30%;">Nama Lengkap</td>
                    <td style="width: 3%;">:</td>
                    <td style="width: 67%;"><strong>{{ strtoupper($permohonan->penduduk->nama ?? '-') }}</strong></td>
                </tr>
                <tr>
                    <td>NIK / No. KTP</td>
                    <td>:</td>
                    <td>{{ ltrim($permohonan->penduduk->nik ?? '-', "'") }}</td>
                </tr>
                <tr>
                    <td>No. Kartu Keluarga</td>
                    <td>:</td>
                    <td>{{ ltrim($permohonan->penduduk->no_kk ?? '-', "'") }}</td>
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
                    <td>Kewarganegaraan</td>
                    <td>:</td>
                    <td>{{ ($permohonan->penduduk->kewarganegaraan ?? 'WNI') == 'WNI' ? 'Warga Negara Indonesia (WNI)' : ($permohonan->penduduk->kewarganegaraan ?? 'WNI') }}</td>
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

            <p>Bahwa nama yang bersangkutan adalah benar warga bertempat tinggal di Desa Sidomulyo Kecamatan Biru-Biru dan berdasarkan data administrasi kami yang bersangkutan mengajukan permohonan untuk keperluan: <strong>{{ $permohonan->keperluan }}</strong>.</p>

            <p style="margin-top: 15px;">Demikian Surat Keterangan ini diperbuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <table class="signature-table">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    Sidomulyo, {{ $permohonan->tanggal_pengajuan ? \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Kepala Desa Sidomulyo
                    <div class="signature-space"></div>
                    <strong><u>SATRIAWAN</u></strong>
                </td>
            </tr>
        </table>
    @endif

</body>
</html>
