<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use App\Models\Penduduk;
use App\Models\PenerimaBantuan;
use App\Models\PermohonanSurat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function kaurUmum()
    {
        $user = Auth::user();
        $totalPenduduk = Penduduk::count();
        $totalPengajuan = PermohonanSurat::count();
        $menungguVerifikasi = PermohonanSurat::where('status_permohonan', 'menunggu')->count();
        $kritikSaran = KritikSaran::where('status', 'belum_dibaca')->latest()->take(5)->get();
        $pengajuanTerbaru = PermohonanSurat::with(['penduduk', 'jenisSurat'])
            ->latest()
            ->take(5)
            ->get();

        $notifikasiCount = $menungguVerifikasi + $kritikSaran->count();

        $grafikPendudukRaw = Penduduk::whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $grafikPenduduk = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikPenduduk[] = $grafikPendudukRaw[$i] ?? 0;
        }

        return view('dashboard.kaur-umum', compact(
            'user',
            'totalPenduduk',
            'totalPengajuan',
            'menungguVerifikasi',
            'kritikSaran',
            'pengajuanTerbaru',
            'notifikasiCount',
            'grafikPenduduk'
        ));
    }

    public function kepalaDesa()
    {
        $user = Auth::user();
        $totalPenduduk = Penduduk::count();
        $totalPengajuan = PermohonanSurat::count();
        $menungguVerifikasi = PermohonanSurat::where('status_permohonan', 'menunggu')->count();
        $kritikSaran = KritikSaran::where('status', 'belum_dibaca')->latest()->take(5)->get();

        $penerimaBantuan = PenerimaBantuan::with('penduduk')
            ->latest()
            ->take(5)
            ->get();

        $notifikasiCount = $menungguVerifikasi + $kritikSaran->count();

        $grafikPendudukRaw = Penduduk::whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $grafikPenduduk = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikPenduduk[] = $grafikPendudukRaw[$i] ?? 0;
        }

        return view('dashboard.kepala-desa', compact(
            'user',
            'totalPenduduk',
            'totalPengajuan',
            'menungguVerifikasi',
            'kritikSaran',
            'penerimaBantuan',
            'notifikasiCount',
            'grafikPenduduk'
        ));
    }

    public function penduduk()
    {
        $user = Auth::user();
        $penduduk = Penduduk::where('nik', $user->nik)->first();

        $totalPengajuan = PermohonanSurat::where('id_penduduk', $penduduk->id_penduduk ?? 0)->count();
        $totalBantuan = PenerimaBantuan::where('id_penduduk', $penduduk->id_penduduk ?? 0)->count();
        $kritikSaran = KritikSaran::where('nama_pengirim', $user->nama)->latest()->take(5)->get();

        $notifikasiCount = $totalPengajuan + $totalBantuan + $kritikSaran->count();

        return view('dashboard.penduduk', compact(
            'user',
            'penduduk',
            'totalPengajuan',
            'totalBantuan',
            'kritikSaran',
            'notifikasiCount'
        ));
    }
}
