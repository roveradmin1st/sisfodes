<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KritikSaranController extends Controller
{
    // ==================== INDEX (KAUR UMUM & KEPALA DESA) ====================
    public function index()
    {
        $kritikSaran = KritikSaran::latest()->paginate(10);

        return view('kritik-saran.index', compact('kritikSaran'));
    }

    // ==================== BALAS (HANYA KAUR UMUM) ====================
    public function balas(Request $request, $id)
    {
        $kritikSaran = KritikSaran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'balasan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $kritikSaran->update([
            'balasan' => $request->balasan,
            'status' => 'dibalas',
        ]);

        return redirect()->route('kritik-saran.index')
            ->with('success', 'Balasan berhasil dikirim.');
    }

    // ==================== HAPUS (HANYA KAUR UMUM) ====================
    public function destroy($id)
    {
        $kritikSaran = KritikSaran::findOrFail($id);
        $kritikSaran->delete();

        return redirect()->route('kritik-saran.index')
            ->with('success', 'Kritik dan saran berhasil dihapus.');
    }

    // ==================== PENDUDUK ====================
    public function pendudukIndex()
    {
        $user = Auth::user();

        $kritikSaran = KritikSaran::where('nama_pengirim', $user->nama)
            ->latest()
            ->paginate(10);

        return view('kritik-saran.penduduk', compact('kritikSaran'));
    }

    public function pendudukStore(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'subjek' => 'required|string|max:200',
            'isi_pesan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesan = 'Subjek: '.$request->subjek."\n\n".$request->isi_pesan;

        KritikSaran::create([
            'nama_pengirim' => $user->nama,
            'email' => $user->email ?? '-',
            'isi_pesan' => $pesan,
            'status' => 'dibaca',
        ]);

        return redirect()->route('kritik-saran.penduduk')
            ->with('success', 'Kritik dan saran berhasil dikirim.');
    }
}
