<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiDesa extends Model
{
    use HasFactory;

    protected $table = 'informasi_desa';

    protected $primaryKey = 'id_informasi';

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'gambar',
        'tanggal_posting',
        'penulis',
        'status_publish',
    ];

    protected $casts = [
        'tanggal_posting' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
