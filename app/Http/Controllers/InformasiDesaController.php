<?php

namespace App\Http\Controllers;

use App\Models\InformasiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InformasiDesaController extends Controller
{
    public function index()
    {
        $informasi = InformasiDesa::latest()->paginate(10);

        return view('informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('informasi.create');
    }

    public function store(Request $request)
    {
        // Validasi kategori
        $request->validate([
            'kategori' => 'required|in:berita,pengumuman,agenda,galeri',
        ]);

        $kategori = $request->kategori;
        $data = [];
        $data['kategori'] = $kategori;
        $data['tanggal_posting'] = now()->format('Y-m-d');
        $data['penulis'] = Auth::user()->nama;

        // ========================================== //
        // BERITA                                      //
        // ========================================== //
        if ($kategori == 'berita') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status_publish' => 'required|in:publish,draft',
            ]);

            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
            $data['status_publish'] = $request->status_publish;

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('informasi', 'public');
                $data['gambar'] = $path;
            }
        }

        // ========================================== //
        // PENGUMUMAN                                  //
        // ========================================== //
        elseif ($kategori == 'pengumuman') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'status_publish' => 'required|in:publish,draft',
            ]);

            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
            $data['status_publish'] = $request->status_publish;
        }

        // ========================================== //
        // AGENDA KEGIATAN                             //
        // ========================================== //
        elseif ($kategori == 'agenda') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'waktu_pelaksanaan' => 'nullable|date',
                'status_publish' => 'required|in:publish,draft',
            ]);

            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
            $data['status_publish'] = $request->status_publish;

            if ($request->waktu_pelaksanaan) {
                $data['waktu_pelaksanaan'] = $request->waktu_pelaksanaan;
            }
        }

        // ========================================== //
        // GALERI                                      //
        // ========================================== //
        elseif ($kategori == 'galeri') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'nullable|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status_publish' => 'required|in:publish,draft',
            ]);

            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi ?? '';
            $data['status_publish'] = $request->status_publish;

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('informasi', 'public');
                $data['gambar'] = $path;
            }
        }

        // Simpan ke database
        InformasiDesa::create($data);

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil dipublikasikan.');
    }

    public function show($id)
    {
        $informasi = InformasiDesa::findOrFail($id);

        return view('informasi.show', compact('informasi'));
    }

    public function edit($id)
    {
        $informasi = InformasiDesa::findOrFail($id);

        return view('informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = InformasiDesa::findOrFail($id);

        // Validasi dasar
        $request->validate([
            'kategori' => 'required|in:berita,pengumuman,agenda,galeri',
            'status_publish' => 'required|in:publish,draft',
        ]);

        $data = [];
        $data['kategori'] = $request->kategori;
        $data['status_publish'] = $request->status_publish;

        // ========================================== //
        // BERITA                                      //
        // ========================================== //
        if ($request->kategori == 'berita') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
        }

        // ========================================== //
        // PENGUMUMAN                                  //
        // ========================================== //
        elseif ($request->kategori == 'pengumuman') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
            ]);
            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
        }

        // ========================================== //
        // AGENDA KEGIATAN                             //
        // ========================================== //
        elseif ($request->kategori == 'agenda') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'required|string',
                'waktu_pelaksanaan' => 'nullable|date',
            ]);
            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi;
            if ($request->waktu_pelaksanaan) {
                $data['waktu_pelaksanaan'] = $request->waktu_pelaksanaan;
            }
        }

        // ========================================== //
        // GALERI                                      //
        // ========================================== //
        elseif ($request->kategori == 'galeri') {
            $request->validate([
                'judul' => 'required|string|max:200',
                'isi' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $data['judul'] = $request->judul;
            $data['isi'] = $request->isi ?? '';
        }

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($informasi->gambar) {
                Storage::disk('public')->delete($informasi->gambar);
            }
            $path = $request->file('gambar')->store('informasi', 'public');
            $data['gambar'] = $path;
        }

        // Update data
        $informasi->update($data);

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = InformasiDesa::findOrFail($id);

        if ($informasi->gambar) {
            Storage::disk('public')->delete($informasi->gambar);
        }

        $informasi->delete();

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil dihapus.');
    }

    // ========================================== //
    // FRONTEND                                    //
    // ========================================== //
    public function publicIndex()
    {
        $berita = InformasiDesa::where('kategori', 'berita')
            ->where('status_publish', 'publish')
            ->latest()
            ->take(4)
            ->get();

        $pengumuman = InformasiDesa::where('kategori', 'pengumuman')
            ->where('status_publish', 'publish')
            ->latest()
            ->take(3)
            ->get();

        $agenda = InformasiDesa::where('kategori', 'agenda')
            ->where('status_publish', 'publish')
            ->latest()
            ->take(3)
            ->get();

        $galeri = InformasiDesa::where('kategori', 'galeri')
            ->where('status_publish', 'publish')
            ->latest()
            ->take(6)
            ->get();

        return view('public.informasi', compact('berita', 'pengumuman', 'agenda', 'galeri'));
    }

    public function publicShow($id)
    {
        $informasi = InformasiDesa::where('status_publish', 'publish')->findOrFail($id);

        $beritaTerkait = InformasiDesa::where('status_publish', 'publish')
            ->where('id_informasi', '!=', $id)
            ->latest()
            ->take(4)
            ->get();

        return view('public.informasi-detail', compact('informasi', 'beritaTerkait'));
    }
}
