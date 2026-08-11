<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 'nonaktif') {
                Auth::logout();

                return back()->with('error', 'Akun Anda telah dinonaktifkan.');
            }

            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo($user->role));
        }

        return back()->with('error', 'Username atau password salah.')->withInput();
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function checkNik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
            'no_kk' => 'required|string|size:16',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Format NIK atau NKK tidak valid.']);
        }

        // Cek apakah sudah punya akun
        $userExists = User::where('nik', $request->nik)->exists();
        if ($userExists) {
            return response()->json(['success' => false, 'message' => 'Akun dengan NIK tersebut sudah terdaftar!']);
        }

        // Cek kesesuaian di tabel penduduk master
        $penduduk = Penduduk::where('nik', $request->nik)->where('no_kk', $request->no_kk)->first();
        if ($penduduk) {
            return response()->json(['success' => true, 'nama' => $penduduk->nama]);
        }

        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan! Pastikan NIK dan NKK sesuai dengan Kartu Keluarga Anda.']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:users,nik',
            'no_kk' => 'required|string|size:16',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verifikasi ganda NIK dan NKK ke database kependudukan
        $penduduk = Penduduk::where('nik', $request->nik)->where('no_kk', $request->no_kk)->first();
        
        if (!$penduduk) {
            return back()->with('error', 'Registrasi ditolak! NIK dan Nomor KK tidak cocok atau tidak terdaftar di database Desa Sidomulyo.')->withInput();
        }

        $user = User::create([
            'nik' => $request->nik,
            'nama' => $penduduk->nama, // Paksa gunakan nama asli dari database
            'username' => $request->username,
            'email' => $request->username.'@gmail.com',
            'password' => Hash::make($request->password),
            'role' => 'penduduk',
            'status' => 'aktif',
        ]);

        return redirect()->route('login')->with('success', 'Aktivasi akun berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectTo($role)
    {
        return match ($role) {
            'kaur_umum' => '/dashboard/kaur-umum',
            'kepala_desa' => '/dashboard/kepala-desa',
            default => '/dashboard/penduduk',
        };
    }

    // ========================================================== //
    // RESET PASSWORD                                             //
    // ========================================================== //

    public function showResetForm()
    {
        return view('auth.reset-password', ['step' => 1, 'email' => null, 'token' => null]);
    }

    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Generate token 6 digit
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke database
        ResetPassword::create([
            'id_user' => $user->id_user,
            'email' => $request->email,
            'token' => $token,
            'expired_at' => now()->addMinutes(5),
            'status' => 'pending',
        ]);

        // Simpan email dan token ke session
        session([
            'reset_email' => $request->email,
            'reset_token' => $token,
        ]);

        return redirect()->route('password.verify.form')
            ->with('success', "Kode verifikasi: {$token}");
    }

    public function showVerifyForm()
    {
        $email = session('reset_email');
        $token = session('reset_token');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Silakan masukkan email terlebih dahulu.');
        }

        return view('auth.reset-password', [
            'step' => 2,
            'email' => $email,
            'token' => $token,
        ]);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reset = ResetPassword::where('email', $request->email)
            ->where('token', $request->code)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $reset || ! $reset->isValid()) {
            return back()->with('error', 'Kode tidak valid atau sudah kadaluarsa.');
        }

        $reset->update(['status' => 'used']);

        return view('auth.reset-password', ['step' => 3, 'email' => $request->email, 'token' => null]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget(['reset_email', 'reset_token']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
