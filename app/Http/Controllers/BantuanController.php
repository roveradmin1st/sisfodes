<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\PenerimaBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BantuanController extends Controller
{
    // ==================== ADMIN ====================
    public function index(Request $request)
    {
        $query = PenerimaBantuan::with('penduduk');

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($subQuery) use ($keyword) {
                $subQuery->whereHas('penduduk', function ($q) use ($keyword) {
                    $q->where('nama', 'LIKE', "%{$keyword}%")
                      ->orWhere('nik', 'LIKE', "%{$keyword}%")
                      ->orWhere('no_kk', 'LIKE', "%{$keyword}%")
                      ->orWhere('alamat', 'LIKE', "%{$keyword}%");
                })->orWhere('program_bantuan', 'LIKE', "%{$keyword}%")
                  ->orWhere('keterangan', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penerima = $query->latest()->paginate(10)->appends($request->all());

        return view('bantuan.index', compact('penerima'));
    }

    public function create()
    {
        return view('bantuan.create');
    }

    public function searchPenduduk(Request $request)
    {
        $nik = trim($request->get('nik', ''));
        $q = trim($request->get('q', ''));

        if ($nik !== '') {
            $penduduk = Penduduk::where('nik', $nik)->first();
            return response()->json($penduduk);
        }

        if (strlen($q) >= 2) {
            $penduduk = Penduduk::where('nama', 'LIKE', "%{$q}%")
                ->orWhere('nik', 'LIKE', "%{$q}%")
                ->orderBy('nama', 'asc')
                ->select('id_penduduk', 'nama', 'nik', 'no_kk', 'alamat', 'pekerjaan', 'tanggal_lahir', 'jenis_kelamin')
                ->limit(10)
                ->get();
            return response()->json($penduduk);
        }

        return response()->json(null);
    }

    public function store(Request $request)
    {
        if ($request->program_bantuan === 'Lainnya' && $request->filled('program_bantuan_lainnya')) {
            $request->merge(['program_bantuan' => $request->program_bantuan_lainnya]);
        }

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|min:15|max:16',
            'nama' => 'required|string|max:100',
            'no_kk' => 'nullable|string|max:16',
            'alamat' => 'nullable|string',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'program_bantuan' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:150',
            'tanggal_terima' => 'required|date',
            'status' => 'required|in:diterima,dialihkan,diproses',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cari atau buat data penduduk baru dari data yang diketik
        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            $penduduk = Penduduk::create([
                'nik' => $request->nik,
                'no_kk' => $request->no_kk ?: $request->nik,
                'nama' => strtoupper($request->nama),
                'tempat_lahir' => 'Deli Serdang',
                'tanggal_lahir' => $request->tanggal_lahir ?: now()->subYears(30)->format('Y-m-d'),
                'jenis_kelamin' => $request->jenis_kelamin ?: 'L',
                'agama' => 'Islam',
                'alamat' => $request->alamat ?: 'Desa Sidomulyo',
                'dusun' => 'Dusun I',
                'pekerjaan' => $request->pekerjaan ?: 'Lainnya',
                'status_penduduk' => 'tetap',
            ]);
        } else {
            // Update jika ada perubahan data warga
            $updateData = [];
            if ($request->filled('nama')) $updateData['nama'] = strtoupper($request->nama);
            if ($request->filled('no_kk')) $updateData['no_kk'] = $request->no_kk;
            if ($request->filled('alamat')) $updateData['alamat'] = $request->alamat;
            if ($request->filled('pekerjaan')) $updateData['pekerjaan'] = $request->pekerjaan;
            if ($request->filled('jenis_kelamin')) $updateData['jenis_kelamin'] = $request->jenis_kelamin;
            if ($request->filled('tanggal_lahir')) $updateData['tanggal_lahir'] = $request->tanggal_lahir;

            if (!empty($updateData)) {
                $penduduk->update($updateData);
            }
        }

        PenerimaBantuan::create([
            'id_penduduk' => $penduduk->id_penduduk,
            'program_bantuan' => $request->program_bantuan,
            'keterangan' => $request->keterangan,
            'tanggal_terima' => $request->tanggal_terima,
            'status' => $request->status,
        ]);

        return redirect()->route('bantuan.index')
            ->with('success', 'Data penerima bantuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penerima = PenerimaBantuan::with('penduduk')->findOrFail($id);

        return view('bantuan.show', compact('penerima'));
    }

    public function edit($id)
    {
        $penerima = PenerimaBantuan::with('penduduk')->findOrFail($id);

        return view('bantuan.edit', compact('penerima'));
    }

    public function update(Request $request, $id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);

        if ($request->program_bantuan === 'Lainnya' && $request->filled('program_bantuan_lainnya')) {
            $request->merge(['program_bantuan' => $request->program_bantuan_lainnya]);
        }

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|min:15|max:16',
            'nama' => 'required|string|max:100',
            'no_kk' => 'nullable|string|max:16',
            'alamat' => 'nullable|string',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'program_bantuan' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:150',
            'tanggal_terima' => 'required|date',
            'status' => 'required|in:diterima,dialihkan,diproses',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            $penduduk = Penduduk::create([
                'nik' => $request->nik,
                'no_kk' => $request->no_kk ?: $request->nik,
                'nama' => strtoupper($request->nama),
                'tempat_lahir' => 'Deli Serdang',
                'tanggal_lahir' => $request->tanggal_lahir ?: now()->subYears(30)->format('Y-m-d'),
                'jenis_kelamin' => $request->jenis_kelamin ?: 'L',
                'agama' => 'Islam',
                'alamat' => $request->alamat ?: 'Desa Sidomulyo',
                'dusun' => 'Dusun I',
                'pekerjaan' => $request->pekerjaan ?: 'Lainnya',
                'status_penduduk' => 'tetap',
            ]);
        } else {
            $updateData = [];
            if ($request->filled('nama')) $updateData['nama'] = strtoupper($request->nama);
            if ($request->filled('no_kk')) $updateData['no_kk'] = $request->no_kk;
            if ($request->filled('alamat')) $updateData['alamat'] = $request->alamat;
            if ($request->filled('pekerjaan')) $updateData['pekerjaan'] = $request->pekerjaan;
            if ($request->filled('jenis_kelamin')) $updateData['jenis_kelamin'] = $request->jenis_kelamin;
            if ($request->filled('tanggal_lahir')) $updateData['tanggal_lahir'] = $request->tanggal_lahir;

            if (!empty($updateData)) {
                $penduduk->update($updateData);
            }
        }

        $penerima->update([
            'id_penduduk' => $penduduk->id_penduduk,
            'program_bantuan' => $request->program_bantuan,
            'keterangan' => $request->keterangan,
            'tanggal_terima' => $request->tanggal_terima,
            'status' => $request->status,
        ]);

        return redirect()->route('bantuan.index')
            ->with('success', 'Data penerima bantuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);
        $penerima->delete();

        return redirect()->route('bantuan.index')
            ->with('success', 'Data penerima bantuan berhasil dihapus.');
    }

    // ==================== FILTER & SEARCH ====================
    public function filter(Request $request)
    {
        return $this->index($request);
    }

    // ==================== CETAK PDF ====================
    public function cetakPdf(Request $request)
    {
        $query = PenerimaBantuan::with('penduduk');

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($subQuery) use ($keyword) {
                $subQuery->whereHas('penduduk', function ($q) use ($keyword) {
                    $q->where('nama', 'LIKE', "%{$keyword}%")
                      ->orWhere('nik', 'LIKE', "%{$keyword}%")
                      ->orWhere('no_kk', 'LIKE', "%{$keyword}%")
                      ->orWhere('alamat', 'LIKE', "%{$keyword}%");
                })->orWhere('program_bantuan', 'LIKE', "%{$keyword}%")
                  ->orWhere('keterangan', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data dan urutkan penerima bantuan sesuai abjad nama warga (A-Z) serta reset indeks array
        $penerima = $query->get()->sortBy(function ($item) {
            return strtolower(optional($item->penduduk)->nama ?? '');
        })->values();

        $profil = \App\Models\ProfilDesa::first();
        $kepalaDesa = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kepala Desa%')->first();
        $kaurUmum = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kaur Umum%')->orWhere('jabatan', 'LIKE', '%Kepala Urusan Umum%')->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bantuan.cetak_pdf', compact('penerima', 'profil', 'kepalaDesa', 'kaurUmum', 'request'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Data_Penerima_Bantuan_Desa_Sidomulyo.pdf');
    }

    // ==================== PENDUDUK (HANYA LIHAT) ====================
    public function pendudukIndex()
    {
        // Cek login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek role - hanya penduduk yang bisa
        if ($user->role != 'penduduk') {
            return redirect('/dashboard/'.$user->role)
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $penduduk = Penduduk::where('nik', $user->nik)->first();

        if (! $penduduk) {
            return redirect()->route('dashboard.penduduk')
                ->with('error', 'Data penduduk tidak ditemukan.');
        }

        // Ambil data bantuan berdasarkan penduduk yang login (termasuk status diproses dan diterima)
        $penerima = PenerimaBantuan::with('penduduk')
            ->where('id_penduduk', $penduduk->id_penduduk)
            ->whereIn('status', ['diterima', 'diproses'])
            ->latest()
            ->paginate(10);

        return view('bantuan.penduduk', compact('penerima'));
    }

    // ==================== FRONTEND (PUBLIC) ====================
    public function publicIndex(Request $request)
    {
        $query = PenerimaBantuan::with('penduduk')
            ->whereIn('status', ['diterima', 'diproses']);

        // Filter Pencarian Nama / NIK / Alamat
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($subQuery) use ($keyword) {
                $subQuery->whereHas('penduduk', function ($q) use ($keyword) {
                    $q->where('nama', 'LIKE', "%{$keyword}%")
                      ->orWhere('nik', 'LIKE', "%{$keyword}%")
                      ->orWhere('alamat', 'LIKE', "%{$keyword}%");
                })->orWhere('program_bantuan', 'LIKE', "%{$keyword}%");
            });
        }

        // Jika tahun dipilih, filter berdasarkan tahun. Jika belum dipilih, data diset kosong secara default.
        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $query->where(function($q) use ($tahun) {
                $q->whereYear('tanggal_terima', $tahun)
                  ->orWhere('program_bantuan', 'LIKE', "%{$tahun}%");
            });

            $penerima = $query->latest()->paginate(15)->appends($request->all());
        } else {
            // Data penerima bantuan kosong sebelum tahun dipilih
            $penerima = PenerimaBantuan::whereRaw('1 = 0')->paginate(15)->appends($request->all());
        }

        // Ambil daftar tahun unik dari database
        $daftarTahun = PenerimaBantuan::selectRaw('YEAR(tanggal_terima) as tahun')
            ->whereNotNull('tanggal_terima')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [2026, 2025, 2024];
        }

        return view('public.bantuan', compact('penerima', 'daftarTahun'));
    }
}
