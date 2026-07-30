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
            'file_persyaratan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['tanggal_pengajuan'] = now()->format('Y-m-d');
        $data['status_permohonan'] = 'menunggu';

        if ($request->hasFile('file_persyaratan')) {
            $path = $request->file('file_persyaratan')->store('surat/persyaratan', 'public');
            $data['file_persyaratan'] = $path;
        }

        PermohonanSurat::create($data);

        return redirect()->route('surat.permohonan.index')
            ->with('success', 'Pengajuan surat berhasil dikirim.');
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
        $permohonan = PermohonanSurat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $permohonan->update([
            'status_permohonan' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()
            ->with('success', 'Status pengajuan berhasil diperbarui.');
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
        }

        return redirect()->back()
            ->with('success', 'Surat berhasil diunggah.');
    }

    public function permohonanCetak($id)
    {
        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])->findOrFail($id);

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
}
