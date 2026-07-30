<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdesa extends Model
{
    use HasFactory;

    protected $table = 'apbdesa';
    protected $primaryKey = 'id_apbdesa';

    protected $fillable = [
        'tahun',
        'jenis',
        'kategori',
        'sub_kategori',
        'uraian',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'double',
    ];
}
