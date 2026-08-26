@extends('layouts.wali')

@section('title', 'Data Santri Saya')
@section('page-title', 'Data Santri Saya')
@section('page-subtitle', 'Seluruh santri yang terhubung dengan akun Anda')

@push('styles')
<style>
    .page-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
    }
    .page-head-left h2 { font-size: 1.3rem; font-weight: 800; color: #1e293b; }
    .page-head-left p  { font-size: .82rem; color: #64748b; margin-top: 3px; }

    .santri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .santri-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: #fff;
        overflow: hidden;
        transition: all .25s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }
    .santri-card:hover {
        box-shadow: 0 12px 32px rgba(0,0,0,.10);
        transform: translateY(-4px);
        border-color: #a7f3d0;
    }

    .santri-card-header {
        height: 80px;
        background: linear-gradient(135deg, #064e3b, #10b981);
        position: relative;
    }
    .santri-card-header.lulus   { background: linear-gradient(135deg, #1e3a8a, #3b82f6); }
    .santri-card-header.keluar  { background: linear-gradient(135deg, #7f1d1d, #ef4444); }
    .santri-card-header.inactive{ background: linear-gradient(135deg, #374151, #9ca3af); }

    .santri-avatar-wrap {
        position: absolute;
        bottom: -28px;
        left: 50%;
        transform: translateX(-50%);
    }
    .santri-avatar {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.4rem;
        border: 3px solid #fff;
        box-shadow: 0 4px 14px rgba(0,0,0,.12);
        overflow: hidden;
    }
    .santri-avatar.green  { color: #065f46; }
    .santri-avatar.blue   { color: #1d4ed8; }
    .santri-avatar.red    { color: #991b1b; }
    .santri-avatar.gray   { color: #475569; }
    .santri-avatar img    { width: 100%; height: 100%; object-fit: cover; }

    .santri-card-body {
        padding: 40px 20px 16px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .santri-card-name { font-size: .95rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
    .santri-card-nis  { font-size: .75rem; color: #64748b; background: #f1f5f9; border-radius: 20px; padding: 3px 10px; margin-bottom: 10px; }
    .santri-card-details {
        display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;
        margin-top: 8px; font-size: .75rem; color: #64748b;
    }
    .santri-detail-chip {
        display: inline-flex; align-items: center; gap: 4px;
        background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 20px; padding: 3px 10px;
    }
    .santri-detail-chip i { color: #10b981; font-size: .7rem; }

    .santri-card-footer {
        padding: 12px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        font-size: .8rem; font-weight: 600; color: #10b981;
        background: #fafafa;
    }
    .santri-card-footer:hover { color: #059669; }

    .empty-state { text-align: center; padding: 60px 24px; }
    .empty-state-icon { font-size: 4rem; color: #e2e8f0; margin-bottom: 16px; display: block; }
    .empty-state h4  { font-size: 1.1rem; font-weight: 700; color: #94a3b8; margin-bottom: 8px; }
    .empty-state p   { font-size: .85rem; color: #cbd5e1; max-width: 320px; margin: 0 auto 24px; }

    /* Breadcrumb */
    .breadcrumb-nav {
        display: flex; align-items: center; gap: 6px;
        font-size: .78rem; color: #94a3b8;
        margin-bottom: 20px;
    }
    .breadcrumb-nav a { color: #10b981; text-decoration: none; font-weight: 600; }
    .breadcrumb-nav a:hover { text-decoration: underline; }
    .breadcrumb-nav span { color: #cbd5e1; }

    /* ── Responsive Mobile ── */
    @media (max-width: 768px) {
        .santri-grid { grid-template-columns: 1fr; gap: 14px; }
        .page-head   { margin-bottom: 16px; }
        .breadcrumb-nav { flex-wrap: wrap; }
    }
    @media (max-width: 480px) {
        .santri-grid { grid-template-columns: 1fr; gap: 10px; }
        .santri-card-name { font-size: .88rem; }
    }
</style>
@endpush

@section('content')

@php
    $statusMap = [
        'aktif'      => ['badge' => 'badge-success', 'cls' => '',         'color' => 'green'],
        'lulus'      => ['badge' => 'badge-info',    'cls' => 'lulus',    'color' => 'blue'],
        'keluar'     => ['badge' => 'badge-danger',  'cls' => 'keluar',   'color' => 'red'],
        'tidak aktif'=> ['badge' => 'badge-secondary','cls'=> 'inactive', 'color' => 'gray'],
    ];
@endphp

{{-- Breadcrumb --}}
<div class="breadcrumb-nav">
    <a href="{{ route('wali.dashboard') }}"><i class="fas fa-house"></i> Beranda</a>
    <span>/</span>
    <span>Data Santri Saya</span>
</div>

{{-- Page Header --}}
<div class="page-head">
    <div class="page-head-left">
        <h2>Daftar Santri Anda</h2>
        <p>{{ $santri->total() }} santri terhubung dengan akun wali Anda</p>
    </div>
    <span class="badge badge-success" style="font-size:.82rem;padding:8px 16px;">
        <i class="fas fa-children"></i> {{ $santri->count() }} Ditampilkan
    </span>
</div>

{{-- Santri Grid --}}
@if($santri->count() > 0)
    <div class="santri-grid">
        @foreach($santri as $s)
        @php
            $ds   = $s->dataSantri;
            $st   = $statusMap[$s->status_data] ?? $statusMap['tidak aktif'];
        @endphp
        <a href="{{ route('wali.santri.show', $s->id) }}" class="santri-card">
            {{-- Colored Banner --}}
            <div class="santri-card-header {{ $st['cls'] }}">
                <div class="santri-avatar-wrap">
                    <div class="santri-avatar {{ $st['color'] }}">
                        @if($ds && $ds->foto_3x4 && file_exists(public_path('storage/'.$ds->foto_3x4)))
                            <img src="{{ asset('storage/'.$ds->foto_3x4) }}" alt="Foto">
                        @else
                            {{ strtoupper(substr($ds->nama_lengkap ?? '?', 0, 1)) }}
                        @endif
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="santri-card-body">
                <div class="santri-card-name">{{ $ds->nama_lengkap ?? 'Data Belum Lengkap' }}</div>
                <div class="santri-card-nis">
                    <i class="fas fa-id-badge" style="color:#10b981;margin-right:3px;"></i>
                    NIS #{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <span class="badge {{ $st['badge'] }}" style="margin-bottom:12px;">{{ ucfirst($s->status_data) }}</span>

                <div class="santri-card-details">
                    @if($ds?->jenis_kelamin)
                    <span class="santri-detail-chip">
                        <i class="fas fa-venus-mars"></i> {{ $ds->jenis_kelamin }}
                    </span>
                    @endif
                    @if($ds?->tahun_masuk)
                    <span class="santri-detail-chip">
                        <i class="fas fa-calendar"></i> {{ $ds->tahun_masuk }}
                    </span>
                    @endif
                    @if($ds?->agama)
                    <span class="santri-detail-chip">
                        <i class="fas fa-star-and-crescent"></i> {{ $ds->agama }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="santri-card-footer">
                Lihat Detail Profil Lengkap
                <i class="fas fa-arrow-right" style="font-size:.75rem;"></i>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($santri->hasPages())
    <div style="margin-top:28px;">
        {{ $santri->links() }}
    </div>
    @endif

@else
    <div class="card">
        <div class="empty-state">
            <i class="fas fa-folder-open empty-state-icon"></i>
            <h4>Belum Ada Data Santri</h4>
            <p>Akun Anda belum dihubungkan dengan data santri. Hubungi administrasi pesantren.</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-primary">
                <i class="fab fa-whatsapp"></i> Hubungi Admin
            </a>
        </div>
    </div>
@endif

@endsection
