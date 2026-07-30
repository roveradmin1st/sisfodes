import pandas as pd
import json
import os
from datetime import datetime
import math

penduduk_file = 'DATA SIDOMULYO/Data Penduduk Desa Sidomulyo Tahun 2025.xls'
bantuan_file = 'DATA SIDOMULYO/Data Penduduk Penerima BLT Dana Desa Tahun 2025.xlsx'

def sanitize(val):
    if pd.isna(val):
        return ""
    if isinstance(val, (int, float)):
        if math.isnan(val):
            return ""
        return str(int(val))
    return str(val).strip()

print("Parsing Penduduk to JSON...")
df_penduduk = pd.read_excel(penduduk_file)
columns = [str(c).lower().strip() for c in df_penduduk.columns.tolist()]

penduduk_list = []
for index, row in df_penduduk.iterrows():
    def get_val(possible_names):
        for i, col in enumerate(columns):
            if col in possible_names:
                return sanitize(row.iloc[i])
        return ""

    nik = get_val(['n i k', 'nik'])[:16].replace('.0', '').replace(' ', '')
    no_kk = get_val(['kode keluarga', 'no_kk'])[:16].replace('.0', '').replace(' ', '')
    nama = get_val(['nama anggota keluarga', 'nama'])[:100]
    tempat_lahir = get_val(['tempat lahir', 'tempat_lahir'])[:100]
    tanggal_lahir = get_val(['tanggal lahir', 'tanggal_lahir'])
    jk = get_val(['jenis kelamin', 'jenis_kelamin']).lower()
    jenis_kelamin = 'L' if 'l' in jk else 'P'
    agama = get_val(['agama'])[:20]
    if not agama: agama = "Islam"
    pendidikan = get_val(['pendidikan'])[:50]
    pekerjaan = get_val(['pekerjaan'])[:50]
    status_perkawinan = get_val(['status'])[:50]
    dusun = get_val(['dusun'])[:50]
    if not dusun: dusun = "Dusun I"

    if not nik or not nama:
        continue
    if nik.lower() == "n i k" or "nik" in nik.lower():
        continue
    if not nik.isdigit():
        continue

    if isinstance(row.iloc[columns.index('tanggal lahir')], pd.Timestamp):
        tanggal_lahir = row.iloc[columns.index('tanggal lahir')].strftime('%Y-%m-%d')
    else:
        try:
            tanggal_lahir = datetime.strptime(tanggal_lahir, '%d/%m/%Y').strftime('%Y-%m-%d')
        except:
            tanggal_lahir = '1990-01-01'

    penduduk_list.append({
        'nik': nik, 'no_kk': no_kk, 'nama': nama, 'tempat_lahir': tempat_lahir,
        'tanggal_lahir': tanggal_lahir, 'jenis_kelamin': jenis_kelamin, 'agama': agama,
        'pendidikan': pendidikan, 'pekerjaan': pekerjaan, 'status_perkawinan': status_perkawinan,
        'kewarganegaraan': 'WNI', 'alamat': dusun, 'dusun': dusun, 'rt': '001', 'rw': '001',
        'status_penduduk': 'Aktif', 'is_kepala_keluarga': 0
    })

with open('database/seeders/penduduk.json', 'w') as f:
    json.dump(penduduk_list, f)

print(f"Saved {len(penduduk_list)} Penduduk to JSON.")

print("Parsing Bantuan to JSON...")
try:
    df_bantuan = pd.read_excel(bantuan_file, header=None)
    header_row_index = -1
    for i, row in df_bantuan.iterrows():
        row_str = " ".join([str(x).lower() for x in row.tolist()])
        if "nama" in row_str and "nik" in row_str:
            header_row_index = i
            break
            
    bantuan_list = []
    if header_row_index != -1:
        df_bantuan = pd.read_excel(bantuan_file, header=header_row_index)
        b_cols = [str(c).lower().strip() for c in df_bantuan.columns.tolist()]
        for index, row in df_bantuan.iterrows():
            def get_val_b(possible_names):
                for i, col in enumerate(b_cols):
                    if col in possible_names:
                        return sanitize(row.iloc[i])
                return ""
            
            nik = get_val_b(['nik'])[:16].replace('.0', '').replace(' ', '')
            nama = get_val_b(['nama', 'nama penerima'])[:100]
            alamat = get_val_b(['alamat'])[:255]
            
            if not nik or not nama: continue
            if nik.lower() == "nik": continue
            if not nik.isdigit() or len(nik) != 16: continue # Strictly require NIK to be exactly 16 digits
                
            bantuan_list.append({'nik': nik, 'nama': nama, 'alamat': alamat})
            
    with open('database/seeders/bantuan.json', 'w') as f:
        json.dump(bantuan_list, f)
    print(f"Saved {len(bantuan_list)} Bantuan to JSON.")
except Exception as e:
    print("Error:", e)
