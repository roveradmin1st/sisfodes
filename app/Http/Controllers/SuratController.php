<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuratController extends Controller
{
    // Jenis Surat Methods
    public function jenisIndex()
    {
        $jenisSurat = JenisSurat::latest()->paginate(10);

        return view('surat.jenis.index', compact('jenisSurat'));
    }

    public function jenisCreate()
    {
        return view('surat.jenis.create');
    }

    public function jenisStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_surat' => 'required|string|max:200|unique:jenis_surat,nama_surat',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'template_surat' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('template_surat')) {
            $path = $request->file('template_surat')->store('templates/surat', 'public');
            $data['template_surat'] = $path;
        }

        JenisSurat::create($data);

        return redirect()->route('surat.jenis.index')
            ->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function jenisEdit($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        return view('surat.jenis.edit', compact('jenisSurat'));
    }

    public function jenisUpdate(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_surat' => 'required|string|max:200|unique:jenis_surat,nama_surat,'.$id.',id_jenis_surat',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'template_surat' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('template_surat')) {
            if ($jenisSurat->template_surat) {
                Storage::disk('public')->delete($jenisSurat->template_surat);
            }
            $path = $request->file('template_surat')->store('templates/surat', 'public');
            $data['template_surat'] = $path;
        }

        $jenisSurat->update($data);

        return redirect()->route('surat.jenis.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function jenisDestroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        if (\App\Models\PermohonanSurat::where('id_jenis_surat', $id)->exists()) {
            return redirect()->route('surat.jenis.index')
                ->with('error', 'Jenis surat gagal dihapus karena sudah digunakan dalam pengajuan surat oleh warga.');
        }

        if ($jenisSurat->template_surat) {
            Storage::disk('public')->delete($jenisSurat->template_surat);
        }

        $jenisSurat->delete();

        return redirect()->route('surat.jenis.index')
            ->with('success', 'Jenis surat berhasil dihapus.');
    }

    // Permohonan Surat Methods
    public function permohonanIndex()
    {
        $user = Auth::user();

        if ($user->role == 'penduduk') {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
            $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])
                ->where('id_penduduk', $penduduk->id_penduduk ?? 0)
                ->latest()
                ->paginate(10);
        } else {
            $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])
                ->latest()
                ->paginate(10);
        }

        return view('surat.permohonan.index', compact('permohonan'));
    }

    public function permohonanCreate()
    {
        $jenisSurat = JenisSurat::all();
        $user = Auth::user();
        $penduduk = Penduduk::where('nik', $user->nik)->first();

        if (! $penduduk) {
            return redirect()->back()->with('error', 'Data penduduk tidak ditemukan.');
        }

        return view('surat.permohonan.create', compact('jenisSurat', 'penduduk'));
    }

    public function permohonanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_penduduk' => 'required|exists:penduduk,id_penduduk',
            'id_jenis_surat' => 'required|exists:jenis_surat,id_jenis_surat',
            'keperluan' => 'required|string',
            'file_persyaratan_list' => 'nullable|array',
            'file_persyaratan_list.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_persyaratan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['tanggal_pengajuan'] = now()->format('Y-m-d');
        $data['status_permohonan'] = 'menunggu';

        $filesPersyaratan = [];

        // Unggah berkas untuk masing-masing item persyaratan
        if ($request->hasFile('file_persyaratan_list')) {
            $namaSyaratList = $request->input('nama_syarat', []);
            $uploadedFiles = $request->file('file_persyaratan_list');

            foreach ($uploadedFiles as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('surat/persyaratan', 'public');
                    $label = $namaSyaratList[$index] ?? ('Persyaratan ' . ($index + 1));
                    $filesPersyaratan[] = [
                        'label' => $label,
                        'file' => $path,
                    ];
                }
            }
        } elseif ($request->hasFile('file_persyaratan')) {
            $path = $request->file('file_persyaratan')->store('surat/persyaratan', 'public');
            $filesPersyaratan[] = [
                'label' => 'Dokumen Persyaratan',
                'file' => $path,
            ];
        }

        if (empty($filesPersyaratan)) {
            return back()->withErrors(['file_persyaratan_list' => 'Seluruh dokumen persyaratan wajib diunggah.'])->withInput();
        }

        $data['file_persyaratan'] = json_encode($filesPersyaratan);

        $permohonan = PermohonanSurat::create($data);

        // Generate Nomor Surat Otomatis Berdasarkan Template Resmi Desa
        $permohonan->nomor_surat = self::generateNomorSurat($permohonan);
        $permohonan->save();

        return redirect()->route('surat.permohonan.index')
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public static function generateNomorSurat($permohonan)
    {
        if (!empty($permohonan->nomor_surat)) {
            return $permohonan->nomor_surat;
        }

        $tanggal = $permohonan->tanggal_pengajuan ? \Carbon\Carbon::parse($permohonan->tanggal_pengajuan) : now();
        $tahun = $tanggal->year;
        $bulanIndex = $tanggal->month - 1;
        $bulanRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][$bulanIndex];

        // Pemetaan Kode Klasifikasi Baku Surat Keterangan Desa Sidomulyo
        $namaJenis = $permohonan->jenisSurat->nama_surat ?? 'Surat Keterangan';
        $kodeMap = [
            'Domisili' => '470',
            'Tidak Mampu' => '400',
            'Nikah' => '474.2',
            'Usaha' => '510',
            'Belum Menikah' => '474.1',
            'Belum Punya Rumah' => '470',
            'Kematian' => '474.3',
            'Mandah' => '475',
            'Beda Nama' => '470',
            'Kelakuan Baik' => '300',
            'Penghasilan' => '470',
            'Tanah' => '590',
        ];

        $kode = '470';
        foreach ($kodeMap as $key => $val) {
            if (stripos($namaJenis, $key) !== false) {
                $kode = $val;
                break;
            }
        }

        $urutan = PermohonanSurat::whereYear('tanggal_pengajuan', $tahun)
            ->where('id_permohonan', '<=', $permohonan->id_permohonan)
            ->count();

        if ($urutan == 0) {
            $urutan = $permohonan->id_permohonan ?? 1;
        }

        $nomorUrut = sprintf('%03d', $urutan);

        // Format Resmi: [KODE] / [NOMOR_URUT] / DS / [BULAN_ROMAWI] / [TAHUN]
        // Contoh: 470/001/DS/VIII/2026 (Angka Romawi adalah Bulan di depan Tahun)
        return "{$kode}/{$nomorUrut}/DS/{$bulanRomawi}/{$tahun}";
    }

    public static function hapusPendudukMeninggal($permohonan)
    {
        $namaJenis = strtolower($permohonan->jenisSurat->nama_surat ?? '');
        if (strpos($namaJenis, 'kematian') !== false) {
            if ($permohonan->id_penduduk) {
                $penduduk = Penduduk::find($permohonan->id_penduduk);
                if ($penduduk) {
                    $namaWarga = $penduduk->nama;

                    // Hapus data penduduk dari master Data Penduduk
                    $penduduk->delete();

                    // Clear cache statistik kependudukan
                    \Illuminate\Support\Facades\Cache::flush();

                    return "Surat Keterangan Kematian diterbitkan. Data penduduk ({$namaWarga}) telah otomatis dihapus dari master Data Penduduk.";
                }
            }
        }
        return null;
    }

    public function permohonanShow($id)
    {
        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])->findOrFail($id);
        
        $user = Auth::user();
        if ($user->role == 'penduduk') {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
            if (!$penduduk || $permohonan->id_penduduk != $penduduk->id_penduduk) {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('surat.permohonan.show', compact('permohonan'));
    }

    public function permohonanVerifikasi(Request $request, $id)
    {
        $permohonan = PermohonanSurat::with('jenisSurat')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status'  => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $nomorSurat = $request->nomor_surat;
        if (empty($nomorSurat)) {
            $nomorSurat = self::generateNomorSurat($permohonan);
        }

        $permohonan->update([
            'status_permohonan' => $request->status,
            'catatan'           => $request->catatan,
            'nomor_surat'       => $nomorSurat,
        ]);

        $pesanKematian = null;
        if (in_array($request->status, ['selesai', 'diproses'])) {
            $pesanKematian = self::hapusPendudukMeninggal($permohonan);
        }

        $pesanSukses = 'Status pengajuan berhasil diperbarui.';
        if ($pesanKematian) {
            $pesanSukses .= ' ' . $pesanKematian;
        }

        return redirect()->back()
            ->with('success', $pesanSukses);
    }

    public function permohonanUploadSurat(Request $request, $id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'file_surat_scan' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if ($request->hasFile('file_surat_scan')) {
            if ($permohonan->file_surat_scan) {
                Storage::disk('public')->delete($permohonan->file_surat_scan);
            }

            $path = $request->file('file_surat_scan')->store('surat/selesai', 'public');
            $permohonan->update([
                'file_surat_scan' => $path,
                'status_permohonan' => 'selesai',
            ]);

            $pesanKematian = self::hapusPendudukMeninggal($permohonan);
            $pesanSukses = 'Surat berhasil diunggah.';
            if ($pesanKematian) {
                $pesanSukses .= ' ' . $pesanKematian;
            }

            return redirect()->back()
                ->with('success', $pesanSukses);
        }
        return redirect()->back();
    }

    public function permohonanCetak($id)
    {
        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])->findOrFail($id);
        $user = Auth::user();

        // Pengecekan akses: Penduduk hanya bisa melihat / mencetak surat miliknya sendiri
        if ($user->role == 'penduduk') {
            $penduduk = Penduduk::where('nik', $user->nik)->first();
            if (!$penduduk || $permohonan->id_penduduk != $penduduk->id_penduduk) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat atau mencetak surat ini.');
            }
        }

        $templatePath = $permohonan->jenisSurat->template_surat ?? null;

        // Cek jika template diupload berformat PDF
        if ($templatePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($templatePath) && str_ends_with(strtolower($templatePath), '.pdf')) {
            $path = storage_path('app/public/' . $templatePath);
            return response()->file($path);
        }

        // Cetak via DomPDF Blade View resmi desa (terstruktur, rapi, presisi & proporsional 1 halaman A4)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.templates.cetak_pdf', compact('permohonan'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Surat_' . str_replace(' ', '_', $permohonan->jenisSurat->nama_surat ?? 'Keterangan') . '_' . ($permohonan->penduduk->nik ?? $permohonan->id_permohonan) . '.pdf';

        return $pdf->stream($filename);
    }

    public function permohonanDestroy($id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);

        if ($permohonan->file_persyaratan) {
            Storage::disk('public')->delete($permohonan->file_persyaratan);
        }

        if ($permohonan->file_surat_scan) {
            Storage::disk('public')->delete($permohonan->file_surat_scan);
        }

        $permohonan->delete();

        return redirect()->route('surat.permohonan.index')
            ->with('success', 'Pengajuan surat berhasil dihapus.');
    }
    public function laporanIndex(Request $request)
    {
        $dari  = $request->input('dari',  now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));

        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])
            ->whereBetween('tanggal_pengajuan', [$dari, $sampai])
            ->latest('tanggal_pengajuan')
            ->get();

        return view('surat.laporan.index', compact('permohonan', 'dari', 'sampai'));
    }

    public function laporanCetakPdf(Request $request)
    {
        $dari   = $request->input('dari',   now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));

        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])
            ->whereBetween('tanggal_pengajuan', [$dari, $sampai])
            ->latest('tanggal_pengajuan')
            ->get();

        $profil     = \App\Models\ProfilDesa::first();
        $kepalaDesa = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kepala Desa%')->first();
        $kaurUmum   = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kaur Umum%')
                        ->orWhere('jabatan', 'LIKE', '%Kepala Urusan Umum%')->first();

        $periodeLabel = \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM Y')
                      . ' s/d '
                      . \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM Y');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.laporan.cetak_pdf', compact(
            'permohonan', 'dari', 'sampai', 'periodeLabel', 'profil', 'kepalaDesa', 'kaurUmum'
        ));
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Laporan_Pengajuan_Surat_' . $dari . '_sd_' . $sampai . '.pdf';
        return $pdf->stream($filename);
    }
}
