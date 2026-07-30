import pandas as pd
import json
import os
import math
from datetime import datetime

# Paths
penduduk_file = 'DATA SIDOMULYO/Data Penduduk Desa Sidomulyo Tahun 2025.xls'
bantuan_file = 'DATA SIDOMULYO/Data Penduduk Penerima BLT Dana Desa Tahun 2025.xlsx'
seeder_penduduk_path = 'database/seeders/PendudukSeeder.php'
seeder_bantuan_path = 'database/seeders/PenerimaBantuanSeeder.php'

def sanitize(val, max_len=255):
    if pd.isna(val) or val is None:
        return ""
    if isinstance(val, (int, float)):
        if math.isnan(val):
            return ""
        return str(int(val))
    res = str(val).strip().replace("'", "\\'")
    if len(res) > max_len:
        res = res[:max_len]
    return res

print("Parsing Penduduk...")
df_penduduk = pd.read_excel(penduduk_file)
columns = [str(c).lower().strip() for c in df_penduduk.columns.tolist()]

penduduk_records = []
for index, row in df_penduduk.iterrows():
    def get_val(possible_names, max_len=255):
        for i, col in enumerate(columns):
            if col in possible_names:
                return sanitize(row.iloc[i], max_len)
        return ""

    nik = get_val(['n i k', 'nik'], 20)
    no_kk = get_val(['kode keluarga', 'no_kk'], 20)
    nama = get_val(['nama anggota keluarga', 'nama'], 100)
    tempat_lahir = get_val(['tempat lahir', 'tempat_lahir'], 100)
    tanggal_lahir = get_val(['tanggal lahir', 'tanggal_lahir'])
    jenis_kelamin = get_val(['jenis kelamin', 'jenis_kelamin'], 20)
    if "l" in jenis_kelamin.lower(): jenis_kelamin = "Laki-laki"
    elif "p" in jenis_kelamin.lower(): jenis_kelamin = "Perempuan"
    agama = get_val(['agama'], 20)
    if not agama: agama = "Islam"
    pendidikan = get_val(['pendidikan'], 50)
    pekerjaan = get_val(['pekerjaan'], 50)
    status_perkawinan = get_val(['status'], 50)
    dusun = get_val(['dusun'], 50)
    if not dusun: dusun = "Dusun I"

    if not nik and not nama:
        continue
        
    if nik == "n i k" or "nik" in nik.lower():
        continue

    if isinstance(row.iloc[columns.index('tanggal lahir')], pd.Timestamp):
        tanggal_lahir = row.iloc[columns.index('tanggal lahir')].strftime('%Y-%m-%d')
    else:
        try:
            tanggal_lahir = datetime.strptime(tanggal_lahir, '%d/%m/%Y').strftime('%Y-%m-%d')
        except:
            tanggal_lahir = '1990-01-01'

    penduduk_records.append(f"""
            \\App\\Models\\Penduduk::create([
                'nik' => '{nik}',
                'no_kk' => '{no_kk}',
                'nama' => '{nama}',
                'tempat_lahir' => '{tempat_lahir}',
                'tanggal_lahir' => '{tanggal_lahir if tanggal_lahir else "1990-01-01"}',
                'jenis_kelamin' => '{jenis_kelamin}',
                'agama' => '{agama}',
                'pendidikan' => '{pendidikan}',
                'pekerjaan' => '{pekerjaan}',
                'status_perkawinan' => '{status_perkawinan}',
                'kewarganegaraan' => 'WNI',
                'alamat' => '{dusun}',
                'dusun' => '{dusun}',
                'rt' => '001',
                'rw' => '001',
                'status_penduduk' => 'Aktif',
                'is_kepala_keluarga' => false,
            ]);
    """)

seeder_content = f"""<?php
namespace Database\\Seeders;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;
class PendudukSeeder extends Seeder {{
    public function run() {{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \\App\\Models\\Penduduk::query()->truncate();
        {''.join(penduduk_records)}
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }}
}}
"""
with open(seeder_penduduk_path, 'w', encoding='utf-8') as f:
    f.write(seeder_content)

print(f"Generated {len(penduduk_records)} Penduduk records.")

print("Parsing Bantuan...")
try:
    df_bantuan = pd.read_excel(bantuan_file, header=None)
    bantuan_records = []
    
    header_row_index = -1
    for i, row in df_bantuan.iterrows():
        row_str = " ".join([str(x).lower() for x in row.tolist()])
        if "nama" in row_str and "nik" in row_str:
            header_row_index = i
            break
            
    if header_row_index != -1:
        df_bantuan = pd.read_excel(bantuan_file, header=header_row_index)
        b_cols = [str(c).lower().strip() for c in df_bantuan.columns.tolist()]
        for index, row in df_bantuan.iterrows():
            def get_val_b(possible_names):
                for i, col in enumerate(b_cols):
                    if col in possible_names:
                        return sanitize(row.iloc[i], 50)
                return ""
            
            nik = get_val_b(['nik'])[:20]
            nama = get_val_b(['nama', 'nama penerima'])[:100]
            
            if not nik and not nama:
                continue
            if nik == "NIK":
                continue
                
            bantuan_records.append(f"""
            $penduduk = \\App\\Models\\Penduduk::where('nik', '{nik}')->orWhere('nama', 'like', '%{nama}%')->first();
            if ($penduduk) {{
                \\App\\Models\\PenerimaBantuan::create([
                    'id_penduduk' => $penduduk->id_penduduk,
                    'program_bantuan' => 'BLT Dana Desa 2025',
                    'keterangan' => 'Penerima Aktif',
                    'tanggal_terima' => '2025-01-01',
                    'status' => 'Diterima',
                ]);
            }} else {{
                $newPenduduk = \\App\\Models\\Penduduk::create([
                    'nik' => '{nik}',
                    'no_kk' => '0000000000000000',
                    'nama' => '{nama}',
                    'tempat_lahir' => 'Sidomulyo',
                    'tanggal_lahir' => '1990-01-01',
                    'jenis_kelamin' => 'Laki-laki',
                    'agama' => 'Islam',
                    'dusun' => 'Dusun I',
                    'alamat' => 'Dusun I',
                ]);
                \\App\\Models\\PenerimaBantuan::create([
                    'id_penduduk' => $newPenduduk->id_penduduk,
                    'program_bantuan' => 'BLT Dana Desa 2025',
                    'keterangan' => 'Penerima Aktif',
                    'tanggal_terima' => '2025-01-01',
                    'status' => 'Diterima',
                ]);
            }}
            """)
    
    seeder_bantuan_content = f"""<?php
namespace Database\\Seeders;
use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;
class PenerimaBantuanSeeder extends Seeder {{
    public function run() {{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \\App\\Models\\PenerimaBantuan::query()->truncate();
        {''.join(bantuan_records)}
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }}
}}
"""
    with open(seeder_bantuan_path, 'w', encoding='utf-8') as f:
        f.write(seeder_bantuan_content)
    print(f"Generated {len(bantuan_records)} Bantuan records.")
except Exception as e:
    print("Error parsing Bantuan:", e)
