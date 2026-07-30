<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KelolaAkunController extends Controller
{
    /**
     * Menampilkan halaman kelola akun untuk user yang login
     */
    public function index()
    {
        $user = Auth::user();

        return view('kelola-akun.index', compact('user'));
    }

    /**
     * Update foto profil
     */
    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Hapus foto lama jika ada
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        // Upload foto baru
        $path = $request->file('foto')->store('users/foto', 'public');
        $user->update(['foto' => $path]);

        return redirect()->route('kelola-akun.index')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek password lama
        if (! Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->route('kelola-akun.index')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Hapus foto profil
     */
    public function hapusFoto()
    {
        $user = Auth::user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->update(['foto' => null]);
        }

        return redirect()->route('kelola-akun.index')
            ->with('success', 'Foto profil berhasil dihapus.');
    }
}
