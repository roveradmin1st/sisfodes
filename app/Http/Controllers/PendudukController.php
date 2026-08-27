<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function publicIndex(Request $request)
    {
        $selectedDusun = $request->get('dusun');
        $search = $request->get('search');

        // Clean up and get all unique dusun for the filter dropdown
        $allDusunRaw = Penduduk::select('dusun')->distinct()->pluck('dusun')->toArray();
        $allDusun = [];
        foreach($allDusunRaw as $d) {
            $cleanName = strtoupper(trim($d));
            if (preg_match('/^(?:DUSUN\s+)?([IVX]+)(?:\s+.*)?$/', $cleanName, $matches)) {
                $cleanName = 'Dusun ' . $matches[1];
            } else {
                $cleanName = str_replace('DUSUN ', 'Dusun ', $cleanName);
            }
            
            if (!in_array($cleanName, $allDusun) && !empty($cleanName)) {
                $allDusun[] = $cleanName;
            }
        }
        sort($allDusun);

        // Base query with optional filter
        $query = Penduduk::query();
        if ($selectedDusun) {
            $query->where(function($q) use ($selectedDusun) {
                $upperSelected = strtoupper(trim($selectedDusun));
                $q->whereRaw('UPPER(TRIM(dusun)) = ?', [$upperSelected]);
                if (strpos($upperSelected, 'DUSUN ') === 0) {
                    $romanOnly = str_replace('DUSUN ', '', $upperSelected);
                    $q->orWhereRaw('UPPER(TRIM(dusun)) = ?', [$romanOnly]);
                }
            });
        }
        $totalPenduduk = Penduduk::count();
        $totalLaki     = Penduduk::where('jenis_kelamin', 'L')->count();
        $totalPerempuan= Penduduk::where('jenis_kelamin', 'P')->count();
        
        $genderData = [
            'Laki-laki' => $totalLaki,
            'Perempuan' => $totalPerempuan,
        ];

        $allDusunRaw = Penduduk::select('dusun')->distinct()->pluck('dusun')->toArray();

        $dusunDataRaw = Penduduk::selectRaw('UPPER(TRIM(dusun)) as raw_dusun, count(*) as count')
            ->groupBy('raw_dusun')
            ->pluck('count', 'raw_dusun')
            ->toArray();

        $agamaData = Penduduk::selectRaw('agama, count(*) as count')
            ->groupBy('agama')
            ->pluck('count', 'agama')
            ->toArray();

        $pekerjaanData = Penduduk::selectRaw('pekerjaan, count(*) as count')
            ->groupBy('pekerjaan')
            ->pluck('count', 'pekerjaan')
            ->toArray();

        $pendidikanData = Penduduk::selectRaw('pendidikan, count(*) as count')
            ->groupBy('pendidikan')
            ->pluck('count', 'pendidikan')
            ->toArray();

        $statusKawinData = Penduduk::selectRaw('status_perkawinan, count(*) as count')
            ->groupBy('status_perkawinan')
            ->pluck('count', 'status_perkawinan')
            ->toArray();

        $statusPendudukData = Penduduk::selectRaw('status_penduduk, count(*) as count')
            ->groupBy('status_penduduk')
            ->pluck('count', 'status_penduduk')
            ->toArray();

        // 2. Dusun Data
        $dusunData = [];
        foreach($dusunDataRaw as $k => $v) {
            $cleanName = strtoupper(trim($k));
            if (preg_match('/^(?:DUSUN\s+)?([IVX]+)(?:\s+.*)?$/', $cleanName, $matches)) {
                $cleanName = 'Dusun ' . $matches[1];
            } else {
                $cleanName = str_replace('DUSUN ', 'Dusun ', $cleanName);
            }
            
            if (isset($dusunData[$cleanName])) {
                $dusunData[$cleanName] += $v;
            } else {
                $dusunData[$cleanName] = $v;
            }
        }
        
        // Sort keys naturally (e.g. Dusun I, Dusun II, Dusun III)
        uksort($dusunData, function($a, $b) {
            return strnatcmp($a, $b);
        });

        // 3. Religion Data
        // 4. Pendidikan Data
        // 5. Pekerjaan Data
        $pekerjaanDataRaw = (clone $query)->selectRaw('pekerjaan, count(*) as count')
            ->groupBy('pekerjaan')
            ->orderByDesc('count')
            ->limit(10) // Limit to top 10 to avoid messy charts
            ->pluck('count', 'pekerjaan')
            ->toArray();
        // Group others if necessary
        $pekerjaanData = $pekerjaanDataRaw;

        // 6. Data List for Searchable Table
        $searchedPenduduk = null;
        if ($search) {
            $searchedPenduduk = Penduduk::where('nik', $search)->first();
        }

        return view('public.penduduk', compact(
            'genderData', 'dusunData', 'agamaData', 
            'pendidikanData', 'pekerjaanData',
            'allDusun', 'selectedDusun', 'searchedPenduduk', 'search'
        ));
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'aktif');

        if ($tab == 'meninggal') {
            $query = Penduduk::onlyTrashed()->with(['permohonanSurat' => function($q) {
                $q->whereHas('jenisSurat', function($js) {
                    $js->where('nama_surat', 'LIKE', '%kematian%');
                })->latest();
            }]);
        } else {
            $query = Penduduk::query();
        }

        // Filter Keyword
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama', 'LIKE', "%{$keyword}%")
                  ->orWhere('no_kk', 'LIKE', "%{$keyword}%")
                  ->orWhere('alamat', 'LIKE', "%{$keyword}%");
            });
        }

        // Filter Tahun Update Data
        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $query->where(function($q) use ($tahun) {
                $q->whereRaw("COALESCE(tahun, YEAR(created_at), 2025) = ?", [$tahun]);
            });
        }

        // Filter Dusun
        if ($request->filled('dusun')) {
            $dusun = $request->dusun;
            $query->where('dusun', 'LIKE', "%{$dusun}%");
        }

        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Hitung statistik kartu SEBELUM paginate() memodifikasi $query
        $baseQuery      = clone $query;
        $totalPenduduk  = (clone $baseQuery)->count();
        $kepalaKeluarga = (clone $baseQuery)->where('is_kepala_keluarga', 1)->count();
        $pendudukBaru   = Penduduk::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $pendudukLansia = (clone $baseQuery)->whereRaw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60")->count();

        $countAktif     = Penduduk::count();
        $countMeninggal = Penduduk::onlyTrashed()->count();

        // Jalankan pagination untuk tabel
        $penduduk = $query->latest()->paginate(10)->appends($request->all());

        // Ambil daftar tahun unik dari database
        $daftarTahun = Penduduk::selectRaw('COALESCE(tahun, YEAR(created_at), 2025) as thn')
            ->groupBy('thn')
            ->orderBy('thn', 'desc')
            ->pluck('thn')
            ->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [2026, 2025];
        }

        // Daftar Dusun untuk dropdown filter
        $daftarDusun = Penduduk::select('dusun')
            ->whereNotNull('dusun')
            ->distinct()
            ->orderBy('dusun', 'asc')
            ->pluck('dusun')
            ->toArray();

        return view('penduduk.index', compact(
            'penduduk',
            'totalPenduduk',
            'kepalaKeluarga',
            'pendudukBaru',
            'pendudukLansia',
            'daftarTahun',
            'daftarDusun',
            'tab',
            'countAktif',
            'countMeninggal'
        ));
    }

    public function cetakPdf(Request $request)
    {
        $tahunSelected = $request->get('tahun');

        // Query rekapitulasi per tahun inputan (2025, 2026, dst)
        $query = Penduduk::selectRaw("
            COALESCE(tahun, YEAR(created_at), 2025) as tahun_rekap,
            COUNT(*) as total_penduduk,
            SUM(CASE WHEN jenis_kelamin = 'L' THEN 1 ELSE 0 END) as total_l,
            SUM(CASE WHEN jenis_kelamin = 'P' THEN 1 ELSE 0 END) as total_p,
            SUM(CASE WHEN is_kepala_keluarga = 1 AND jenis_kelamin = 'L' THEN 1 ELSE 0 END) as kk_l,
            SUM(CASE WHEN is_kepala_keluarga = 1 AND jenis_kelamin = 'P' THEN 1 ELSE 0 END) as kk_p,
            SUM(CASE WHEN is_kepala_keluarga = 1 THEN 1 ELSE 0 END) as total_kk
        ")
        ->groupByRaw("COALESCE(tahun, YEAR(created_at), 2025)")
        ->orderByRaw("COALESCE(tahun, YEAR(created_at), 2025) ASC");

        if ($tahunSelected) {
            $query->havingRaw("tahun_rekap = ?", [$tahunSelected]);
        }

        $rekapDataRaw = $query->get();

        $rekapData = $rekapDataRaw->map(function($item) {
            $item->tahun = $item->tahun_rekap;
            return $item;
        });

        // Hitung Grand Total Rangkuman Seluruh Tahun
        $grandTotal = (object) [
            'total_penduduk' => $rekapData->sum('total_penduduk'),
            'total_l' => $rekapData->sum('total_l'),
            'total_p' => $rekapData->sum('total_p'),
            'kk_l' => $rekapData->sum('kk_l'),
            'kk_p' => $rekapData->sum('kk_p'),
            'total_kk' => $rekapData->sum('total_kk'),
        ];

        $profil = \App\Models\ProfilDesa::first();
        $kepalaDesa = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kepala Desa%')->first();
        $kaurUmum = \App\Models\PerangkatDesa::where('jabatan', 'LIKE', '%Kaur Umum%')->orWhere('jabatan', 'LIKE', '%Kepala Urusan Umum%')->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penduduk.cetak_pdf', compact(
            'rekapData', 'grandTotal', 'profil', 'kepalaDesa', 'kaurUmum', 'tahunSelected'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Rekapitulasi_Data_Penduduk_Desa_Sidomulyo.pdf');
    }

    public function detailKk($no_kk)
    {
        $anggotaKeluarga = Penduduk::where('no_kk', $no_kk)
            ->orderByDesc('is_kepala_keluarga')
            ->orderBy('tanggal_lahir', 'asc')
            ->get();

        if ($anggotaKeluarga->isEmpty()) {
            abort(404, 'Kartu Keluarga tidak ditemukan.');
        }

        $kepalaKeluarga = $anggotaKeluarga->where('is_kepala_keluarga', 1)->first() ?? $anggotaKeluarga->first();

        return view('penduduk.kk_show', compact('no_kk', 'anggotaKeluarga', 'kepalaKeluarga'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function create(Request $request)
    {
        $no_kk = $request->get('no_kk');
        $mode = $request->get('mode', $no_kk ? 'anggota' : 'kepala');

        $kkPreset = null;
        if ($no_kk) {
            $kkPreset = Penduduk::where('no_kk', $no_kk)->first();
        }

        return view('penduduk.create', compact('no_kk', 'mode', 'kkPreset'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'no_kk' => 'required|string|size:16',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:20',
            'kewarganegaraan' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara',
            'is_kepala_keluarga' => 'nullable|boolean',
            'hubungan_keluarga' => 'nullable|string|max:50',
            'tahun' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['kewarganegaraan'] = $request->kewarganegaraan ?: 'WNI';

        if ($request->has('is_kepala_keluarga') && $request->is_kepala_keluarga == 1) {
            $data['is_kepala_keluarga'] = 1;
            $data['hubungan_keluarga'] = 'Kepala Keluarga';
        } else {
            $data['is_kepala_keluarga'] = 0;
            $data['hubungan_keluarga'] = $request->hubungan_keluarga ?: 'Anggota Keluarga';
        }

        $data['tahun'] = $request->tahun ?: date('Y');

        Penduduk::create($data);

        if ($request->filled('from_kk')) {
            return redirect()->route('penduduk.kk.show', $request->no_kk)
                ->with('success', 'Anggota keluarga baru berhasil ditambahkan ke Kartu Keluarga.');
        }

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        return view('penduduk.show', compact('penduduk'));
    }

    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        return view('penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik,'.$id.',id_penduduk',
            'no_kk' => 'required|string|size:16',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:20',
            'kewarganegaraan' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara',
            'is_kepala_keluarga' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['kewarganegaraan'] = $request->kewarganegaraan ?: 'WNI';
        $data['is_kepala_keluarga'] = $request->has('is_kepala_keluarga') ? 1 : 0;

        $penduduk->update($data);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        
        // Hapus akun user yang terkait dengan NIK ini jika ada
        $user = \App\Models\User::where('nik', $penduduk->nik)->first();
        if ($user) {
            $user->delete();
        }

        $penduduk->delete();

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk beserta akun login (jika ada) berhasil dihapus.');
    }
}
