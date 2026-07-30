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
    public function index()
    {
        $penerima = PenerimaBantuan::with('penduduk')
            ->latest()
            ->paginate(10);

        return view('bantuan.index', compact('penerima'));
    }

    public function create()
    {
        $penduduk = Penduduk::select('id_penduduk', 'nama', 'nik')->get();

        return view('bantuan.create', compact('penduduk'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_penduduk' => 'required|exists:penduduk,id_penduduk',
            'program_bantuan' => 'required|string|max:100',
            'tanggal_terima' => 'required|date',
            'status' => 'required|in:diterima,dialihkan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        PenerimaBantuan::create($request->all());

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
        $penduduk = Penduduk::select('id_penduduk', 'nama', 'nik')->get();

        return view('bantuan.edit', compact('penerima', 'penduduk'));
    }

    public function update(Request $request, $id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_penduduk' => 'required|exists:penduduk,id_penduduk',
            'program_bantuan' => 'required|string|max:100',
            'tanggal_terima' => 'required|date',
            'status' => 'required|in:diterima,dialihkan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $penerima->update($request->all());

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

    // ==================== FILTER STATUS ====================
    public function filter(Request $request)
    {
        $query = PenerimaBantuan::with('penduduk');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $penerima = $query->latest()->paginate(10);

        return view('bantuan.index', compact('penerima'));
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

        // Ambil data bantuan berdasarkan penduduk yang login
        $penerima = PenerimaBantuan::with('penduduk')
            ->where('id_penduduk', $penduduk->id_penduduk)
            ->where('status', 'diterima')
            ->latest()
            ->paginate(10);

        return view('bantuan.penduduk', compact('penerima'));
    }

    // ==================== FRONTEND (PUBLIC) ====================
    public function publicIndex()
    {
        $penerima = PenerimaBantuan::with('penduduk')
            ->where('status', 'diterima')
            ->latest()
            ->paginate(15);

        return view('public.bantuan', compact('penerima'));
    }
}
