<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProfilDesaSeeder::class,
            PerangkatDesaSeeder::class,
            PendudukSeeder::class,
            UserSeeder::class,
            JenisSuratSeeder::class,
            InformasiDesaSeeder::class,
            PenerimaBantuanSeeder::class,
            ApbdesaSeeder::class,
        ]);
    }
}
