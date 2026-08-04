<?php

namespace App\Http\Controllers;

use App\Models\UmkmDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmDesaController extends Controller
{
    // ==================== KAUR UMUM (ADMIN) ====================
    public function index(Request $request)
    {
        $query = UmkmDesa::latest();

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($q) use ($keyword) {
                $q->where('nama_usaha', 'LIKE', "%{$keyword}%")
                  ->orWhere('pemilik', 'LIKE', "%{$keyword}%")
                  ->orWhere('kategori', 'LIKE', "%{$keyword}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $umkm = $query->paginate(10)->appends($request->all());

        return view('umkm.index', compact('umkm'));
    }

    public function create()
    {
        return view('umkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'pemilik' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'harga' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'status' => 'required|in:publish,draft',
        ]);

        $data = $request->only([
            'nama_usaha',
            'pemilik',
            'kategori',
            'deskripsi',
            'alamat',
            'no_hp',
            'harga',
            'status',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        UmkmDesa::create($data);

        return redirect()->route('umkm.index')
            ->with('success', 'Data UMKM Desa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $umkm = UmkmDesa::findOrFail($id);

        return view('umkm.show', compact('umkm'));
    }

    public function edit($id)
    {
        $umkm = UmkmDesa::findOrFail($id);

        return view('umkm.edit', compact('umkm'));
    }

    public function update(Request $request, $id)
    {
        $umkm = UmkmDesa::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:150',
            'pemilik' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'harga' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'status' => 'required|in:publish,draft',
        ]);

        $data = $request->only([
            'nama_usaha',
            'pemilik',
            'kategori',
            'deskripsi',
            'alamat',
            'no_hp',
            'harga',
            'status',
        ]);

        if ($request->hasFile('foto')) {
            if ($umkm->foto) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($data);

        return redirect()->route('umkm.index')
            ->with('success', 'Data UMKM Desa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $umkm = UmkmDesa::findOrFail($id);

        if ($umkm->foto) {
            Storage::disk('public')->delete($umkm->foto);
        }

        $umkm->delete();

        return redirect()->route('umkm.index')
            ->with('success', 'Data UMKM Desa berhasil dihapus!');
    }

    // ==================== FRONTEND (PUBLIC) ====================
    public function publicIndex(Request $request)
    {
        $query = UmkmDesa::where('status', 'publish')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function($q) use ($keyword) {
                $q->where('nama_usaha', 'LIKE', "%{$keyword}%")
                  ->orWhere('pemilik', 'LIKE', "%{$keyword}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
            });
        }

        $umkm = $query->paginate(12)->appends($request->all());

        return view('public.umkm', compact('umkm'));
    }

    public function publicShow($id)
    {
        $umkm = UmkmDesa::where('status', 'publish')->findOrFail($id);

        $umkmLainnya = UmkmDesa::where('status', 'publish')
            ->where('id_umkm', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

        return view('public.umkm-detail', compact('umkm', 'umkmLainnya'));
    }
}
