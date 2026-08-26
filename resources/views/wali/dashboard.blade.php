@extends('layouts.wali')

@section('title', 'Beranda Wali')
@section('page-title', 'Beranda')
@section('page-subtitle', 'Selamat datang, pantau data santri Anda di sini')

@push('styles')
<style>
    /* Hero Welcome */
    .hero-card {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 70%, #10b981 100%);
        border-radius: 18px;
        padding: 32px 36px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        border: none;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,.05);
        border-radius: 50%;
    }
    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -40px; right: 100px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
    }
    .hero-greeting { font-size: .8rem; font-weight: 600; letter-spacing: .06em; opacity: .7; text-transform: uppercase; margin-bottom: 6px; }
    .hero-name     { font-size: 1.75rem; font-weight: 800; margin-bottom: 8px; }
    .hero-sub      { font-size: .875rem; opacity: .75; max-width: 480px; }
    .hero-badge    { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,.15); backdrop-filter: blur(8px); border-radius: 20px; padding: 5px 14px; font-size: .78rem; font-weight: 600; margin-top: 16px; }
    .hero-icon     { position: absolute; right: 40px; top: 50%; transform: translateY(-50%); font-size: 6rem; opacity: .08; }

    /* Stat Cards */
    .stats-grid    { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .stat-card     { background: #fff; border-radius: 14px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,.06); display: flex; align-items: center; gap: 16px; transition: box-shadow .2s, transform .2s; }
    .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-2px); }
    .stat-icon     { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .stat-icon.green  { background: #d1fae5; color: #065f46; }
    .stat-icon.blue   { background: #dbeafe; color: #1d4ed8; }
    .stat-icon.purple { background: #ede9fe; color: #6d28d9; }
    .stat-icon.orange { background: #fef3c7; color: #d97706; }
    .stat-value    { font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1; }
    .stat-label    { font-size: .75rem; color: #64748b; margin-top: 4px; font-weight: 500; }

    /* Two-column grid */
    .dashboard-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .dashboard-grid { grid-template-columns: 1fr; } }

    /* Quick Info Card */
    .info-item { display: flex; align-items: center; gap: 10px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
    .info-item:last-child { border-bottom: none; }
    .info-item-icon { width: 34px; height: 34px; border-radius: 8px; background: #f0fdf4; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink: 0; }
    .info-item-label { font-size: .73rem; color: #64748b; font-weight: 500; }
    .info-item-val   { font-size: .85rem; font-weight: 700; color: #1e293b; }

    /* Santri Cards */
    .santri-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
    .santri-card {
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #fff;
        overflow: hidden;
        transition: all .25s;
        text-decoration: none;
        display: block;
        position: relative;
    }
    .santri-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-3px); }
    .santri-card-top {
        padding: 24px 20px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background: linear-gradient(180deg, #f0fdf4 0%, #fff 100%);
        border-bottom: 1px solid #f1f5f9;
    }
    .santri-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 800; font-size: 1.6rem;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(16,185,129,.3);
    }
    .santri-name { font-size: .9rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .santri-card-bottom { padding: 12px 20px; }
    .santri-meta { display: flex; gap: 8px; flex-direction: column; }
    .santri-meta-row { display: flex; align-items: center; gap: 6px; font-size: .78rem; color: #64748b; }
    .santri-meta-row i { width: 16px; color: #10b981; }
    .santri-cta { display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; border-top: 1px solid #f1f5f9; background: #fafafa; font-size: .78rem; color: #10b981; font-weight: 600; }

    /* Empty State */
    .empty-state { text-align: center; padding: 48px 24px; }
    .empty-state-icon { font-size: 3.5rem; color: #cbd5e1; margin-bottom: 16px; }
    .empty-state h5 { font-size: 1rem; font-weight: 700; color: #475569; margin-bottom: 8px; }
    .empty-state p  { font-size: .85rem; color: #94a3b8; max-width: 320px; margin: 0 auto 20px; }

    /* ── Responsive Mobile ── */
    @media (max-width: 768px) {
        /* Hero lebih kompak */
        .hero-card { padding: 20px 20px; margin-bottom: 16px; border-radius: 14px; }
        .hero-name  { font-size: 1.3rem; }
        .hero-sub   { font-size: .8rem; }
        .hero-badge { font-size: .72rem; padding: 4px 10px; }
        .hero-icon  { font-size: 4rem; right: 16px; }

        /* Stat cards 2 kolom di HP */
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .stat-card  { padding: 14px 12px; gap: 10px; }
        .stat-icon  { width: 40px; height: 40px; font-size: 1rem; border-radius: 10px; }
        .stat-value { font-size: 1.3rem; }

        /* Dashboard grid 1 kolom */
        .dashboard-grid { grid-template-columns: 1fr; gap: 14px; }

        /* Santri grid 1 kolom */
        .santri-grid { grid-template-columns: 1fr; gap: 12px; }
        .santri-card-top { padding: 16px 16px 12px; }
        .santri-cta { padding: 8px 16px; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
        .stat-card  { padding: 12px 10px; }
        .stat-value { font-size: 1.1rem; }
        .stat-label { font-size: .68rem; }
    }
</style>
@endpush

@section('content')

@php
    $aktif    = $santri->where('status_data', 'aktif')->count();
    $lulus    = $santri->where('status_data', 'lulus')->count();
    $statusMap = ['aktif'=>'badge-success','lulus'=>'badge-info','keluar'=>'badge-danger','tidak aktif'=>'badge-secondary'];
@endphp

{{-- Hero Welcome --}}
<div class="hero-card">
    <div class="hero-greeting"><i class="fas fa-star" style="margin-right:6px;"></i>Ahlan wa Sahlan</div>
    <div class="hero-name">{{ $wali->nama_wali }}</div>
    <div class="hero-sub">Selamat datang di Portal Wali Santri. Pantau informasi lengkap dan perkembangan ananda Anda.</div>
    <div>
        <span class="hero-badge">
            <i class="fas fa-circle-check"></i>
            {{ $santri->count() }} Santri Terhubung dengan Akun Anda
        </span>
    </div>
    <i class="fas fa-mosque hero-icon"></i>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-value">{{ $santri->count() }}</div>
            <div class="stat-label">Total Santri</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-circle-check"></i></div>
        <div>
            <div class="stat-value">{{ $aktif }}</div>
            <div class="stat-label">Status Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <div class="stat-value">{{ $lulus }}</div>
            <div class="stat-label">Sudah Lulus</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-phone"></i></div>
        <div>
            <div class="stat-value">{{ $wali->no_hp ?? '-' }}</div>
            <div class="stat-label">No. HP Anda</div>
        </div>
    </div>
</div>

{{-- Main Grid --}}
<div class="dashboard-grid">

    {{-- Left: Wali Info --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-id-card" style="color:#10b981;"></i> Profil Wali</h6>
            </div>
            <div class="card-body" style="padding:16px 20px;">
                <div style="text-align:center;padding:16px 0 20px;border-bottom:1px solid #f1f5f9;margin-bottom:16px;">
                    <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#10b981,#6366f1);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.8rem;box-shadow:0 4px 16px rgba(16,185,129,.3);margin-bottom:10px;">
                        {{ strtoupper(substr($wali->nama_wali, 0, 1)) }}
                    </div>
                    <div style="font-weight:700;color:#1e293b;">{{ $wali->nama_wali }}</div>
                    <div style="font-size:.78rem;color:#64748b;margin-top:4px;">Wali Santri</div>
                </div>

                <div class="info-item">
                    <div class="info-item-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="info-item-label">No. Telepon / WA</div>
                        <div class="info-item-val">{{ $wali->no_hp ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="info-item-label">Email</div>
                        <div class="info-item-val">{{ $wali->email ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon"><i class="fas fa-children"></i></div>
                    <div>
                        <div class="info-item-label">Jumlah Santri</div>
                        <div class="info-item-val">{{ $santri->count() }} orang</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Link --}}
        <div class="card" style="margin-top:16px;">
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <a href="{{ route('wali.santri.index') }}" class="btn btn-primary" style="justify-content:center;">
                    <i class="fas fa-table-list"></i> Lihat Semua Data Santri
                </a>
            </div>
        </div>
    </div>

    {{-- Right: Santri List --}}
    <div>
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-children" style="color:#10b981;"></i> Daftar Santri Anda</h6>
                <span class="badge badge-success">{{ $santri->count() }} Santri</span>
            </div>
            <div class="card-body">
                @if($santri->count() > 0)
                    <div class="santri-grid">
                        @foreach($santri as $s)
                        @php
                            $ds = $s->dataSantri;
                            $badge = $statusMap[$s->status_data] ?? 'badge-secondary';
                        @endphp
                        <a href="{{ route('wali.santri.show', $s->id) }}" class="santri-card">
                            <div class="santri-card-top">
                                @if($ds && $ds->foto_3x4 && file_exists(public_path('storage/'.$ds->foto_3x4)))
                                    <img src="{{ asset('storage/'.$ds->foto_3x4) }}"
                                         style="width:64px;height:64px;border-radius:50%;object-fit:cover;margin-bottom:10px;box-shadow:0 4px 12px rgba(0,0,0,.15);" alt="Foto">
                                @else
                                    <div class="santri-avatar">
                                        {{ strtoupper(substr($ds->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="santri-name">{{ $ds->nama_lengkap ?? 'Data Belum Lengkap' }}</div>
                                <span class="badge {{ $badge }}">{{ ucfirst($s->status_data) }}</span>
                            </div>
                            <div class="santri-card-bottom">
                                <div class="santri-meta">
                                    <div class="santri-meta-row"><i class="fas fa-id-badge"></i> NIS #{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="santri-meta-row"><i class="fas fa-venus-mars"></i> {{ $ds->jenis_kelamin ?? '-' }}</div>
                                    <div class="santri-meta-row"><i class="fas fa-calendar-check"></i> Angkatan {{ $ds->tahun_masuk ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="santri-cta">
                                Lihat Detail Profil
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                        <h5>Belum Ada Data Santri</h5>
                        <p>Akun Anda belum dihubungkan dengan data santri. Hubungi admin pesantren untuk informasi lebih lanjut.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
