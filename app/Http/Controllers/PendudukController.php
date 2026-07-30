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
          $cacheTtl = 60 * 24; // Cache for 24 hours (or until cleared)
        
        $totalPenduduk = \Illuminate\Support\Facades\Cache::remember('stat_total_penduduk', $cacheTtl, function() {
            return Penduduk::count();
        });

        $totalLaki = \Illuminate\Support\Facades\Cache::remember('stat_total_laki', $cacheTtl, function() {
            return Penduduk::where('jenis_kelamin', 'L')->count();
        });

        $totalPerempuan = \Illuminate\Support\Facades\Cache::remember('stat_total_perempuan', $cacheTtl, function() {
            return Penduduk::where('jenis_kelamin', 'P')->count();
        });
        
        $genderData = [
            'Laki-laki' => $totalLaki,
            'Perempuan' => $totalPerempuan,
        ];

        $allDusunRaw = \Illuminate\Support\Facades\Cache::remember('stat_all_dusun', $cacheTtl, function() {
            return Penduduk::select('dusun')->distinct()->pluck('dusun')->toArray();
        });

        $dusunDataRaw = \Illuminate\Support\Facades\Cache::remember('stat_dusun_data', $cacheTtl, function() {
            return Penduduk::selectRaw('UPPER(TRIM(dusun)) as raw_dusun, count(*) as count')
                ->groupBy('raw_dusun')
                ->pluck('count', 'raw_dusun')
                ->toArray();
        });

        $agamaData = \Illuminate\Support\Facades\Cache::remember('stat_agama_data', $cacheTtl, function() {
            return Penduduk::selectRaw('agama, count(*) as count')
                ->groupBy('agama')
                ->pluck('count', 'agama')
                ->toArray();
        });

        $pekerjaanData = \Illuminate\Support\Facades\Cache::remember('stat_pekerjaan_data', $cacheTtl, function() {
            return Penduduk::selectRaw('pekerjaan, count(*) as count')
                ->groupBy('pekerjaan')
                ->pluck('count', 'pekerjaan')
                ->toArray();
        });

        $pendidikanData = \Illuminate\Support\Facades\Cache::remember('stat_pendidikan_data', $cacheTtl, function() {
            return Penduduk::selectRaw('pendidikan, count(*) as count')
                ->groupBy('pendidikan')
                ->pluck('count', 'pendidikan')
                ->toArray();
        });

        $statusKawinData = \Illuminate\Support\Facades\Cache::remember('stat_kawin_data', $cacheTtl, function() {
            return Penduduk::selectRaw('status_perkawinan, count(*) as count')
                ->groupBy('status_perkawinan')
                ->pluck('count', 'status_perkawinan')
                ->toArray();
        });

        $statusPendudukData = \Illuminate\Support\Facades\Cache::remember('stat_status_data', $cacheTtl, function() {
            return Penduduk::selectRaw('status_penduduk, count(*) as count')
                ->groupBy('status_penduduk')
                ->pluck('count', 'status_penduduk')
                ->toArray();
        });

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

        return view('public.penduduk', compact(
            'genderData', 'dusunData', 'agamaData', 
            'pendidikanData', 'pekerjaanData',
            'allDusun', 'selectedDusun'
        ));
    }

    public function index()
    {
        $penduduk = Penduduk::latest()->paginate(10);
        $totalPenduduk = Penduduk::count();
        $kepalaKeluarga = Penduduk::where('is_kepala_keluarga', 1)->count();
        $pendudukBaru = Penduduk::whereMonth('created_at', now()->month)->count();
        $pendudukLansia = Penduduk::where('tanggal_lahir', '<=', now()->subYears(60))->count();

        return view('penduduk.index', compact(
            'penduduk',
            'totalPenduduk',
            'kepalaKeluarga',
            'pendudukBaru',
            'pendudukLansia'
        ));
    }

    public function create()
    {
        return view('penduduk.create');
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
            'alamat' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara',
            'is_kepala_keluarga' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_kepala_keluarga'] = $request->has('is_kepala_keluarga') ? 1 : 0;

        Penduduk::create($data);

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
            'alamat' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara',
            'is_kepala_keluarga' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
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

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $penduduk = Penduduk::where('nik', 'LIKE', "%{$keyword}%")
            ->orWhere('nama', 'LIKE', "%{$keyword}%")
            ->orWhere('no_kk', 'LIKE', "%{$keyword}%")
            ->orWhere('alamat', 'LIKE', "%{$keyword}%")
            ->paginate(10);

        $totalPenduduk = Penduduk::count();
        $kepalaKeluarga = Penduduk::where('is_kepala_keluarga', 1)->count();
        $pendudukBaru = Penduduk::whereMonth('created_at', now()->month)->count();
        $pendudukLansia = Penduduk::where('tanggal_lahir', '<=', now()->subYears(60))->count();

        return view('penduduk.index', compact(
            'penduduk',
            'totalPenduduk',
            'kepalaKeluarga',
            'pendudukBaru',
            'pendudukLansia'
        ));
    }
}
