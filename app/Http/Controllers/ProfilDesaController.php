<?php

namespace App\Http\Controllers;

use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();

        return view('profil.index', compact('profil'));
    }

    public function edit()
    {
        $profil = ProfilDesa::first();

        return view('profil.edit', compact('profil'));
    }

    public function store(Request $request)
    {
        $profil = ProfilDesa::create([
            'nama_desa' => 'Desa Sidomulyo',
            'alamat' => 'Jl. Desa Sidomulyo No. 1',
            'kecamatan' => 'Kecamatan Contoh',
            'kabupaten' => 'Kabupaten Contoh',
            'provinsi' => 'Provinsi Contoh',
            'luas_wilayah' => '0 Ha',
            'visi' => 'Belum ada visi',
            'misi' => 'Belum ada misi',
            'sejarah' => 'Belum ada data sejarah',
        ]);

        return redirect()->route('profil.index')->with('success', 'Profil desa berhasil dibuat!');
    }

    public function update(Request $request)
    {
        $profil = ProfilDesa::first();
        if (! $profil) {
            return redirect()->route('profil.index')->with('error', 'Data tidak ditemukan!');
        }

        $validator = Validator::make($request->all(), [
            'nama_desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'luas_wilayah' => 'nullable|string|max:50',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'sejarah' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ambil semua data kecuali token & method
        $data = $request->except(['_token', '_method']);

        // Update hanya field yang ada nilainya
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $profil->$key = $value;
            }
        }
        $profil->save();

        return redirect()->route('profil.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profil = ProfilDesa::first();

        if (! $profil) {
            return redirect()->route('profil.index')->with('error', 'Data profil tidak ditemukan!');
        }

        if ($request->hasFile('logo')) {
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }

            $file = $request->file('logo');
            $filename = 'logo_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profil', $filename, 'public');
            $profil->logo = $path;
            $profil->save();
        }

        return redirect()->route('profil.index')->with('success', 'Logo berhasil diupload!');
    }

    public function updateMap(Request $request)
    {
        $request->validate([
            'map' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profil = ProfilDesa::first();

        if (! $profil) {
            return redirect()->route('profil.index')->with('error', 'Data profil tidak ditemukan!');
        }

        if ($request->hasFile('map')) {
            if ($profil->map && Storage::disk('public')->exists($profil->map)) {
                Storage::disk('public')->delete($profil->map);
            }

            $file = $request->file('map');
            $filename = 'map_'.time().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profil', $filename, 'public');
            $profil->map = $path;
            $profil->save();
        }

        return redirect()->route('profil.index')->with('success', 'Peta berhasil diupload!');
    }

    public function publicIndex()
    {
        $profil = ProfilDesa::first();

        return view('public.profil', compact('profil'));
    }
}
