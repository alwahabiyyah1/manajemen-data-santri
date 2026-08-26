@extends('layouts.wali')

@section('title', 'Detail Profil Santri')
@section('page-title', 'Detail Profil Santri')
@section('page-subtitle', 'Informasi lengkap data santri Anda')

@push('styles')
<style>
    /* Breadcrumb */
    .breadcrumb-nav {
        display: flex; align-items: center; gap: 6px;
        font-size: .78rem; color: #94a3b8; margin-bottom: 20px;
    }
    .breadcrumb-nav a { color: #10b981; text-decoration: none; font-weight: 600; }
    .breadcrumb-nav a:hover { text-decoration: underline; }
    .breadcrumb-nav span { color: #cbd5e1; }

    /* Hero Profile Banner */
    .profile-hero {
        border-radius: 18px;
        background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #10b981 100%);
        padding: 0;
        margin-bottom: 24px;
        overflow: hidden;
        position: relative;
    }
    .profile-hero.lulus    { background: linear-gradient(135deg, #1e3a8a, #2563eb, #60a5fa); }
    .profile-hero.keluar   { background: linear-gradient(135deg, #7f1d1d, #dc2626, #f87171); }
    .profile-hero.inactive { background: linear-gradient(135deg, #1f2937, #4b5563, #9ca3af); }

    .hero-bg-shape {
        position: absolute; top: -30px; right: -30px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
    }
    .hero-bg-shape2 {
        position: absolute; bottom: -50px; left: 30%;
        width: 150px; height: 150px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
    }

    .profile-hero-content {
        display: flex; align-items: center; gap: 24px;
        padding: 28px 32px;
        position: relative; z-index: 1;
        flex-wrap: wrap;
    }
    .profile-photo-wrap { flex-shrink: 0; }
    .profile-photo {
        width: 90px; height: 90px; border-radius: 50%;
        background: rgba(255,255,255,.15);
        border: 3px solid rgba(255,255,255,.4);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 2rem; color: #fff;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,.2);
    }
    .profile-photo img { width: 100%; height: 100%; object-fit: cover; }
    .profile-info { flex: 1; }
    .profile-info-name { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
    .profile-info-meta { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px; }
    .profile-meta-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
        border-radius: 20px; padding: 4px 12px;
        font-size: .78rem; color: rgba(255,255,255,.9); font-weight: 500;
    }
    .profile-status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
        border-radius: 20px; padding: 6px 14px;
        font-size: .82rem; color: #fff; font-weight: 700;
    }
    .profile-hero-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-left: auto; }
    .btn-glass {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.15); backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 10px; padding: 9px 18px;
        font-size: .82rem; font-weight: 600; color: #fff;
        text-decoration: none; cursor: pointer; transition: all .2s;
    }
    .btn-glass:hover { background: rgba(255,255,255,.25); color: #fff; }

    /* Detail Grid */
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    /* Section Cards */
    .section-card {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 16px; overflow: hidden; margin-bottom: 20px;
    }
    .section-card-header {
        padding: 14px 20px; display: flex; align-items: center; gap: 10px;
        border-bottom: 1px solid #f1f5f9;
    }
    .section-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; flex-shrink: 0;
    }
    .icon-green  { background: #d1fae5; color: #065f46; }
    .icon-blue   { background: #dbeafe; color: #1d4ed8; }
    .icon-red    { background: #fee2e2; color: #991b1b; }
    .icon-purple { background: #ede9fe; color: #6d28d9; }
    .icon-orange { background: #fef3c7; color: #d97706; }
    .section-card-title { font-size: .88rem; font-weight: 700; color: #1e293b; }
    .section-card-body  { padding: 6px 0; }

    /* Data Rows */
    .data-row {
        display: flex; align-items: flex-start;
        padding: 10px 20px; gap: 16px;
        transition: background .15s;
    }
    .data-row:hover { background: #fafafa; }
    .data-row + .data-row { border-top: 1px solid #f8fafc; }
    .data-row-label {
        font-size: .78rem; font-weight: 600; color: #94a3b8;
        min-width: 140px; padding-top: 1px;
    }
    .data-row-value { font-size: .85rem; color: #1e293b; font-weight: 600; word-break: break-word; }
    .data-row-value code { font-family: monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: .82rem; color: #475569; }

    /* Stat Mini Cards */
    .mini-stats { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin: 0 20px 16px; }
    .mini-stat {
        background: #f8fafc; border-radius: 10px;
        text-align: center; padding: 14px 10px;
    }
    .mini-stat-val   { font-size: 1.1rem; font-weight: 800; color: #1e293b; }
    .mini-stat-label { font-size: .68rem; color: #94a3b8; margin-top: 3px; text-transform: uppercase; font-weight: 600; letter-spacing: .04em; }

    /* Address block */
    .address-block {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #a7f3d0;
        border-radius: 10px; padding: 14px 16px; margin: 8px 20px 16px;
        font-size: .82rem; color: #1e293b; line-height: 1.7;
    }

    /* Alert special */
    .medis-alert {
        background: #fefce8; border: 1px solid #fde68a;
        border-radius: 10px; padding: 12px 16px;
        margin: 8px 20px 16px; font-size: .82rem; color: #92400e;
    }
    .medis-alert strong { display: block; margin-bottom: 4px; }

    /* Photo Card */
    .photo-card {
        border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0;
        text-align: center;
    }
    .photo-card img { width: 100%; display: block; max-height: 300px; object-fit: cover; }
    .photo-card-label { font-size: .75rem; color: #64748b; padding: 8px; background: #fafafa; font-weight: 600; }

    /* Readonly note */
    .readonly-note {
        text-align: center; padding: 16px;
        font-size: .8rem; color: #94a3b8;
        border-top: 1px solid #f1f5f9; margin-top: 8px;
    }

    /* ── Responsive Mobile ── */
    @media (max-width: 768px) {
        /* Profile hero — stack vertikal */
        .profile-hero-content { flex-direction: column; align-items: flex-start; padding: 20px 16px; gap: 14px; }
        .profile-info-name { font-size: 1.15rem; }
        .profile-hero-actions { margin-left: 0; width: 100%; }
        .profile-hero-actions a, .profile-hero-actions .btn-glass { flex: 1; justify-content: center; }

        /* Detail grid 1 kolom */
        .detail-grid { grid-template-columns: 1fr; gap: 0; }

        /* Data rows lebih compact */
        .data-row { padding: 9px 14px; gap: 10px; }
        .data-row-label { min-width: 110px; font-size: .73rem; }
        .data-row-value { font-size: .82rem; }

        /* Mini stats lebih kecil */
        .mini-stats { margin: 0 14px 14px; gap: 8px; }
        .mini-stat  { padding: 10px 6px; }
        .mini-stat-val { font-size: .9rem; }
        .mini-stat-label { font-size: .62rem; }

        /* Section header */
        .section-card-header { padding: 12px 14px; }
        .section-card-body { padding: 4px 0; }

        /* Address block */
        .address-block { margin: 8px 14px 14px; }
        .medis-alert   { margin: 8px 14px 14px; }

        /* Breadcrumb wrapping */
        .breadcrumb-nav { flex-wrap: wrap; }
    }
    @media (max-width: 480px) {
        .profile-info-meta { gap: 6px; }
        .profile-meta-chip { font-size: .72rem; padding: 3px 8px; }
        .data-row-label { min-width: 90px; }
    }
</style>
@endpush

@section('content')

@php
    $ds = $santri->dataSantri;
    $da = $santri->dataAyah;
    $di = $santri->dataIbu;
    $dw = $santri->dataWali;
    $as = $santri->alamatSantri;
    $statusMap = [
        'aktif'       => ['badge'=>'badge-success','cls'=>'',        'label'=>'Aktif'],
        'lulus'       => ['badge'=>'badge-info',   'cls'=>'lulus',   'label'=>'Lulus'],
        'keluar'      => ['badge'=>'badge-danger',  'cls'=>'keluar',  'label'=>'Keluar'],
        'tidak aktif' => ['badge'=>'badge-secondary','cls'=>'inactive','label'=>'Tidak Aktif'],
    ];
    $st = $statusMap[$santri->status_data] ?? $statusMap['tidak aktif'];
@endphp

{{-- Breadcrumb --}}
<div class="breadcrumb-nav">
    <a href="{{ route('wali.dashboard') }}"><i class="fas fa-house"></i> Beranda</a>
    <span>/</span>
    <a href="{{ route('wali.santri.index') }}">Data Santri</a>
    <span>/</span>
    <span>{{ $ds->nama_lengkap ?? 'Detail Santri' }}</span>
</div>

{{-- Profile Banner --}}
<div class="profile-hero {{ $st['cls'] }}">
    <div class="hero-bg-shape"></div>
    <div class="hero-bg-shape2"></div>
    <div class="profile-hero-content">
        <div class="profile-photo-wrap">
            <div class="profile-photo">
                @if($ds && $ds->foto_3x4 && file_exists(public_path('storage/berkas/'.$ds->foto_3x4)))
                    <img src="{{ asset('storage/berkas/'.$ds->foto_3x4) }}" alt="Foto Santri">
                @else
                    {{ strtoupper(substr($ds->nama_lengkap ?? '?', 0, 1)) }}
                @endif
            </div>
        </div>
        <div class="profile-info">
            <div class="profile-info-name">{{ $ds->nama_lengkap ?? 'Data Belum Lengkap' }}</div>
            <div class="profile-info-meta">
                <span class="profile-meta-chip"><i class="fas fa-id-badge"></i> NIS #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}</span>
                @if($ds?->jenis_kelamin)<span class="profile-meta-chip"><i class="fas fa-venus-mars"></i> {{ $ds->jenis_kelamin }}</span>@endif
                @if($ds?->tahun_masuk)<span class="profile-meta-chip"><i class="fas fa-calendar-check"></i> Angkatan {{ $ds->tahun_masuk }}</span>@endif
            </div>
            <span class="profile-status-badge">
                <i class="fas fa-circle" style="font-size:.5rem;"></i>
                {{ ucfirst($santri->status_data) }}
            </span>
        </div>
        <div class="profile-hero-actions">
            <a href="{{ route('wali.santri.index') }}" class="btn-glass">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('wali.santri.edit', $santri->id) }}"
               style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:#065f46;border-radius:10px;padding:9px 18px;font-size:.82rem;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,.1);transition:all .2s;">
                <i class="fas fa-pen-to-square"></i> Edit Data
            </a>
        </div>
    </div>
</div>

{{-- Detail Grid --}}
<div class="detail-grid">

    {{-- === KOLOM KIRI === --}}
    <div>
        {{-- Biodata Santri --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon icon-green"><i class="fas fa-file-lines"></i></div>
                <div class="section-card-title">Biodata Lengkap</div>
            </div>
            <div class="section-card-body">
                <div class="data-row">
                    <div class="data-row-label">Tanggal Lahir</div>
                    <div class="data-row-value">{{ $ds?->tanggal_lahir ? date('d F Y', strtotime($ds->tanggal_lahir)) : '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Tempat Lahir</div>
                    <div class="data-row-value">{{ $ds?->tempat_lahir ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">NIK</div>
                    <div class="data-row-value"><code>{{ $ds?->nik ?? '-' }}</code></div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">No. KK</div>
                    <div class="data-row-value"><code>{{ $ds?->no_kk ?? '-' }}</code></div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Nama Kepala Keluarga</div>
                    <div class="data-row-value">{{ $ds?->nama_kapala_keluarga ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Agama</div>
                    <div class="data-row-value">{{ $ds?->agama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Kewarganegaraan</div>
                    <div class="data-row-value">{{ $ds?->kewarganegaraan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Anak ke / Jml Saudara</div>
                    <div class="data-row-value">{{ $ds?->anak_ke ?? '?' }} dari {{ $ds?->jumlah_saudara ?? '?' }} bersaudara</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">No. HP Santri</div>
                    <div class="data-row-value">{{ $ds?->no_hp ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Email Santri</div>
                    <div class="data-row-value">{{ $ds?->email ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Cita-cita / Hobi</div>
                    <div class="data-row-value">{{ $ds?->cita_cita ?? '-' }} / {{ $ds?->hobi ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pembiaya Sekolah</div>
                    <div class="data-row-value">{{ $ds?->pembiaya_sekolah ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Tahun Keluar</div>
                    <div class="data-row-value">{{ $ds?->tahun_keluar ?? '-' }}</div>
                </div>
                @if($ds?->kebutuhan_khusus || $ds?->kebutuhan_disabilitas)
                <div class="medis-alert">
                    <strong><i class="fas fa-notes-medical" style="margin-right:6px;"></i>Catatan Medis / Khusus</strong>
                    {{ $ds->kebutuhan_khusus ?: '-' }}
                    @if($ds->kebutuhan_disabilitas)<br>{{ $ds->kebutuhan_disabilitas }}@endif
                </div>
                @endif
            </div>
        </div>

        {{-- Domisili --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon icon-green"><i class="fas fa-house-chimney"></i></div>
                <div class="section-card-title">Domisili & Kepulangan</div>
            </div>
            <div class="section-card-body">
                <div class="mini-stats" style="margin-top:12px;">
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="font-size:.85rem;">{{ $as?->status_mukim ?? '-' }}</div>
                        <div class="mini-stat-label">Status Mukim</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="font-size:.85rem;">{{ $as?->status_tempat_tinggal ?? '-' }}</div>
                        <div class="mini-stat-label">Tinggal Bersama</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="font-size:.85rem;">{{ $as?->transportasi ?? '-' }}</div>
                        <div class="mini-stat-label">Transportasi</div>
                    </div>
                </div>
                <div class="address-block">
                    <div style="font-size:.73rem;color:#065f46;font-weight:700;margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em;">
                        <i class="fas fa-map-location-dot" style="margin-right:5px;"></i>Alamat Lengkap
                    </div>
                    @if($as && ($as->alamat || $as->provinsi))
                        @if($as->provinsi)Prov. {{ $as->provinsi }}@endif
                        @if($as->kabupaten), {{ $as->kabupaten }}@endif
                        @if($as->kecamatan)<br>Kec. {{ $as->kecamatan }}@endif
                        @if($as->desa), Kel/Desa. {{ $as->desa }}@endif
                        @if($as->rw || $as->rt)<br>RW {{ $as->rw ?? '-' }} / RT {{ $as->rt ?? '-' }}@endif
                        @if($as->kode_pos), Kode Pos: {{ $as->kode_pos }}@endif
                        @if($as->alamat)<br><strong>{{ $as->alamat }}</strong>@endif
                    @else
                        Belum diinput
                    @endif
                </div>
                <div class="data-row">
                    <div class="data-row-label">Jarak ke Pesantren</div>
                    <div class="data-row-value">{{ $as?->jarak_ke_lembaga ?? '-' }} Km</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Waktu Tempuh</div>
                    <div class="data-row-value">{{ $as?->waktu_tempuh ?? '-' }} Menit</div>
                </div>
            </div>
        </div>

        {{-- Foto KK --}}
        @if($ds?->foto_kk && file_exists(public_path('storage/berkas/'.$ds->foto_kk)))
            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-icon icon-purple"><i class="fas fa-image"></i></div>
                    <div class="section-card-title">Kartu Keluarga</div>
                </div>
                <div class="section-card-body" style="padding:16px 20px;">
                    <div class="photo-card">
                        <a href="{{ asset('storage/berkas/'.$ds->foto_kk) }}" target="_blank">
                            <img src="{{ asset('storage/berkas/'.$ds->foto_kk) }}" alt="Foto KK">
                        </a>
                        <div class="photo-card-label"><i class="fas fa-external-link-alt" style="margin-right:4px;"></i>Klik untuk perbesar</div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- === KOLOM KANAN === --}}
    <div>
        {{-- Data Ayah --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon icon-blue"><i class="fas fa-user-tie"></i></div>
                <div class="section-card-title" style="color:#1d4ed8;">Identitas Ayah</div>
            </div>
            <div class="section-card-body">
                <div style="padding: 12px 20px 8px; display:flex;align-items:center;gap:12px;border-bottom:1px solid #f8fafc;margin-bottom:4px;">
                    <div style="width:44px;height:44px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.2rem;color:#1d4ed8;">
                        {{ strtoupper(substr($da?->nama_lengkap ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;color:#1e293b;font-size:.9rem;">{{ $da?->nama_lengkap ?? 'Belum Diisi' }}</div>
                        <span class="badge badge-info" style="margin-top:2px;">{{ $da?->status ?? '-' }}</span>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">NIK Ayah</div>
                    <div class="data-row-value"><code>{{ $da?->nik ?? '-' }}</code></div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Tempat, Tgl Lahir</div>
                    <div class="data-row-value">{{ $da?->tempat_lahir ?? '-' }}, {{ $da?->tanggal_lahir ? date('d M Y', strtotime($da->tanggal_lahir)) : '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Kewarganegaraan</div>
                    <div class="data-row-value">{{ $da?->kewarganegaraan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pendidikan</div>
                    <div class="data-row-value">{{ $da?->pendidikan_terakhir ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pekerjaan</div>
                    <div class="data-row-value">{{ $da?->pekerjaan_utama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Penghasilan / Bln</div>
                    <div class="data-row-value">Rp {{ $da?->penghasilan_perbulan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">No. HP / WA</div>
                    <div class="data-row-value">
                        @if($da?->no_hp)
                            <a href="https://wa.me/62{{ ltrim($da->no_hp,'0') }}" target="_blank" style="color:#10b981;text-decoration:none;font-weight:600;">
                                <i class="fab fa-whatsapp" style="margin-right:4px;"></i>{{ $da->no_hp }}
                            </a>
                        @else - @endif
                    </div>
                </div>
                <div class="data-row" style="background:#f8fafc; border-top:1px solid #f1f5f9;">
                    <div class="data-row-label" style="align-self: flex-start; padding-top: 2px;">Alamat Lengkap</div>
                    <div class="data-row-value" style="font-weight:400; line-height:1.5; font-size:.8rem;">
                        @php $aa = $da?->alamat; @endphp
                        @if($aa && ($aa->alamat || $aa->provinsi))
                            @if($aa->provinsi)Prov. {{ $aa->provinsi }}@endif
                            @if($aa->kabupaten), {{ $aa->kabupaten }}@endif
                            @if($aa->kecamatan)<br>Kec. {{ $aa->kecamatan }}@endif
                            @if($aa->desa), Kel/Desa. {{ $aa->desa }}@endif
                            @if($aa->rw || $aa->rt)<br>RW {{ $aa->rw ?? '-' }} / RT {{ $aa->rt ?? '-' }}@endif
                            @if($aa->kode_pos), Kode Pos: {{ $aa->kode_pos }}@endif
                            @if($aa->alamat)<br><strong>{{ $aa->alamat }}</strong>@endif
                            <div style="margin-top:6px; padding-top:6px; border-top:1px dashed #cbd5e1; font-size:.75rem; color:#64748b;">
                                <i class="fas fa-home" style="margin-right:4px;"></i>Kepemilikan: <strong>{{ $aa->status_kepemilikan ?? '-' }}</strong>
                            </div>
                        @else
                            <span style="color:#94a3b8;font-style:italic;">Belum diinput</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Ibu --}}
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon icon-red"><i class="fas fa-person-dress"></i></div>
                <div class="section-card-title" style="color:#991b1b;">Identitas Ibu</div>
            </div>
            <div class="section-card-body">
                <div style="padding: 12px 20px 8px; display:flex;align-items:center;gap:12px;border-bottom:1px solid #f8fafc;margin-bottom:4px;">
                    <div style="width:44px;height:44px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.2rem;color:#991b1b;">
                        {{ strtoupper(substr($di?->nama_lengkap ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;color:#1e293b;font-size:.9rem;">{{ $di?->nama_lengkap ?? 'Belum Diisi' }}</div>
                        <span class="badge badge-danger" style="margin-top:2px;">{{ $di?->status ?? '-' }}</span>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">NIK Ibu</div>
                    <div class="data-row-value"><code>{{ $di?->nik ?? '-' }}</code></div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Tempat, Tgl Lahir</div>
                    <div class="data-row-value">{{ $di?->tempat_lahir ?? '-' }}, {{ $di?->tanggal_lahir ? date('d M Y', strtotime($di->tanggal_lahir)) : '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Kewarganegaraan</div>
                    <div class="data-row-value">{{ $di?->kewarganegaraan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pendidikan</div>
                    <div class="data-row-value">{{ $di?->pendidikan_terakhir ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pekerjaan</div>
                    <div class="data-row-value">{{ $di?->pekerjaan_utama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Penghasilan / Bln</div>
                    <div class="data-row-value">Rp {{ $di?->penghasilan_perbulan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">No. HP / WA</div>
                    <div class="data-row-value">
                        @if($di?->no_hp)
                            <a href="https://wa.me/62{{ ltrim($di->no_hp,'0') }}" target="_blank" style="color:#10b981;text-decoration:none;font-weight:600;">
                                <i class="fab fa-whatsapp" style="margin-right:4px;"></i>{{ $di->no_hp }}
                            </a>
                        @else - @endif
                    </div>
                </div>
                <div class="data-row" style="background:#f8fafc; border-top:1px solid #f1f5f9;">
                    <div class="data-row-label" style="align-self: flex-start; padding-top: 2px;">Alamat Lengkap</div>
                    <div class="data-row-value" style="font-weight:400; line-height:1.5; font-size:.8rem;">
                        @php $ai = $di?->alamat; @endphp
                        @if($ai && ($ai->alamat || $ai->provinsi))
                            @if($ai->provinsi)Prov. {{ $ai->provinsi }}@endif
                            @if($ai->kabupaten), {{ $ai->kabupaten }}@endif
                            @if($ai->kecamatan)<br>Kec. {{ $ai->kecamatan }}@endif
                            @if($ai->desa), Kel/Desa. {{ $ai->desa }}@endif
                            @if($ai->rw || $ai->rt)<br>RW {{ $ai->rw ?? '-' }} / RT {{ $ai->rt ?? '-' }}@endif
                            @if($ai->kode_pos), Kode Pos: {{ $ai->kode_pos }}@endif
                            @if($ai->alamat)<br><strong>{{ $ai->alamat }}</strong>@endif
                            <div style="margin-top:6px; padding-top:6px; border-top:1px dashed #cbd5e1; font-size:.75rem; color:#64748b;">
                                <i class="fas fa-home" style="margin-right:4px;"></i>Kepemilikan: <strong>{{ $ai->status_kepemilikan ?? '-' }}</strong>
                            </div>
                        @else
                            <span style="color:#94a3b8;font-style:italic;">Belum diinput</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Data Wali --}}
        @if($dw)
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-user-shield"></i></div>
                <div class="section-card-title" style="color:#d97706;">Identitas Wali</div>
            </div>
            <div class="section-card-body">
                <div style="padding: 12px 20px 8px; display:flex;align-items:center;gap:12px;border-bottom:1px solid #f8fafc;margin-bottom:4px;">
                    <div style="width:44px;height:44px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.2rem;color:#d97706;">
                        {{ strtoupper(substr($dw?->nama_lengkap ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:700;color:#1e293b;font-size:.9rem;">{{ $dw?->nama_lengkap ?? 'Belum Diisi' }}</div>
                        <span class="badge badge-warning" style="margin-top:2px;">{{ $dw?->status ?? '-' }}</span>
                    </div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">NIK Wali</div>
                    <div class="data-row-value"><code>{{ $dw?->nik ?? '-' }}</code></div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Tempat, Tgl Lahir</div>
                    <div class="data-row-value">{{ $dw?->tempat_lahir ?? '-' }}, {{ $dw?->tanggal_lahir ? date('d M Y', strtotime($dw->tanggal_lahir)) : '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Kewarganegaraan</div>
                    <div class="data-row-value">{{ $dw?->kewarganegaraan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pendidikan</div>
                    <div class="data-row-value">{{ $dw?->pendidikan_terakhir ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Pekerjaan</div>
                    <div class="data-row-value">{{ $dw?->pekerjaan_utama ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Penghasilan / Bln</div>
                    <div class="data-row-value">Rp {{ $dw?->penghasilan_perbulan ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">No. HP / WA</div>
                    <div class="data-row-value">
                        @if($dw?->no_hp)
                            <a href="https://wa.me/62{{ ltrim($dw->no_hp,'0') }}" target="_blank" style="color:#10b981;text-decoration:none;font-weight:600;">
                                <i class="fab fa-whatsapp" style="margin-right:4px;"></i>{{ $dw->no_hp }}
                            </a>
                        @else - @endif
                    </div>
                </div>
                <div class="data-row" style="background:#f8fafc; border-top:1px solid #f1f5f9;">
                    <div class="data-row-label" style="align-self: flex-start; padding-top: 2px;">Alamat Lengkap</div>
                    <div class="data-row-value" style="font-weight:400; line-height:1.5; font-size:.8rem;">
                        @php $aw = $dw?->alamat; @endphp
                        @if($aw && ($aw->alamat || $aw->provinsi))
                            @if($aw->provinsi)Prov. {{ $aw->provinsi }}@endif
                            @if($aw->kabupaten), {{ $aw->kabupaten }}@endif
                            @if($aw->kecamatan)<br>Kec. {{ $aw->kecamatan }}@endif
                            @if($aw->desa), Kel/Desa. {{ $aw->desa }}@endif
                            @if($aw->rw || $aw->rt)<br>RW {{ $aw->rw ?? '-' }} / RT {{ $aw->rt ?? '-' }}@endif
                            @if($aw->kode_pos), Kode Pos: {{ $aw->kode_pos }}@endif
                            @if($aw->alamat)<br><strong>{{ $aw->alamat }}</strong>@endif
                            <div style="margin-top:6px; padding-top:6px; border-top:1px dashed #cbd5e1; font-size:.75rem; color:#64748b;">
                                <i class="fas fa-home" style="margin-right:4px;"></i>Kepemilikan: <strong>{{ $aw->status_kepemilikan ?? '-' }}</strong>
                            </div>
                        @else
                            <span style="color:#94a3b8;font-style:italic;">Belum diinput</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Pendidikan Sebelumnya --}}
        @if($ds?->nama_sekolah_asal || $ds?->jenjang_pendidikan_asal)
        <div class="section-card">
            <div class="section-card-header">
                <div class="section-icon icon-orange"><i class="fas fa-school"></i></div>
                <div class="section-card-title">Pendidikan Sebelumnya</div>
            </div>
            <div class="section-card-body">
                <div class="data-row">
                    <div class="data-row-label">Nama Sekolah Asal</div>
                    <div class="data-row-value">{{ $ds->nama_sekolah_asal ?? '-' }}</div>
                </div>
                <div class="data-row">
                    <div class="data-row-label">Jenjang</div>
                    <div class="data-row-value">{{ $ds->jenjang_pendidikan_asal ?? '-' }}</div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Readonly Note --}}
<div class="readonly-note">
    <i class="fas fa-circle-info" style="margin-right:5px;color:#10b981;"></i>
    Data di atas bersifat <strong>read-only</strong>. Jika terdapat kesalahan data, harap hubungi administrasi pesantren.
</div>

@endsection
