<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        $perangkatData = PerangkatDesa::all();

        return view('perangkat.index', compact('perangkatData'));
    }

    public function create()
    {
        return view('perangkat.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('perangkat', 'public');
            $data['foto'] = $path;
        }

        PerangkatDesa::create($data);

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $perangkat = PerangkatDesa::findOrFail($id);

        return view('perangkat.edit', compact('perangkat'));
    }

    public function update(Request $request, $id)
    {
        $perangkat = PerangkatDesa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($perangkat->foto) {
                Storage::disk('public')->delete($perangkat->foto);
            }
            $path = $request->file('foto')->store('perangkat', 'public');
            $data['foto'] = $path;
        }

        $perangkat->update($data);

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $perangkat = PerangkatDesa::findOrFail($id);

        if ($perangkat->foto) {
            Storage::disk('public')->delete($perangkat->foto);
        }

        $perangkat->delete();

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat desa berhasil dihapus.');
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $jabatans = $request->input('jabatan', []);
        $namas = $request->input('nama', []);

        $perangkatList = PerangkatDesa::whereIn('jabatan', $jabatans)->get()->keyBy('jabatan');

        foreach ($jabatans as $index => $jabatan) {
            $nama = trim($namas[$index] ?? '');

            // Cari data perangkat berdasarkan jabatan
            $perangkat = $perangkatList->get($jabatan);

            if ($nama) {
                // Jika ada nama, update atau create
                if (!$perangkat) {
                    $perangkat = new PerangkatDesa;
                    $perangkat->jabatan = $jabatan;
                }
                $perangkat->nama = $nama;

                // Cek opsi hapus foto jika dicentang
                if ($request->has("hapus_foto.$index")) {
                    if ($perangkat->foto && Storage::disk('public')->exists($perangkat->foto)) {
                        Storage::disk('public')->delete($perangkat->foto);
                    }
                    $perangkat->foto = null;
                }

                // Handle upload foto baru untuk index ini
                if ($request->hasFile("foto.$index")) {
                    if ($perangkat->foto && Storage::disk('public')->exists($perangkat->foto)) {
                        Storage::disk('public')->delete($perangkat->foto);
                    }
                    $path = $request->file("foto.$index")->store('perangkat', 'public');
                    $perangkat->foto = $path;
                }

                $perangkat->save();
            } else {
                // Jika nama kosong, hapus data jika ada
                if ($perangkat) {
                    if ($perangkat->foto && Storage::disk('public')->exists($perangkat->foto)) {
                        Storage::disk('public')->delete($perangkat->foto);
                    }
                    $perangkat->delete();
                }
            }
        }

        return redirect()->route('perangkat.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui!');
    }

    // ==================== FRONTEND ====================
    public function publicIndex()
    {
        $perangkat = PerangkatDesa::all();

        $kepala = $perangkat->where('jabatan', 'Kepala Desa')->first();
        $sekretaris = $perangkat->where('jabatan', 'Sekretaris Desa')->first();
        $seksi = $perangkat->filter(function ($item) {
            return str_contains($item->jabatan, 'Kepala Seksi');
        })->values();
        $urusan = $perangkat->filter(function ($item) {
            return str_contains($item->jabatan, 'Kepala Urusan');
        })->values();
        $dusun = $perangkat->filter(function ($item) {
            return str_contains($item->jabatan, 'Kepala Dusun');
        })->values();

        $orgData = $this->buildOrgChartData($kepala, $sekretaris, $seksi, $urusan, $dusun);

        return view('public.perangkat', compact('kepala', 'sekretaris', 'seksi', 'urusan', 'dusun', 'orgData'));
    }

    private function buildOrgChartData($kepala, $sekretaris, $seksi, $urusan, $dusun)
    {
        $seksiUrutan = [];
        foreach ($seksi as $item) {
            if (str_contains($item->jabatan, 'Pelayanan')) {
                $seksiUrutan[1] = $item;
            } elseif (str_contains($item->jabatan, 'Kesejahteraan')) {
                $seksiUrutan[2] = $item;
            } elseif (str_contains($item->jabatan, 'Pemerintahan')) {
                $seksiUrutan[3] = $item;
            }
        }
        ksort($seksiUrutan);
        $seksi = collect($seksiUrutan)->values();

        $children = [];
        foreach ($seksi as $item) {
            $children[] = [
                'name' => $item->nama,
                'title' => $item->jabatan,
                'children' => [],
            ];
        }

        if ($sekretaris) {
            $kaurChildren = [];
            foreach ($urusan as $item) {
                $kaurChildren[] = [
                    'name' => $item->nama,
                    'title' => $item->jabatan,
                    'children' => [],
                ];
            }
            $children[] = [
                'name' => $sekretaris->nama,
                'title' => $sekretaris->jabatan,
                'children' => $kaurChildren,
            ];
        }

        $dusunChildren = [];
        foreach ($dusun as $item) {
            $dusunChildren[] = [
                'name' => $item->nama,
                'title' => $item->jabatan,
                'children' => [],
            ];
        }

        return [
            'name' => $kepala ? $kepala->nama : 'Kepala Desa',
            'title' => 'Kepala Desa',
            'children' => array_merge($children, $dusunChildren),
        ];
    }
}
