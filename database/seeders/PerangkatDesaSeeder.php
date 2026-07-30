<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Seeder;

class PerangkatDesaSeeder extends Seeder
{
    public function run()
    {
        PerangkatDesa::query()->delete();

        $perangkat = [
            ['Satriawan', 'Kepala Desa', 'perangkat/SATRIAWAN (Kepala Desa).jpg'],
            ['Samsidar, A.Md', 'Sekretaris Desa', 'perangkat/SAMSIDAR, A.Md (Sekretaris Desa).jpg'],
            ['M. Muchlisin', 'Kepala Seksi Pemerintahan', 'perangkat/M.MUCHLISIN (Kepala Seksi Pemerintahan).jpeg'],
            ['Nuraisah', 'Kepala Seksi Kesejahteraan', null],
            ['Tatang Priyatna', 'Kepala Seksi Pelayanan', 'perangkat/TATANG PRIYATNA (Kepala Seksi Pelayanan).jpg'],
            ['Tuti Amidah', 'Kepala Urusan Umum', 'perangkat/TUTI AMIDAH (Kepala Urusan Umum).jpg'],
            ['Syahfitri', 'Kepala Urusan Keuangan', 'perangkat/SYAHFITRI (Kepala Urusan Keuangan).jpg'],
            ['Ratna Dewi Br Sembiring, S.Kom', 'Kepala Urusan Perencanaan', 'perangkat/RATNA DEWI S, S.Kom (Kepala Urusan Perencanaan).jpg'],
            ['Chairul Anwar', 'Kepala Dusun I', 'perangkat/CHAIRUL ANWAR (Kepala Dusun I).jpg'],
            ['Sumanto', 'Kepala Dusun II', 'perangkat/SUMANTO (Kepala Dusun II).jpg'],
            ['Terkelin Sitepu', 'Kepala Dusun III', null],
            ['M. Aliges Ginting', 'Kepala Dusun IV', 'perangkat/M.ALIGES GINTING (Kepala Dusun IV).jpg'],
            ['Prianto', 'Kepala Dusun V', null],
            ['Gusti Juanda', 'Kepala Dusun VI', null],
        ];

        foreach ($perangkat as $item) {
            PerangkatDesa::create([
                'nama' => $item[0],
                'jabatan' => $item[1],
                'foto' => $item[2],
            ]);
        }
    }
}
