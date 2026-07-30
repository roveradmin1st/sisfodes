<?php

namespace App\Http\Controllers;

use App\Models\Apbdesa;
use Illuminate\Http\Request;

class ApbdesaController extends Controller
{
    public function publicIndex()
    {
        $apbdesa = Apbdesa::where('tahun', '2025')->get();
        
        $pendapatan = $apbdesa->where('jenis', 'pendapatan');
        $belanja = $apbdesa->where('jenis', 'belanja');
        $pembiayaan = $apbdesa->where('jenis', 'pembiayaan');

        $totalPendapatan = $pendapatan->sum('jumlah');
        $totalBelanja = $belanja->sum('jumlah');
        $surplus = $totalPendapatan - $totalBelanja;

        return view('public.apbdesa', compact('pendapatan', 'belanja', 'pembiayaan', 'totalPendapatan', 'totalBelanja', 'surplus'));
    }

    public function index()
    {
        $apbdesa = Apbdesa::latest()->paginate(15);
        return view('apbdesa.index', compact('apbdesa'));
    }
}
