<?php

namespace Database\Seeders;

use App\Models\ProfilDesa;
use Illuminate\Database\Seeder;

class ProfilDesaSeeder extends Seeder
{
    public function run()
    {
        ProfilDesa::create([
            'nama_desa' => 'Desa Sidomulyo',
            'kecamatan' => 'Biru-Biru',
            'kabupaten' => 'Deli Serdang',
            'provinsi' => 'Sumatera Utara',
            'alamat' => 'Jl. Desa Sidomulyo, Kecamatan Biru-Biru, Kabupaten Deli Serdang',
            'kode_pos' => '20376',
            'telepon' => '061-1234567',
            'email' => 'desa.sidomulyo@gmail.com',
            'visi' => 'Terwujudnya kemandirian desa yang maju, aman, sejahtera dan berkeadilan dengan menempatkan masyarakat sebagai pelaku utama dalam seluruh proses pengelolaan pembangunan desa.',
            'misi' => "1. Meningkatkan pembangunan desa dalam berbagai bidang.\n2. Mengembangkan kemampuan masyarakat untuk berperan aktif dalam proses pembangunan.\n3. Mengentaskan kemiskinan dengan kegiatan keterampilan.\n4. Mengoptimalkan fungsi perangkat desa.\n5. Meningkatkan peran serta generasi muda.",
            'sejarah' => 'Desa Sidomulyo dahulu wilayahnya merupakan areal perkebunan Belanda (Tahun 1950), setelah melalui perjuangan masyarakat desa maka pada tahun 1952 memperoleh pengakuan dan izin dari Asisten Wedana Pancur Batu terbentuk menjadi kampung Sidomulyo yang dipimpin oleh Lurah Kelurahan Sidomulyo yaitu Alm. Parno. Sidomulyo berasal dari kata Sido artinya jadi, dan mulyo artinya mulia, sehingga dapat diartikan sebagai desa yang akan menjadi mulia.',
        ]);
    }
}
