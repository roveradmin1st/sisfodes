<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // database/seeders/UserSeeder.php
        User::create([
            'nik' => '1212345678901234',
            'nama' => 'Kaur Umum',
            'username' => 'kaur_umum',
            'email' => 'kaurumum@gmail.com',  // <-- TAMBAHKAN
            'password' => Hash::make('password123'),
            'role' => 'kaur_umum',
            'status' => 'aktif',
        ]);

        User::create([
            'nik' => '1212345678905678',
            'nama' => 'Kepala Desa Sidomulyo',
            'username' => 'kepala_desa',
            'email' => 'kepaladesa@gmail.com',  // <-- TAMBAHKAN
            'password' => Hash::make('password123'),
            'role' => 'kepala_desa',
            'status' => 'aktif',
        ]);

        User::create([
            'nik' => '1212345678909999',
            'nama' => 'Penduduk Contoh',
            'username' => 'penduduk',
            'email' => 'penduduk@gmail.com',  // <-- TAMBAHKAN
            'password' => Hash::make('password123'),
            'role' => 'penduduk',
            'status' => 'aktif',
        ]);
    }
}
