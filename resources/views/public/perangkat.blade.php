@extends('layouts.public')

@section('title', 'Perangkat Desa Sidomulyo')

@section('public-content')
<div class="container-fluid py-5" style="background-color: #f8faf9;">
    
    <div class="container mb-5 pb-3 border-bottom text-center">
        <h4 class="fw-bold text-dark mb-0 text-uppercase">Struktur Organisasi Desa Sidomulyo</h4>
        <p class="text-muted mt-2 mb-0">Pemerintah Desa Sidomulyo, Kecamatan Biru-Biru</p>
    </div>

    <!-- ============================================================ -->
    <!-- DIAGRAM STRUKTUR ORGANISASI (MODERN TREE DESIGN)              -->
    <!-- ============================================================ -->
    <style>
        .org-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: auto;
            padding: 20px 0 60px 0;
            width: 100%;
        }
        
        .org-level {
            display: flex;
            justify-content: center;
            width: 100%;
            min-width: 1100px;
        }
        
        .org-node {
            position: relative;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1; 
        }
        
        /* Drop lines from top horizontal bus */
        .org-node::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 30px;
            background: #2e7d32;
            transform: translateX(-50%);
            z-index: 1;
        }
        
        /* Top horizontal bus */
        .org-node::after {
            content: '';
            position: absolute;
            top: 0;
            height: 2px;
            background: #2e7d32;
            z-index: 1;
        }
        .org-node.first::after { left: 50%; right: 0; }
        .org-node.last::after { left: 0; right: 50%; }
        .org-node.middle::after { left: 0; right: 0; }
        .org-node.only::after { display: none; }
        .org-node.only::before { height: 30px; }
        
        .org-spine {
            width: 2px; 
            background: #2e7d32; 
            z-index: 1;
        }

        /* Modern Card Styling */
        .org-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
            width: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            border: 1px solid rgba(46, 125, 50, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 5;
            padding-bottom: 20px;
        }
        .org-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(46, 125, 50, 0.12);
        }
        .org-card-header {
            background: linear-gradient(135deg, #1a472a, #2e7d32);
            width: 100%;
            height: 55px;
            border-radius: 11px 11px 0 0;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        .org-img-wrapper {
            position: relative;
            z-index: 2;
            margin-top: 15px;
            background: #fff;
            border-radius: 50%;
            padding: 4px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .org-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
        .org-title {
            font-size: 0.75rem;
            color: #1a472a;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 15px;
            padding: 0 10px;
            text-align: center;
            line-height: 1.3;
        }
        .org-name {
            font-size: 0.95rem;
            color: #333;
            font-weight: 700;
            margin-top: 5px;
            padding: 0 10px;
            text-align: center;
        }

        /* Horizontal Card (KAUR) */
        .org-card-horizontal {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border: 1px solid rgba(46, 125, 50, 0.15);
            border-left: 5px solid #1a472a;
            width: 250px;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 12px;
            position: relative;
            z-index: 5;
            transition: transform 0.3s ease;
        }
        .org-card-horizontal:hover {
            transform: translateX(5px);
        }
        .org-card-horizontal .org-img-wrapper {
            margin-top: 0;
            padding: 3px;
            margin-right: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .org-card-horizontal .org-img {
            width: 50px;
            height: 50px;
        }
        .org-card-horizontal .org-info {
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        .org-card-horizontal .org-title {
            margin-top: 0;
            padding: 0;
            font-size: 0.7rem;
            text-align: left;
        }
        .org-card-horizontal .org-name {
            margin-top: 2px;
            padding: 0;
            font-size: 0.9rem;
            text-align: left;
        }
    </style>

    <div class="org-container">
        
        <!-- LEVEL 1: KADES -->
        @if($kepala)
        <div class="org-card">
            <div class="org-card-header"></div>
            <div class="org-img-wrapper">
                <img src="{{ $kepala->foto ? asset('storage/' . $kepala->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kepala->nama).'&background=1a472a&color=fff' }}" class="org-img" alt="{{ $kepala->nama }}">
            </div>
            <div class="org-title">{{ $kepala->jabatan }}</div>
            <div class="org-name">{{ $kepala->nama }}</div>
        </div>
        @endif
        
        <!-- SPINE 1 (Kades down to Level 2) -->
        <div class="org-spine" style="height: 30px;"></div>
        
        <!-- LEVEL 2 WRAPPER -->
        <div class="w-100 position-relative">
            
            <!-- Central Spine passing visually behind Level 2 to connect to Level 3 -->
            <div class="org-spine position-absolute" style="top: 0; bottom: 0; left: 50%; transform: translateX(-50%); z-index: 0;"></div>
            
            <div class="org-level">
                @php
                    // Group and Sort Seksi (Kasi)
                    $seksiUrutan = [];
                    if ($seksi->count() > 0) {
                        foreach ($seksi as $item) {
                            if (strpos($item->jabatan, 'Pelayanan') !== false) $seksiUrutan[1] = $item;
                            elseif (strpos($item->jabatan, 'Kesejahteraan') !== false) $seksiUrutan[2] = $item;
                            elseif (strpos($item->jabatan, 'Pemerintahan') !== false) $seksiUrutan[3] = $item;
                            else $seksiUrutan[] = $item;
                        }
                        ksort($seksiUrutan);
                    }
                    
                    // Combine Kasi + Sekdes into one horizontal level
                    $level2Items = collect($seksiUrutan);
                    if($sekretaris) {
                        $level2Items->push($sekretaris);
                    }
                    $l2Count = $level2Items->count();
                    $i = 0;
                @endphp
                
                @foreach($level2Items as $item)
                    @php 
                        $i++;
                        $nodeClass = 'middle';
                        if($l2Count == 1) $nodeClass = 'only';
                        elseif($i == 1) $nodeClass = 'first';
                        elseif($i == $l2Count) $nodeClass = 'last';
                        
                        $isSekdes = ($item->jabatan == 'Sekretaris Desa' || strpos(strtolower($item->jabatan), 'sekretaris') !== false);
                    @endphp
                    
                    <div class="org-node {{ $nodeClass }}">
                        <div class="org-card">
                            <div class="org-card-header"></div>
                            <div class="org-img-wrapper">
                                <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://ui-avatars.com/api/?name='.urlencode($item->nama).'&background=1a472a&color=fff' }}" class="org-img" alt="{{ $item->nama }}">
                            </div>
                            <div class="org-title">{{ $item->jabatan }}</div>
                            <div class="org-name">{{ $item->nama }}</div>
                        </div>
                        
                        <!-- If it's Sekdes, render Kaur vertically underneath -->
                        @if($isSekdes && $urusan->count() > 0)
                        <div class="w-100 position-relative mt-4 d-flex justify-content-center">
                            
                            <!-- Spine down from Sekdes to KAUR -->
                            <div class="org-spine position-absolute" style="top: -24px; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 1;"></div>
                            
                            <!-- Container with width 0 anchored at 50% to prevent affecting parent width -->
                            <div class="position-relative" style="width: 0; display: flex; justify-content: flex-start;">
                                <div class="d-flex flex-column" style="padding-left: 30px;">
                                    @foreach($urusan as $kaur)
                                    <div class="position-relative mb-3">
                                        <!-- Horizontal branch connecting to Sekdes spine -->
                                        <div class="org-spine position-absolute" style="left: -30px; top: 50%; width: 30px; height: 2px; transform: translateY(-50%); z-index: 1;"></div>
                                        
                                        <div class="org-card-horizontal">
                                            <div class="org-img-wrapper">
                                                <img src="{{ $kaur->foto ? asset('storage/' . $kaur->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kaur->nama).'&background=1a472a&color=fff' }}" class="org-img" alt="{{ $kaur->nama }}">
                                            </div>
                                            <div class="org-info">
                                                <div class="org-title">{{ $kaur->jabatan }}</div>
                                                <div class="org-name">{{ $kaur->nama }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SPINE 2 (Below Level 2 to Level 3) -->
        <div class="org-spine" style="height: 40px;"></div>

        <!-- LEVEL 3: DUSUN -->
        <div class="org-level">
            @php $dusunCount = $dusun->count(); $i = 0; @endphp
            @foreach($dusun as $item)
                @php 
                    $i++;
                    $nodeClass = 'middle';
                    if($dusunCount == 1) $nodeClass = 'only';
                    elseif($i == 1) $nodeClass = 'first';
                    elseif($i == $dusunCount) $nodeClass = 'last';
                @endphp
                <div class="org-node {{ $nodeClass }}">
                    <div class="org-card" style="width: 170px;">
                        <div class="org-card-header"></div>
                        <div class="org-img-wrapper">
                            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://ui-avatars.com/api/?name='.urlencode($item->nama).'&background=1a472a&color=fff' }}" class="org-img" style="width: 60px; height: 60px;" alt="{{ $item->nama }}">
                        </div>
                        <div class="org-title" style="font-size: 0.65rem;">{{ $item->jabatan }}</div>
                        <div class="org-name" style="font-size: 0.85rem;">{{ $item->nama }}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</div>
@endsection