import pandas as pd
import numpy as np
import json
import re
from datetime import datetime

excel_path = r'C:\xampp\htdocs\sisfodes\DATA SIDOMULYO\Data Penduduk Desa Sidomulyo Tahun 2025.xls'
df = pd.read_excel(excel_path, sheet_name=0)

print(f"Original Excel Rows: {len(df)}")
print("Columns:", df.columns.tolist())

# Clean strings function
def clean_str(val, default=''):
    if pd.isna(val) or val is None:
        return default
    s = str(val).strip()
    s = s.replace('&nbsp;', '').strip()
    if s == '' or s.lower() == 'nan' or s == '-':
        return default
    return s

records = []
seen_niks = set()
duplicate_nik_count = 0
invalid_nik_count = 0

for idx, row in df.iterrows():
    raw_nik = clean_str(row.get('N I K'))
    # Clean non-digit characters from NIK
    nik = re.sub(r'\D', '', raw_nik)
    
    if not nik or len(nik) < 8:
        invalid_nik_count += 1
        # Fallback NIK if missing or corrupted: 1207 + random unique sequence
        nik = f"120799{idx+1:010d}"

    if nik in seen_niks:
        duplicate_nik_count += 1
        # Make duplicate NIK unique by tweaking last digits slightly if needed
        nik = f"{nik[:-4]}{idx%10000:04d}"
        if nik in seen_niks:
            nik = f"120788{idx+1:010d}"
    
    seen_niks.add(nik)

    raw_kk = clean_str(row.get('Kode Keluarga'))
    no_kk = re.sub(r'\D', '', raw_kk)
    if not no_kk or len(no_kk) < 8:
        no_kk = nik # fallback to nik if kk missing

    nama = clean_str(row.get('Nama Anggota Keluarga'), 'WARGA DESA SIDOMULYO').upper()
    tempat_lahir = clean_str(row.get('Tempat Lahir'), 'DELI SERDANG').upper()
    
    # Process Tanggal Lahir
    tgl_raw = row.get('Tanggal Lahir')
    tgl_lahir = '1990-01-01'
    if pd.notna(tgl_raw):
        try:
            if isinstance(tgl_raw, datetime):
                tgl_lahir = tgl_raw.strftime('%Y-%m-%d')
            else:
                tgl_dt = pd.to_datetime(tgl_raw, errors='coerce')
                if pd.notna(tgl_dt):
                    tgl_lahir = tgl_dt.strftime('%Y-%m-%d')
        except Exception:
            tgl_lahir = '1990-01-01'

    # Jenis Kelamin
    jk_raw = clean_str(row.get('Jenis Kelamin')).upper()
    jenis_kelamin = 'L' if 'L' in jk_raw else ('P' if 'P' in jk_raw else 'L')

    # Hubungan & is_kepala_keluarga
    hubungan = clean_str(row.get('Hubungan')).upper()
    is_kepala = 1 if ('KEPALA' in hubungan or 'SUAMI' in hubungan) else 0

    # Agama
    agama = clean_str(row.get('Agama'), 'Islam')
    if 'ISLAM' in agama.upper():
        agama = 'Islam'
    elif 'KRISTEN' in agama.upper():
        agama = 'Kristen'
    elif 'KATOLIK' in agama.upper():
        agama = 'Katolik'
    elif 'HINDU' in agama.upper():
        agama = 'Hindu'
    elif 'BUDHA' in agama.upper() or 'BUDDHA' in agama.upper():
        agama = 'Buddha'
    else:
        agama = 'Islam'

    pendidikan = clean_str(row.get('Pendidikan'), 'Tidak / Belum Sekolah')
    pekerjaan = clean_str(row.get('Pekerjaan'), 'Belum Bekerja')
    status_perkawinan = clean_str(row.get('Status'), 'Belum Kawin')
    
    dusun = clean_str(row.get('Dusun'), 'Dusun I')
    rt = clean_str(row.get('RT'), '00')
    rw = clean_str(row.get('RW'), '00')
    
    alamat_raw = clean_str(row.get('Alamat'))
    if alamat_raw:
        alamat = f"{alamat_raw}, Dusun {dusun}"
    else:
        alamat = f"Dusun {dusun}, Desa Sidomulyo"

    records.append({
        'nik': nik[:16],
        'no_kk': no_kk[:16],
        'nama': nama[:100],
        'tempat_lahir': tempat_lahir[:50],
        'tanggal_lahir': tgl_lahir,
        'jenis_kelamin': jenis_kelamin,
        'agama': agama[:20],
        'pendidikan': pendidikan[:50],
        'pekerjaan': pekerjaan[:50],
        'status_perkawinan': status_perkawinan[:20],
        'kewarganegaraan': 'WNI',
        'alamat': alamat,
        'dusun': dusun[:20],
        'rt': rt[:5],
        'rw': rw[:5],
        'no_hp': None,
        'email': None,
        'status_penduduk': 'tetap',
        'is_kepala_keluarga': is_kepala
    })

print(f"Total Prepared Records: {len(records)}")
print(f"Sample Record 0: {records[0]}")

# Write to database/seeders/penduduk.json
json_out_path = r'c:\xampp\htdocs\sisfodes\database\seeders\penduduk.json'
with open(json_out_path, 'w', encoding='utf-8') as f:
    json.dump(records, f, indent=2, ensure_ascii=False)

print(f"Successfully saved {len(records)} records to {json_out_path}!")
