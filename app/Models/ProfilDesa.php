<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'profil_desa';
    protected $primaryKey = 'id_profil';

    protected $fillable = [
        'nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'alamat',
        'kode_pos', 'telepon', 'email', 'visi', 'misi', 'sejarah',
        'logo', 'luas_wilayah',
        'map', // <-- TAMBAHKAN INI
    ];
}