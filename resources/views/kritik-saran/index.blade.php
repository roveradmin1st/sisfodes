@extends('layouts.dashboard')

@section('page-title', 'Kritik dan Saran')

@section('dashboard-content')

<style>
    /* ===== SMOOTH SCROLL ===== */
    html {
        scroll-behavior: smooth;
    }

    /* ===== CARD STYLING ===== */
    .card {
        border-radius: 16px !important;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.06) !important;
    }
    .card-body {
        padding: 24px;
    }

    /* ===== MESSAGE ITEM ===== */
    .message-item {
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 4px;
    }
    .message-item:hover {
        background: linear-gradient(90deg, #f8f9fa, #ffffff);
    }

    .message-box {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 16px 20px;
        background: white;
        transition: all 0.3s ease;
    }
    .message-box:hover {
        border-color: #1a472a;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.06);
    }
    .message-box .message-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.85rem;
    }
    .message-box .message-value {
        color: #212529;
        font-size: 0.9rem;
    }

    /* ===== REPLY BOX ===== */
    .reply-box {
        border: 2px solid #c8e6c9;
        border-radius: 12px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #e8f5e9, #ffffff);
        transition: all 0.3s ease;
    }
    .reply-box:hover {
        border-color: #1a472a;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.06);
    }
    .reply-box .reply-text {
        color: #1a472a;
        font-size: 0.9rem;
        margin-bottom: 0;
        line-height: 1.6;
    }
    .reply-box .reply-empty {
        color: #6c757d;
        font-size: 0.9rem;
        font-style: italic;
        margin-bottom: 0;
    }

    /* ===== BUTTON STYLING ===== */
    .btn-action-sm {
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-action-sm:hover {
        transform: translateY(-2px) scale(1.05);
    }
    .btn-action-sm:active {
        transform: scale(0.95);
    }

    .btn-balas {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #0d47a1;
    }
    .btn-balas:hover {
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
        color: #0d47a1;
    }

    .btn-hapus {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    .btn-hapus:hover {
        box-shadow: 0 4px 15px rgba(114, 28, 36, 0.2);
        color: #721c24;
    }

    .btn-tutup {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
        padding: 8px 28px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
    }
    .btn-tutup:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    /* ===== DIVIDER ===== */
    .divider-custom {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, #e9ecef, #1a472a, #e9ecef);
        margin: 20px 0;
        opacity: 0.3;
    }

    /* ===== PAGINATION ===== */
    .pagination {
        margin-bottom: 0;
        gap: 4px;
    }
    .pagination .page-item .page-link {
        border: none;
        border-radius: 8px !important;
        padding: 8px 14px;
        color: #1a472a;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
        font-size: 0.85rem;
    }
    .pagination .page-item .page-link:hover {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #1a472a;
        transform: scale(1.05);
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.3);
    }
    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        background: transparent;
    }

    /* ===== ALERT ===== */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        animation: slideDown 0.5s ease forwards;
    }
    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .alert .btn-close {
        padding: 12px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 40px 20px;
    }
    .empty-state i {
        color: #adb5bd;
        opacity: 0.3;
    }
    .empty-state p {
        color: #6c757d;
        font-size: 1rem;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 16px !important;
        border: none !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    .modal-header {
        border-bottom: none !important;
        padding: 20px 24px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 16px 16px 0 0 !important;
    }
    .modal-header .modal-title {
        font-weight: 700;
        color: #1a472a;
        font-size: 1.1rem;
    }
    .modal-body {
        padding: 24px;
    }
    .modal-body .info-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.8rem;
        margin-bottom: 2px;
    }
    .modal-body .info-value {
        padding: 6px 0 12px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #212529;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .modal-body .info-value:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
    }
    .modal-body .info-value.balasan-lama {
        color: #1a472a;
        background: #e8f5e9;
        padding: 10px 14px;
        border-radius: 8px;
        border-left: 3px solid #1a472a;
    }
    .modal-footer {
        border-top: none !important;
        padding: 16px 24px 24px 24px;
    }

    .btn-modal-batal {
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        color: #495057;
        border: none;
        border-radius: 20px;
        padding: 8px 24px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .btn-modal-batal:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 15px rgba(73, 80, 87, 0.2);
        color: #495057;
    }

    .btn-modal-kirim {
        background: linear-gradient(135deg, #1a472a, #2d6a4f);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 24px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(26, 71, 42, 0.2);
    }
    .btn-modal-kirim:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 25px rgba(26, 71, 42, 0.3);
        color: white;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 16px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: #1a1a1a;
    }
    .form-control:focus {
        border-color: #1a472a;
        box-shadow: 0 0 0 4px rgba(26, 71, 42, 0.08);
        background: white;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .card-body {
            padding: 16px;
        }
        .message-box {
            padding: 12px 16px;
        }
        .reply-box {
            padding: 12px 16px;
        }
        .btn-action-sm {
            padding: 4px 12px;
            font-size: 0.65rem;
            width: 100%;
            justify-content: center;
            margin-bottom: 4px;
        }
        .mt-2.text-end {
            text-align: center !important;
        }
        .mt-2.text-end .btn-action-sm {
            margin: 2px 0;
        }
        .text-end .btn-tutup {
            width: 100%;
            text-align: center;
        }
        .btn-tutup {
            padding: 6px 20px;
            font-size: 0.8rem;
            width: 100%;
        }
        .modal-body {
            padding: 16px;
        }
        .modal-footer {
            flex-direction: column;
            gap: 8px;
        }
        .modal-footer .btn-modal-batal,
        .modal-footer .btn-modal-kirim {
            width: 100%;
            justify-content: center;
        }
        .pagination .page-item .page-link {
            padding: 6px 10px;
            font-size: 0.75rem;
        }
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start !important;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 12px;
        }
        .message-box {
            padding: 10px 12px;
            border-radius: 8px;
        }
        .reply-box {
            padding: 10px 12px;
            border-radius: 8px;
        }
        .message-box .message-label {
            font-size: 0.7rem;
        }
        .message-box .message-value {
            font-size: 0.75rem;
        }
        .reply-box .reply-text {
            font-size: 0.75rem;
        }
        .btn-action-sm {
            font-size: 0.6rem;
            padding: 3px 10px;
        }
        .modal-header .modal-title {
            font-size: 0.95rem;
        }
        .modal-body .info-label {
            font-size: 0.7rem;
        }
        .modal-body .info-value {
            font-size: 0.75rem;
            padding: 4px 0 8px 0;
        }
        .pagination .page-item .page-link {
            padding: 4px 8px;
            font-size: 0.65rem;
        }
    }
</style>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $isKepalaDesa = Auth::user()->role == 'kepala_desa';
        @endphp

        @forelse($kritikSaran as $item)

            @php
                $subjek = explode("\n", $item->isi_pesan);
                $subjek = str_replace('Subjek: ', '', $subjek[0] ?? '');
                $isiPesan = str_replace("Subjek: $subjek\n\n", '', $item->isi_pesan);
            @endphp

            <div class="message-item mb-4">

                <!-- KRITIK DAN SARAN -->
                <div class="mb-2">
                    <h6 class="fw-bold mb-2" style="color: #1a472a; font-size: 0.9rem;">Kritik dan Saran :</h6>
                    <div class="message-box">
                        <div class="mb-1">
                            <span class="message-label">Dari</span>
                            <span class="message-value ms-2">: {{ $item->nama_pengirim }}</span>
                        </div>
                        <div class="mb-1">
                            <span class="message-label">Subjek</span>
                            <span class="message-value ms-2">: {{ $subjek ?: 'Tanpa Subjek' }}</span>
                        </div>
                        <div>
                            <span class="message-label">Isi</span>
                            <span class="message-value ms-2">: {{ $isiPesan ?: $item->isi_pesan }}</span>
                        </div>
                    </div>
                </div>

                <!-- BALASAN KRITIK DAN SARAN -->
                <div>
                    <h6 class="fw-bold mb-2" style="color: #1a472a; font-size: 0.9rem;">Balasan Kritik dan Saran :</h6>
                    <div class="reply-box">
                        @if($item->balasan)
                            <p class="reply-text">{{ $item->balasan }}</p>
                        @else
                            <p class="reply-empty">Belum ada balasan</p>
                        @endif
                    </div>
                </div>

                <!-- TOMBOL BALAS & HAPUS (HANYA KAUR UMUM) -->
                @if(!$isKepalaDesa)
                <div class="mt-2 text-end">
                    <button type="button" class="btn-action-sm btn-balas" 
                            data-id="{{ $item->id_pesan }}"
                            data-nama="{{ $item->nama_pengirim }}"
                            data-subjek="{{ $subjek ?: 'Tanpa Subjek' }}"
                            data-pesan="{{ $isiPesan ?: $item->isi_pesan }}"
                            data-balasan="{{ $item->balasan }}">
                        Balas
                    </button>
                    <button type="button" class="btn-action-sm btn-hapus btn-delete" 
                            data-id="{{ $item->id_pesan }}"
                            data-nama="{{ $item->nama_pengirim }}">
                        Hapus
                    </button>
                </div>
                @endif

                <hr class="divider-custom">

            </div>

        @empty

            <div class="empty-state text-center">
                <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                <p class="mb-0 mt-2">Belum ada kritik dan saran</p>
            </div>

        @endforelse

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap" style="gap: 12px;">
            <span class="text-muted small">
                Menampilkan {{ $kritikSaran->firstItem() ?? 0 }} - {{ $kritikSaran->lastItem() ?? 0 }}
                dari {{ $kritikSaran->total() }} data
            </span>
            {{ $kritikSaran->links() }}
        </div>

        {{-- <!-- TOMBOL TUTUP (HANYA KAUR UMUM) -->
        @if(!$isKepalaDesa)
        <div class="mt-4 text-end">
            <a href="{{ route('dashboard.kaur-umum') }}" class="btn-tutup">Tutup</a>
        </div>
        @endif --}}

    </div>
</div>

<!-- MODAL BALASAN (HANYA KAUR UMUM) -->
@if(!$isKepalaDesa)
<div class="modal fade" id="balasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Balas Kritik & Saran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST" id="formBalas">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="id_pesan" id="id_pesan" value="">
                    <div class="mb-2">
                        <label class="info-label">Pengirim</label>
                        <p id="balasNama" class="info-value"></p>
                    </div>
                    <div class="mb-2">
                        <label class="info-label">Subjek</label>
                        <p id="balasSubjek" class="info-value"></p>
                    </div>
                    <div class="mb-2">
                        <label class="info-label">Pesan</label>
                        <p id="balasPesan" class="info-value" style="white-space: pre-line;"></p>
                    </div>
                    <div class="mb-3" id="balasBalasanContainer">
                        <label class="info-label text-success">Balasan Sebelumnya</label>
                        <p id="balasBalasan" class="info-value balasan-lama" style="white-space: pre-line;"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tulis Balasan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="balasan" id="balasanInput" rows="4" placeholder="Tulis balasan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-batal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-kirim">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-balas').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const subjek = this.dataset.subjek;
            const pesan = this.dataset.pesan;
            const balasan = this.dataset.balasan;

            document.getElementById('id_pesan').value = id;
            document.getElementById('balasNama').textContent = nama;
            document.getElementById('balasSubjek').textContent = subjek;
            document.getElementById('balasPesan').textContent = pesan;

            document.getElementById('formBalas').action = '/kritik-saran/' + id + '/balas';

            const container = document.getElementById('balasBalasanContainer');
            const el = document.getElementById('balasBalasan');
            if (balasan) {
                container.style.display = 'block';
                el.textContent = balasan;
            } else {
                container.style.display = 'none';
            }

            document.getElementById('balasanInput').value = '';
            document.getElementById('balasanInput').focus();

            new bootstrap.Modal(document.getElementById('balasModal')).show();
        });
    });

    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;

            Swal.fire({
                title: 'Hapus Data?',
                html: `
                    <div style="text-align: center;">
                        <i class="fas fa-comment" style="font-size: 3rem; color: #dc3545; margin-bottom: 15px; display: block;"></i>
                        <p style="font-size: 1rem; margin-bottom: 5px;">Apakah Anda yakin ingin menghapus</p>
                        <p style="font-size: 1.1rem; font-weight: 700; color: #1a472a;">"${nama}"</p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: null,
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showCloseButton: true,
                background: 'white',
                backdrop: 'rgba(0,0,0,0.4)',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'btn btn-danger px-4 py-2',
                    cancelButton: 'btn btn-secondary px-4 py-2',
                    htmlContainer: 'text-center'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus!',
                        text: `Kritik & saran dari "${nama}" telah dihapus.`,
                        timer: 1500,
                        showConfirmButton: false,
                        position: 'center',
                        backdrop: 'rgba(0,0,0,0.2)',
                        customClass: {
                            popup: 'rounded-4',
                            title: 'fw-bold text-success'
                        }
                    }).then(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/kritik-saran/' + id;
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    });
                }
            });
        });
    });
});
</script>
@endpush
@endif

@endsection