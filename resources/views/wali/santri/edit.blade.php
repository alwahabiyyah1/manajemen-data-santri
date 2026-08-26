@extends('layouts.wali')

@section('title', 'Edit Data Santri')
@section('page-title', 'Edit Data Santri')
@section('page-subtitle', 'Perbarui informasi data santri Anda')

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

    /* Section Header */
    .section-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,.06);
    }
    .section-header {
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
    }
    .section-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; flex-shrink: 0;
    }
    .icon-green  { background: #d1fae5; color: #065f46; }
    .icon-blue   { background: #dbeafe; color: #1d4ed8; }
    .icon-red    { background: #fee2e2; color: #991b1b; }
    .icon-orange { background: #fef3c7; color: #d97706; }
    .section-title { font-size: .9rem; font-weight: 700; color: #1e293b; }
    .section-body  { padding: 20px; }

    /* Form Grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-grid.col-3 { grid-template-columns: 1fr 1fr 1fr; }
    .form-full { grid-column: 1 / -1; }
    @media (max-width: 768px) {
        .form-grid, .form-grid.col-3 { grid-template-columns: 1fr; }
    }

    /* Form Fields */
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-label {
        font-size: .78rem; font-weight: 700; color: #374151;
        letter-spacing: .01em;
    }
    .form-label .req { color: #ef4444; margin-left: 2px; }
    .form-label .opt { color: #94a3b8; font-weight: 400; font-size: .72rem; }
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: inherit;
        font-size: .875rem;
        color: #1e293b;
        background: #fafafa;
        transition: border-color .2s, box-shadow .2s, background .2s;
        outline: none;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #10b981;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(16,185,129,.1);
    }
    .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.08);
    }
    .form-textarea { resize: vertical; min-height: 80px; }
    .field-error  { font-size: .75rem; color: #ef4444; display: flex; align-items: center; gap: 4px; }
    .field-hint   { font-size: .73rem; color: #94a3b8; }

    /* Photo upload */
    .photo-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        background: #fafafa;
        position: relative;
    }
    .photo-upload-area:hover { border-color: #10b981; background: #f0fdf4; }
    .photo-upload-area input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    /* Preview foto 3x4 — portrait */
    .photo-preview-portrait {
        width: 90px; height: 120px;
        border-radius: 8px;
        object-fit: cover;
        margin: 0 auto 8px;
        display: block;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    /* Preview foto KK — landscape */
    .photo-preview-landscape {
        width: 100%; max-width: 240px; height: 135px;
        border-radius: 8px;
        object-fit: cover;
        margin: 0 auto 8px;
        display: block;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    /* Badge rasio */
    .ratio-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: .68rem; font-weight: 700; border-radius: 20px;
        padding: 3px 10px; margin-bottom: 8px;
        letter-spacing: .02em;
    }
    .ratio-badge-portrait  { background: #dbeafe; color: #1d4ed8; }
    .ratio-badge-landscape { background: #d1fae5; color: #065f46; }
    .photo-upload-icon { font-size: 1.5rem; color: #cbd5e1; margin-bottom: 6px; }
    .photo-upload-label { font-size: .78rem; color: #64748b; font-weight: 600; }
    .photo-upload-sub   { font-size: .72rem; color: #94a3b8; }

    /* Action buttons */
    .form-actions {
        display: flex; gap: 12px; align-items: center;
        justify-content: flex-end;
        padding-top: 8px;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff; border: none;
        padding: 11px 28px; border-radius: 10px;
        font-family: inherit; font-size: .875rem; font-weight: 700;
        cursor: pointer; box-shadow: 0 4px 12px rgba(16,185,129,.3);
        transition: all .2s;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,.4); }
    .btn-save:disabled { opacity:.6; cursor:not-allowed; transform:none; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 6px;
        background: transparent; border: 1.5px solid #e2e8f0;
        color: #64748b; padding: 10px 20px; border-radius: 10px;
        font-family: inherit; font-size: .875rem; font-weight: 600;
        cursor: pointer; text-decoration: none; transition: all .2s;
    }
    .btn-cancel:hover { border-color: #94a3b8; color: #374151; }

    /* Page header */
    .edit-page-header {
        display: flex; align-items: center; gap: 16px;
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 16px; padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,.06);
    }
    .edit-avatar {
        width: 56px; height: 56px; border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.4rem; color: #fff; flex-shrink: 0;
        position: relative; cursor: pointer;
    }
    .edit-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .edit-avatar-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.5); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.1rem; opacity: 0; transition: opacity 0.2s;
    }
    .edit-avatar:hover .edit-avatar-overlay { opacity: 1; }
    .edit-header-info h2 { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
    .edit-header-info p  { font-size: .8rem; color: #64748b; margin-top: 2px; }

    /* ── Responsive Mobile ── */
    @media (max-width: 768px) {
        /* Page header stack vertikal */
        .edit-page-header { flex-wrap: wrap; gap: 12px; padding: 14px 16px; }
        .edit-header-info h2 { font-size: .95rem; }
        .edit-header-info p  { font-size: .75rem; }

        /* Section body padding lebih kecil */
        .section-body { padding: 14px; }
        .section-header { padding: 12px 14px; }

        /* Input & select lebih besar di HP (mudah disentuh) */
        .form-input, .form-select, .form-textarea {
            font-size: 1rem;       /* minimal 16px untuk cegah zoom di iOS */
            padding: 11px 13px;
            border-radius: 9px;
        }

        /* Tombol aksi full-width di HP */
        .form-actions { flex-direction: column-reverse; gap: 8px; }
        .btn-save, .btn-cancel { width: 100%; justify-content: center; padding: 13px; }

        /* Breadcrumb wrapping */
        .breadcrumb-nav { flex-wrap: wrap; }

        /* Sync badge wrap */
        .card .card-header.bg-warning { flex-wrap: wrap; gap: 8px; }
    }
    @media (max-width: 480px) {
        .section-body { padding: 10px; }
        .ratio-badge  { font-size: .62rem; }
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
    $aa = $da?->alamat;
    $ai = $di?->alamat;
    $aw = $dw?->alamat;
@endphp

{{-- Breadcrumb --}}
<div class="breadcrumb-nav">
    <a href="{{ route('wali.dashboard') }}"><i class="fas fa-house"></i> Beranda</a>
    <span>/</span>
    <a href="{{ route('wali.santri.index') }}">Data Santri</a>
    <span>/</span>
    <a href="{{ route('wali.santri.show', $santri->id) }}">{{ $ds->nama_lengkap ?? 'Detail' }}</a>
    <span>/</span>
    <span>Edit</span>
</div>

{{-- Page Header --}}
<div class="edit-page-header">
    <div class="edit-avatar" onclick="document.getElementById('inputFoto').click()" title="Klik untuk ganti foto profil">
        @if($ds?->foto_3x4 && file_exists(public_path('storage/berkas/'.$ds->foto_3x4)))
            <img src="{{ asset('storage/berkas/'.$ds->foto_3x4) }}" alt="Foto" id="headerAvatar">
        @else
            <span id="headerAvatar">{{ strtoupper(substr($ds->nama_lengkap ?? '?', 0, 1)) }}</span>
        @endif
        <div class="edit-avatar-overlay"><i class="fas fa-camera"></i></div>
    </div>
    <div class="edit-header-info">
        <h2>Edit Data: {{ $ds->nama_lengkap ?? 'Data Santri' }}</h2>
        <p>NIS #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }} &mdash; Perbarui seluruh data secara lengkap sesuai dokumen</p>
    </div>
</div>

{{-- Form --}}
<form method="POST" action="{{ route('wali.santri.update', $santri->id) }}" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 15px 20px; margin-bottom: 20px; border-radius: 12px; font-size: 0.85rem;">
            <strong><i class="fas fa-triangle-exclamation"></i> Gagal Menyimpan!</strong> Silakan periksa kembali isian Anda:
            <ul style="margin-top: 10px; padding-left: 20px; margin-bottom: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ══ BAGIAN 1: DATA DIRI SANTRI ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-green"><i class="fas fa-file-lines"></i></div>
            <div class="section-title">Data Diri Santri</div>
        </div>
        <div class="section-body">
            <div class="form-grid">

                {{-- Nama Lengkap --}}
                <div class="form-group form-full">
                    <label class="form-label">Nama Lengkap Sesuai Dokumen <span class="req">*</span></label>
                    <input type="text" name="nama_lengkap"
                           class="form-input @error('nama_lengkap') is-invalid @enderror"
                           value="{{ old('nama_lengkap', $ds->nama_lengkap ?? '') }}" required>
                    @error('nama_lengkap')
                        <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- NIK --}}
                <div class="form-group">
                    <label class="form-label">NIK <span class="req">*</span></label>
                    <input type="text" name="nik" class="form-input" placeholder="16 digit NIK"
                           value="{{ old('nik', $ds->nik ?? '') }}">
                </div>

                {{-- No KK --}}
                <div class="form-group">
                    <label class="form-label">No. Kartu Keluarga (KK) <span class="req">*</span></label>
                    <input type="text" name="no_kk" class="form-input" placeholder="16 digit KK"
                           value="{{ old('no_kk', $ds->no_kk ?? '') }}">
                </div>

                {{-- Kewarganegaraan --}}
                <div class="form-group">
                    <label class="form-label">Kewarganegaraan <span class="req">*</span></label>
                    <input type="text" name="kewarganegaraan" class="form-input"
                           value="{{ old('kewarganegaraan', $ds->kewarganegaraan ?? 'WNI') }}">
                </div>

                {{-- Nama Kepala Keluarga --}}
                <div class="form-group">
                    <label class="form-label">Nama Kepala Keluarga (KK) <span class="req">*</span></label>
                    <input type="text" name="nama_kapala_keluarga" class="form-input"
                           value="{{ old('nama_kapala_keluarga', $ds->nama_kapala_keluarga ?? '') }}">
                </div>

                {{-- Tempat Lahir --}}
                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-input"
                           value="{{ old('tempat_lahir', $ds->tempat_lahir ?? '') }}">
                </div>

                {{-- Tanggal Lahir --}}
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-input"
                           value="{{ old('tanggal_lahir', $ds->tanggal_lahir ?? '') }}">
                </div>

                {{-- Jenis Kelamin --}}
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $ds->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $ds->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Agama --}}
                <div class="form-group">
                    <label class="form-label">Agama <span class="req">*</span></label>
                    <input type="text" name="agama" class="form-input"
                           value="{{ old('agama', $ds->agama ?? 'Islam') }}">
                </div>

                {{-- Susunan Keluarga --}}
                <div class="form-group">
                    <label class="form-label">Anak Ke- <span class="req">*</span></label>
                    <input type="number" name="anak_ke" class="form-input" min="1"
                           value="{{ old('anak_ke', $ds->anak_ke ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Saudara <span class="req">*</span></label>
                    <input type="number" name="jumlah_saudara" class="form-input" min="1"
                           value="{{ old('jumlah_saudara', $ds->jumlah_saudara ?? '') }}">
                </div>

                {{-- No HP --}}
                <div class="form-group">
                    <label class="form-label">No. HP Santri <span class="req">*</span></label>
                    <input type="text" name="no_hp"
                           class="form-input @error('no_hp') is-invalid @enderror"
                           placeholder="08xxxxxxxxxx"
                           value="{{ old('no_hp', $ds->no_hp ?? '') }}">
                    @error('no_hp')
                        <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email Santri <span class="opt">(opsional)</span></label>
                    <input type="email" name="email"
                           class="form-input @error('email') is-invalid @enderror"
                           placeholder="email@contoh.com"
                           value="{{ old('email', $ds->email ?? '') }}">
                    @error('email')
                        <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Cita-cita --}}
                <div class="form-group">
                    <label class="form-label">Cita-cita <span class="opt">(opsional)</span></label>
                    <input type="text" name="cita_cita" class="form-input"
                           value="{{ old('cita_cita', $ds->cita_cita ?? '') }}">
                </div>

                {{-- Hobi --}}
                <div class="form-group">
                    <label class="form-label">Hobi <span class="opt">(opsional)</span></label>
                    <input type="text" name="hobi" class="form-input"
                           value="{{ old('hobi', $ds->hobi ?? '') }}">
                </div>

                {{-- Pembiaya Sekolah --}}
                <div class="form-group">
                    <label class="form-label">Pembiaya Sekolah <span class="req">*</span></label>
                    <select name="pembiaya_sekolah" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Orang Tua','Wali/Orang Tua Asuh','Tanggungan Sendiri','Lainnya'] as $pb)
                            <option value="{{ $pb }}" {{ old('pembiaya_sekolah', $ds->pembiaya_sekolah ?? '') == $pb ? 'selected' : '' }}>{{ $pb }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Masuk & Keluar --}}
                <div class="form-group">
                    <label class="form-label">Tahun Masuk <span class="req">*</span></label>
                    <input type="number" name="tahun_masuk" class="form-input" min="2000"
                           value="{{ old('tahun_masuk', $ds->tahun_masuk ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Keluar <span class="opt">(opsional)</span></label>
                    <input type="number" name="tahun_keluar" class="form-input" min="2000"
                           value="{{ old('tahun_keluar', $ds->tahun_keluar ?? '') }}">
                </div>

                {{-- Kebutuhan Khusus --}}
                <div class="form-group form-full">
                    <label class="form-label">Kebutuhan Medis Khusus <span class="opt">(opsional)</span></label>
                    <textarea name="kebutuhan_khusus" class="form-textarea" placeholder="Contoh: alergi makanan tertentu, dll.">{{ old('kebutuhan_khusus', $ds->kebutuhan_khusus ?? '') }}</textarea>
                </div>

                {{-- Kebutuhan Disabilitas --}}
                <div class="form-group form-full">
                    <label class="form-label">Kebutuhan Disabilitas <span class="opt">(opsional)</span></label>
                    <textarea name="kebutuhan_disabilitas" class="form-textarea" placeholder="Kosongkan jika tidak ada">{{ old('kebutuhan_disabilitas', $ds->kebutuhan_disabilitas ?? '') }}</textarea>
                </div>

            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 2: UPLOAD FOTO ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-orange"><i class="fas fa-images"></i></div>
            <div class="section-title">Foto Santri & Kartu Keluarga</div>
        </div>
        <div class="section-body">
            <div class="form-grid">

                {{-- Foto 3x4 —— PORTRAIT 3:4 --}}
                <div class="form-group">
                    <label class="form-label">Foto 3x4 Santri <span class="opt">(opsional - ganti jika perlu, maks 2MB)</span></label>
                    <span class="ratio-badge ratio-badge-portrait"><i class="fas fa-portrait"></i> Rasio 3 × 4 (Portrait)</span>
                    <div class="photo-upload-area" id="dropFoto">
                        <input type="file" name="foto_3x4" id="inputFoto" accept="image/*">
                        @if($ds?->foto_3x4 && file_exists(public_path('storage/berkas/'.$ds->foto_3x4)))
                            <img src="{{ asset('storage/berkas/'.$ds->foto_3x4) }}" class="photo-preview-portrait" id="previewFoto" alt="Foto Saat Ini">
                            <div class="photo-upload-label">Foto saat ini — klik untuk ganti</div>
                        @else
                            <div class="photo-upload-icon"><i class="fas fa-image"></i></div>
                            <div class="photo-upload-label">Klik untuk upload foto</div>
                            <img src="" class="photo-preview-portrait" id="previewFoto" alt="" style="display:none;">
                        @endif
                        <div class="photo-upload-sub">Format: JPG, JPEG, PNG &bull; Akan dipotong otomatis 3×4</div>
                    </div>
                    @error('foto_3x4')
                        <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto KK —— LANDSCAPE 16:9 --}}
                <div class="form-group">
                    <label class="form-label">Foto Kartu Keluarga <span class="opt">(opsional - ganti jika perlu, maks 2MB)</span></label>
                    <span class="ratio-badge ratio-badge-landscape"><i class="fas fa-id-card"></i> Rasio Landscape KK</span>
                    <div class="photo-upload-area" id="dropKK">
                        <input type="file" name="foto_kk" id="inputKK" accept="image/*">
                        @if($ds?->foto_kk && file_exists(public_path('storage/berkas/'.$ds->foto_kk)))
                            <img src="{{ asset('storage/berkas/'.$ds->foto_kk) }}" class="photo-preview-landscape" id="previewKK" alt="Foto KK Saat Ini">
                            <div class="photo-upload-label">Foto KK saat ini — klik untuk ganti</div>
                        @else
                            <div class="photo-upload-icon"><i class="fas fa-file-image"></i></div>
                            <div class="photo-upload-label">Klik untuk upload foto KK</div>
                            <img src="" class="photo-preview-landscape" id="previewKK" alt="" style="display:none;">
                        @endif
                        <div class="photo-upload-sub">Format: JPG, JPEG, PNG &bull; Akan dipotong otomatis landscape</div>
                    </div>
                    @error('foto_kk')
                        <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 3: DATA AYAH ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-blue"><i class="fas fa-user-tie"></i></div>
            <div class="section-title" style="color:#1d4ed8;">Data Ayah</div>
        </div>
        <div class="section-body">
            <div class="form-grid">

                {{-- Nama Ayah --}}
                <div class="form-group form-full">
                    <label class="form-label">Nama Lengkap Ayah <span class="req">*</span></label>
                    <input type="text" name="ayah_nama_lengkap" class="form-input"
                           value="{{ old('ayah_nama_lengkap', $da->nama_lengkap ?? '') }}">
                </div>

                {{-- Status Ayah --}}
                <div class="form-group">
                    <label class="form-label">Status Hidup / Hubungan <span class="req">*</span></label>
                    <select name="ayah_status" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ayah Kandung (Masih Hidup)','Ayah Kandung (Meninggal)','Ayah Tiri/Angkat'] as $sa)
                            <option value="{{ $sa }}" {{ old('ayah_status', $da->status ?? '') == $sa ? 'selected' : '' }}>{{ $sa }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NIK Ayah --}}
                <div class="form-group">
                    <label class="form-label">NIK Ayah <span class="req">*</span></label>
                    <input type="text" name="ayah_nik" class="form-input"
                           value="{{ old('ayah_nik', $da->nik ?? '') }}">
                </div>

                {{-- Kewarganegaraan Ayah --}}
                <div class="form-group">
                    <label class="form-label">Kewarganegaraan <span class="req">*</span></label>
                    <input type="text" name="ayah_kewarganegaraan" class="form-input"
                           value="{{ old('ayah_kewarganegaraan', $da->kewarganegaraan ?? 'WNI') }}">
                </div>

                {{-- No HP Ayah --}}
                <div class="form-group">
                    <label class="form-label">No. HP Ayah <span class="req">*</span></label>
                    <input type="text" name="ayah_no_hp"
                           class="form-input @error('ayah_no_hp') is-invalid @enderror"
                           placeholder="08xxxxxxxxxx"
                           value="{{ old('ayah_no_hp', $da->no_hp ?? '') }}">
                </div>

                {{-- Tempat Lahir Ayah --}}
                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="ayah_tempat_lahir" class="form-input"
                           value="{{ old('ayah_tempat_lahir', $da->tempat_lahir ?? '') }}">
                </div>

                {{-- Tanggal Lahir Ayah --}}
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="ayah_tanggal_lahir" class="form-input"
                           value="{{ old('ayah_tanggal_lahir', $da->tanggal_lahir ?? '') }}">
                </div>

                {{-- Pendidikan Terakhir Ayah --}}
                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir <span class="req">*</span></label>
                    <select name="ayah_pendidikan_terakhir" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Bersekolah', 'Lainnya'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ old('ayah_pendidikan_terakhir', $da->pendidikan_terakhir ?? '') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pekerjaan Ayah --}}
                <div class="form-group">
                    <label class="form-label">Pekerjaan Utama <span class="req">*</span></label>
                    <select name="ayah_pekerjaan_utama" class="form-select">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach([
                            'Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pengacara/Jaksa/Hakim/Notaris','Seniman/Pelukis/Artis/Sejenis','Dokter/Bidan/Perawat','Pilot/Pramugara','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Politikus','Lainnya'
                        ] as $pekerjaan)
                            <option value="{{ $pekerjaan }}" {{ old('ayah_pekerjaan_utama', $da->pekerjaan_utama ?? '') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Penghasilan Ayah --}}
                <div class="form-group">
                    <label class="form-label">Penghasilan Ayah / Bulan <span class="req">*</span></label>
                    <select name="ayah_penghasilan_perbulan" class="form-select">
                        <option value="">-- Pilih Penghasilan --</option>
                        @foreach([
                            'dibawah 800.000',
                            '800.001 - 1.200.000',
                            '1.200.001 - 1.800.000',
                            '1.800.001 - 2.500.000',
                            '2.500.001 - 3.500.000',
                            '3.500.001 - 4.800.000',
                            '4.800.001 - 6.500.000',
                            '6.500.001 - 10.000.000',
                            '10.000.001 - 20.000.000',
                            'diatas 20.000.001'
                        ] as $penghasilan)
                            <option value="{{ $penghasilan }}" {{ old('ayah_penghasilan_perbulan', $da->penghasilan_perbulan ?? '') == $penghasilan ? 'selected' : '' }}>
                                {{ $penghasilan }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 4: DATA IBU ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-red"><i class="fas fa-person-dress"></i></div>
            <div class="section-title" style="color:#991b1b;">Data Ibu</div>
        </div>
        <div class="section-body">
            <div class="form-grid">

                {{-- Nama Ibu --}}
                <div class="form-group form-full">
                    <label class="form-label">Nama Lengkap Ibu <span class="req">*</span></label>
                    <input type="text" name="ibu_nama_lengkap" class="form-input"
                           value="{{ old('ibu_nama_lengkap', $di->nama_lengkap ?? '') }}">
                </div>

                {{-- Status Ibu --}}
                <div class="form-group">
                    <label class="form-label">Status Hidup / Hubungan <span class="req">*</span></label>
                    <select name="ibu_status" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ibu Kandung (Masih Hidup)','Ibu Kandung (Meninggal)','Ibu Tiri/Angkat'] as $si)
                            <option value="{{ $si }}" {{ old('ibu_status', $di->status ?? '') == $si ? 'selected' : '' }}>{{ $si }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NIK Ibu --}}
                <div class="form-group">
                    <label class="form-label">NIK Ibu <span class="req">*</span></label>
                    <input type="text" name="ibu_nik" class="form-input"
                           value="{{ old('ibu_nik', $di->nik ?? '') }}">
                </div>

                {{-- Kewarganegaraan Ibu --}}
                <div class="form-group">
                    <label class="form-label">Kewarganegaraan <span class="req">*</span></label>
                    <input type="text" name="ibu_kewarganegaraan" class="form-input"
                           value="{{ old('ibu_kewarganegaraan', $di->kewarganegaraan ?? 'WNI') }}">
                </div>

                {{-- No HP Ibu --}}
                <div class="form-group">
                    <label class="form-label">No. HP Ibu <span class="req">*</span></label>
                    <input type="text" name="ibu_no_hp"
                           class="form-input @error('ibu_no_hp') is-invalid @enderror"
                           placeholder="08xxxxxxxxxx"
                           value="{{ old('ibu_no_hp', $di->no_hp ?? '') }}">
                </div>

                {{-- Tempat Lahir Ibu --}}
                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="ibu_tempat_lahir" class="form-input"
                           value="{{ old('ibu_tempat_lahir', $di->tempat_lahir ?? '') }}">
                </div>

                {{-- Tanggal Lahir Ibu --}}
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="ibu_tanggal_lahir" class="form-input"
                           value="{{ old('ibu_tanggal_lahir', $di->tanggal_lahir ?? '') }}">
                </div>

                {{-- Pendidikan Terakhir Ibu --}}
                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir <span class="req">*</span></label>
                    <select name="ibu_pendidikan_terakhir" class="form-select">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Bersekolah', 'Lainnya'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ old('ibu_pendidikan_terakhir', $di->pendidikan_terakhir ?? '') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pekerjaan Ibu --}}
                <div class="form-group">
                    <label class="form-label">Pekerjaan Utama <span class="req">*</span></label>
                    <select name="ibu_pekerjaan_utama" class="form-select">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach([
                            'Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pengacara/Jaksa/Hakim/Notaris','Seniman/Pelukis/Artis/Sejenis','Dokter/Bidan/Perawat','Pilot/Pramugara','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Politikus','Ibu Rumah Tangga','Lainnya'
                        ] as $pekerjaan)
                            <option value="{{ $pekerjaan }}" {{ old('ibu_pekerjaan_utama', $di->pekerjaan_utama ?? '') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Penghasilan Ibu --}}
                <div class="form-group">
                    <label class="form-label">Penghasilan Ibu / Bulan <span class="req">*</span></label>
                    <select name="ibu_penghasilan_perbulan" class="form-select">
                        <option value="">-- Pilih Penghasilan --</option>
                        @foreach([
                            'dibawah 800.000',
                            '800.001 - 1.200.000',
                            '1.200.001 - 1.800.000',
                            '1.800.001 - 2.500.000',
                            '2.500.001 - 3.500.000',
                            '3.500.001 - 4.800.000',
                            '4.800.001 - 6.500.000',
                            '6.500.001 - 10.000.000',
                            '10.000.001 - 20.000.000',
                            'diatas 20.000.001'
                        ] as $penghasilan)
                            <option value="{{ $penghasilan }}" {{ old('ibu_penghasilan_perbulan', $di->penghasilan_perbulan ?? '') == $penghasilan ? 'selected' : '' }}>
                                {{ $penghasilan }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 4b: DATA WALI ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-user-shield"></i></div>
            <div class="section-title" style="color:#d97706;">Data Wali</div>            
        </div>

        {{-- Banner Sinkronisasi --}}
        <div style="display:flex;align-items:center;gap:14px;padding:10px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;flex-wrap:wrap;">
            <span style="font-size:.78rem;font-weight:700;color:#475569;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-copy" style="color:#d97706;"></i> Salin Data Dari:
            </span>
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:.8rem;font-weight:600;color:#1d4ed8;">
                <input type="checkbox" id="cb_wali_sama_ayah" class="cb-wali-sync-edit" value="ayah"
                       style="width:15px;height:15px;accent-color:#1d4ed8;cursor:pointer;">
                <i class="fas fa-user-tie"></i> Sama dengan Ayah
            </label>
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:.8rem;font-weight:600;color:#be185d;">
                <input type="checkbox" id="cb_wali_sama_ibu" class="cb-wali-sync-edit" value="ibu"
                       style="width:15px;height:15px;accent-color:#be185d;cursor:pointer;">
                <i class="fas fa-person-dress"></i> Sama dengan Ibu
            </label>
            <span id="wali-sync-badge" style="display:none;background:#fef3c7;color:#92400e;border:1px solid #fcd34d;border-radius:20px;font-size:.72rem;font-weight:700;padding:3px 12px;">
                <i class="fas fa-lock"></i> Data tersinkronisasi — hapus centang untuk edit manual
            </span>
        </div>

        <div class="section-body">
            <div class="form-grid">

                <div class="form-group form-full">
                    <label class="form-label">Nama Lengkap Wali <span class="req">*</span></label>
                    <input type="text" name="wali_nama_lengkap" id="wali_nama_lengkap" class="form-input"
                           value="{{ old('wali_nama_lengkap', $dw->nama_lengkap ?? '') }}" placeholder="Contoh: Ahmad Fauzi">
                </div>

                <div class="form-group">                    
                    <label class="form-label">Hubungan dengan Santri <span class="req">*</span></label>
                    <select name="wali_status" id="wali_status" class="form-select">
                        @foreach(['Ayah/Ibu','Paman/Bibi','Kakek/Nenek','Kakak Kandung','Saudara','Pesantren/Lembaga','Lainnya'] as $sw)
                            <option value="{{ $sw }}" {{ old('wali_status', $dw->status ?? '') == $sw ? 'selected' : '' }}>{{ $sw }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">No. HP Wali <span class="req">*</span></label>
                    <input type="text" name="wali_no_hp" id="wali_no_hp" class="form-input" placeholder="08xxxxxxxxxx"
                           value="{{ old('wali_no_hp', $dw->no_hp ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">NIK Wali <span class="req">*</span></label>
                    <input type="text" name="wali_nik" id="wali_nik" class="form-input" placeholder="16 digit NIK"
                           value="{{ old('wali_nik', $dw->nik ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Kewarganegaraan <span class="req">*</span></label>
                    <input type="text" name="wali_kewarganegaraan" id="wali_kewarganegaraan" class="form-input"
                           value="{{ old('wali_kewarganegaraan', $dw->kewarganegaraan ?? 'WNI') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="wali_tempat_lahir" id="wali_tempat_lahir" class="form-input"
                           value="{{ old('wali_tempat_lahir', $dw->tempat_lahir ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="wali_tanggal_lahir" id="wali_tanggal_lahir" class="form-input"
                           value="{{ old('wali_tanggal_lahir', $dw->tanggal_lahir ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir <span class="req">*</span></label>
                    <select name="wali_pendidikan_terakhir" id="wali_pendidikan_terakhir" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1','D2','D3','D4/S1','S2','S3','Tidak Bersekolah','Lainnya'] as $p)
                            <option value="{{ $p }}" {{ old('wali_pendidikan_terakhir', $dw->pendidikan_terakhir ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Pekerjaan Utama <span class="req">*</span></label>
                    <select name="wali_pekerjaan_utama" id="wali_pekerjaan_utama" class="form-select">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Lainnya'] as $pek)
                            <option value="{{ $pek }}" {{ old('wali_pekerjaan_utama', $dw->pekerjaan_utama ?? '') == $pek ? 'selected' : '' }}>{{ $pek }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Penghasilan per Bulan <span class="req">*</span></label>
                    <select name="wali_penghasilan_perbulan" id="wali_penghasilan_perbulan" class="form-select">
                        <option value="">-- Pilih Penghasilan --</option>
                        @foreach(['dibawah 800.000','800.001 - 1.200.000','1.200.001 - 1.800.000','1.800.001 - 2.500.000','2.500.001 - 3.500.000','3.500.001 - 4.800.000','4.800.001 - 6.500.000','6.500.001 - 10.000.000','10.000.001 - 20.000.000','diatas 20.000.001'] as $ph)
                            <option value="{{ $ph }}" {{ old('wali_penghasilan_perbulan', $dw->penghasilan_perbulan ?? '') == $ph ? 'selected' : '' }}>{{ $ph }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 5: ALAMAT AYAH ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-blue"><i class="fas fa-home"></i></div>
            <div class="section-title" style="color:#1d4ed8;">Alamat Ayah</div>
        </div>
        <div class="section-body">
            <div class="form-grid">
                <div class="form-group form-full">
                    <label class="form-label">Alamat / Nama Jalan <span class="req">*</span></label>
                    <textarea name="alamat_ayah" class="form-textarea" placeholder="Nama jalan, nomor rumah, dll.">{{ old('alamat_ayah', $aa->alamat ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">RT <span class="req">*</span></label>
                    <input type="text" name="rt_ayah" class="form-input" placeholder="001" value="{{ old('rt_ayah', $aa->rt ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">RW <span class="req">*</span></label>
                    <input type="text" name="rw_ayah" class="form-input" placeholder="001" value="{{ old('rw_ayah', $aa->rw ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Provinsi <span class="req">*</span></label>
                    <select name="provinsi_ayah" id="provinsi_ayah" class="form-select" data-old="{{ old('provinsi_ayah', $aa->provinsi ?? '') }}">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kabupaten / Kota <span class="req">*</span></label>
                    <select name="kabupaten_ayah" id="kabupaten_ayah" class="form-select" data-old="{{ old('kabupaten_ayah', $aa->kabupaten ?? '') }}">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan <span class="req">*</span></label>
                    <select name="kecamatan_ayah" id="kecamatan_ayah" class="form-select" data-old="{{ old('kecamatan_ayah', $aa->kecamatan ?? '') }}">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Desa / Kelurahan <span class="req">*</span></label>
                    <select name="desa_ayah" id="desa_ayah" class="form-select" data-old="{{ old('desa_ayah', $aa->desa ?? '') }}">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="req">*</span></label>
                    <input type="text" name="kode_pos_ayah" class="form-input" placeholder="12345" value="{{ old('kode_pos_ayah', $aa->kode_pos ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Kepemilikan Rumah <span class="req">*</span></label>
                    <select name="status_kepemilikan_ayah" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)
                            <option value="{{ $sk }}" {{ old('status_kepemilikan_ayah', $aa->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 6: ALAMAT IBU ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-red"><i class="fas fa-home"></i></div>
            <div class="section-title" style="color:#991b1b;">Alamat Ibu</div>
        </div>

        {{-- Banner Sinkronisasi Alamat Ibu --}}
        <div style="display:flex;align-items:center;gap:14px;padding:10px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;flex-wrap:wrap;">
            <span style="font-size:.78rem;font-weight:700;color:#475569;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-copy" style="color:#1d4ed8;"></i> Salin Data Dari:
            </span>
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:.8rem;font-weight:600;color:#1d4ed8;">
                <input type="checkbox" id="cb_alamat_ibu_sama_ayah" class="cb-alamat-ibu-sync-edit" value="ayah"
                       style="width:15px;height:15px;accent-color:#1d4ed8;cursor:pointer;">
                <i class="fas fa-home"></i> Sama dengan Alamat Ayah
            </label>
            <span id="alamat-ibu-sync-badge" style="display:none;background:#fef3c7;color:#92400e;border:1px solid #fcd34d;border-radius:20px;font-size:.72rem;font-weight:700;padding:3px 12px;">
                <i class="fas fa-lock"></i> Data tersinkronisasi
            </span>
        </div>

        <div class="section-body">
            <div class="form-grid">
                <div class="form-group form-full">
                    <label class="form-label">Alamat / Nama Jalan <span class="req">*</span></label>
                    <textarea name="alamat_ibu" class="form-textarea" placeholder="Nama jalan, nomor rumah, dll.">{{ old('alamat_ibu', $ai->alamat ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">RT <span class="req">*</span></label>
                    <input type="text" name="rt_ibu" class="form-input" placeholder="001" value="{{ old('rt_ibu', $ai->rt ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">RW <span class="req">*</span></label>
                    <input type="text" name="rw_ibu" class="form-input" placeholder="001" value="{{ old('rw_ibu', $ai->rw ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Provinsi <span class="req">*</span></label>
                    <select name="provinsi_ibu" id="provinsi_ibu" class="form-select" data-old="{{ old('provinsi_ibu', $ai->provinsi ?? '') }}">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kabupaten / Kota <span class="req">*</span></label>
                    <select name="kabupaten_ibu" id="kabupaten_ibu" class="form-select" data-old="{{ old('kabupaten_ibu', $ai->kabupaten ?? '') }}">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan <span class="req">*</span></label>
                    <select name="kecamatan_ibu" id="kecamatan_ibu" class="form-select" data-old="{{ old('kecamatan_ibu', $ai->kecamatan ?? '') }}">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Desa / Kelurahan <span class="req">*</span></label>
                    <select name="desa_ibu" id="desa_ibu" class="form-select" data-old="{{ old('desa_ibu', $ai->desa ?? '') }}">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="req">*</span></label>
                    <input type="text" name="kode_pos_ibu" class="form-input" placeholder="12345" value="{{ old('kode_pos_ibu', $ai->kode_pos ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Kepemilikan Rumah <span class="req">*</span></label>
                    <select name="status_kepemilikan_ibu" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)
                            <option value="{{ $sk }}" {{ old('status_kepemilikan_ibu', $ai->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 6b: ALAMAT WALI ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-home"></i></div>
            <div class="section-title" style="color:#d97706;">Alamat Wali</div>
        </div>

        {{-- Banner Sinkronisasi Alamat Wali --}}
        <div style="display:flex;align-items:center;gap:14px;padding:10px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;flex-wrap:wrap;">
            <span style="font-size:.78rem;font-weight:700;color:#475569;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-copy" style="color:#d97706;"></i> Salin Data Dari:
            </span>
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:.8rem;font-weight:600;color:#1d4ed8;">
                <input type="checkbox" id="cb_alamat_wali_sama_ayah" class="cb-alamat-wali-sync-edit" value="ayah"
                       style="width:15px;height:15px;accent-color:#1d4ed8;cursor:pointer;">
                <i class="fas fa-home"></i> Sama dengan Ayah
            </label>
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:.8rem;font-weight:600;color:#be185d;">
                <input type="checkbox" id="cb_alamat_wali_sama_ibu" class="cb-alamat-wali-sync-edit" value="ibu"
                       style="width:15px;height:15px;accent-color:#be185d;cursor:pointer;">
                <i class="fas fa-home"></i> Sama dengan Ibu
            </label>
            <span id="alamat-wali-sync-badge" style="display:none;background:#fef3c7;color:#92400e;border:1px solid #fcd34d;border-radius:20px;font-size:.72rem;font-weight:700;padding:3px 12px;">
                <i class="fas fa-lock"></i> Data tersinkronisasi
            </span>
        </div>

        <div class="section-body">
            <div class="form-grid">
                <div class="form-group form-full">
                    <label class="form-label">Alamat / Nama Jalan <span class="req">*</span></label>
                    <textarea name="alamat_wali" class="form-textarea" placeholder="Nama jalan, nomor rumah, dll.">{{ old('alamat_wali', $aw->alamat ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">RT <span class="req">*</span></label>
                    <input type="text" name="rt_wali" class="form-input" placeholder="001" value="{{ old('rt_wali', $aw->rt ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">RW <span class="req">*</span></label>
                    <input type="text" name="rw_wali" class="form-input" placeholder="001" value="{{ old('rw_wali', $aw->rw ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Provinsi <span class="req">*</span></label>
                    <select name="provinsi_wali" id="provinsi_wali" class="form-select" data-old="{{ old('provinsi_wali', $aw->provinsi ?? '') }}">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kabupaten / Kota <span class="req">*</span></label>
                    <select name="kabupaten_wali" id="kabupaten_wali" class="form-select" data-old="{{ old('kabupaten_wali', $aw->kabupaten ?? '') }}">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kecamatan <span class="req">*</span></label>
                    <select name="kecamatan_wali" id="kecamatan_wali" class="form-select" data-old="{{ old('kecamatan_wali', $aw->kecamatan ?? '') }}">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Desa / Kelurahan <span class="req">*</span></label>
                    <select name="desa_wali" id="desa_wali" class="form-select" data-old="{{ old('desa_wali', $aw->desa ?? '') }}">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="req">*</span></label>
                    <input type="text" name="kode_pos_wali" class="form-input" placeholder="12345" value="{{ old('kode_pos_wali', $aw->kode_pos ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Kepemilikan Rumah <span class="req">*</span></label>
                    <select name="status_kepemilikan_wali" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)
                            <option value="{{ $sk }}" {{ old('status_kepemilikan_wali', $aw->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ BAGIAN 7: ALAMAT SANTRI & TRANSPORTASI ══ --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-icon icon-green"><i class="fas fa-map-location-dot"></i></div>
            <div class="section-title">Alamat Santri & Transportasi</div>
            <span style="margin-left: auto; font-size: .75rem; color: #ef4444; background: #fee2e2; padding: 4px 10px; border-radius: 6px; font-weight: 600;">
                <i class="fas fa-lock" style="margin-right:4px;"></i>Hanya Lihat
            </span>
        </div>
        <div class="section-body">
            <fieldset disabled="disabled" style="border: none; padding: 0; margin: 0; opacity: 0.85;">
                <div class="form-grid">

                {{-- Alamat Jalan (full width) --}}
                <div class="form-group form-full">
                    <label class="form-label">Alamat / Nama Jalan <span class="opt">(diisi admin)</span></label>
                    <textarea name="alamat" class="form-textarea" placeholder="Nama jalan, nomor rumah, dll.">{{ old('alamat', $as->alamat ?? '') }}</textarea>
                </div>

                {{-- RT --}}
                <div class="form-group">
                    <label class="form-label">RT <span class="opt">(diisi admin)</span></label>
                    <input type="text" name="rt" class="form-input" placeholder="001"
                           value="{{ old('rt', $as->rt ?? '') }}">
                </div>

                {{-- RW --}}
                <div class="form-group">
                    <label class="form-label">RW <span class="opt">(diisi admin)</span></label>
                    <input type="text" name="rw" class="form-input" placeholder="001"
                           value="{{ old('rw', $as->rw ?? '') }}">
                </div>

                {{-- Provinsi --}}
                <div class="form-group">
                    <label class="form-label">Provinsi <span class="opt">(diisi admin)</span></label>
                    <select name="provinsi" id="provinsi" class="form-select" data-old="{{ old('provinsi', $as->provinsi ?? '') }}">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>

                {{-- Kabupaten --}}
                <div class="form-group">
                    <label class="form-label">Kabupaten / Kota <span class="opt">(diisi admin)</span></label>
                    <select name="kabupaten" id="kabupaten" class="form-select" data-old="{{ old('kabupaten', $as->kabupaten ?? '') }}">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                </div>

                {{-- Kecamatan --}}
                <div class="form-group">
                    <label class="form-label">Kecamatan <span class="opt">(diisi admin)</span></label>
                    <select name="kecamatan" id="kecamatan" class="form-select" data-old="{{ old('kecamatan', $as->kecamatan ?? '') }}">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>

                {{-- Desa --}}
                <div class="form-group">
                    <label class="form-label">Desa / Kelurahan <span class="opt">(diisi admin)</span></label>
                    <select name="desa" id="desa" class="form-select" data-old="{{ old('desa', $as->desa ?? '') }}">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                </div>

                {{-- Kode Pos --}}
                <div class="form-group">
                    <label class="form-label">Kode Pos <span class="opt">(diisi admin)</span></label>
                    <input type="text" name="kode_pos" class="form-input" placeholder="12345"
                           value="{{ old('kode_pos', $as->kode_pos ?? '') }}">
                </div>

                {{-- Koordinat --}}
                <div class="form-group">
                    <label class="form-label">Koordinat <span class="opt">(opsional)</span></label>
                    <input type="text" name="koordinat" class="form-input" placeholder="-7.123, 110.45"
                           value="{{ old('koordinat', $as->koordinat ?? '') }}">
                </div>

                {{-- Status Mukim --}}
                <div class="form-group">
                    <label class="form-label">Status Mukim <span class="opt">(diisi admin)</span></label>
                    <select name="status_mukim" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Mukim" {{ old('status_mukim', $as->status_mukim ?? '') == 'Mukim' ? 'selected' : '' }}>Mukim</option>
                        <option value="Tidak Mukim" {{ old('status_mukim', $as->status_mukim ?? '') == 'Tidak Mukim' ? 'selected' : '' }}>Pulang Pergi (Tidak Mukim)</option>
                    </select>
                </div>

                {{-- Status Tempat Tinggal --}}
                <div class="form-group">
                    <label class="form-label">Tinggal Bersama <span class="opt">(diisi admin)</span></label>
                    <select name="status_tempat_tinggal" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Orang Tua','Wali / Keluarga','Asrama Pesantren','Kost / Kontrakan'] as $st)
                            <option value="{{ $st }}" {{ old('status_tempat_tinggal', $as->status_tempat_tinggal ?? '') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Transportasi --}}
                <div class="form-group">
                    <label class="form-label">Moda Transportasi <span class="opt">(diisi admin)</span></label>
                    <select name="transportasi" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Jalan Kaki','Sepeda','Sepeda Motor','Mobil Pribadi','Angkutan Umum'] as $tr)
                            <option value="{{ $tr }}" {{ old('transportasi', $as->transportasi ?? '') == $tr ? 'selected' : '' }}>{{ $tr }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jarak --}}
                <div class="form-group">
                    <label class="form-label">Jarak ke Pesantren (Km) <span class="opt">(diisi admin)</span></label>
                    <input type="number" name="jarak_ke_lembaga" class="form-input"
                           placeholder="Contoh: 15" step="0.1" min="0"
                           value="{{ old('jarak_ke_lembaga', $as->jarak_ke_lembaga ?? '') }}">
                </div>

                {{-- Waktu Tempuh --}}
                <div class="form-group">
                    <label class="form-label">Waktu Tempuh (Menit) <span class="opt">(diisi admin)</span></label>
                    <input type="number" name="waktu_tempuh" class="form-input"
                           placeholder="Contoh: 30" min="0"
                           value="{{ old('waktu_tempuh', $as->waktu_tempuh ?? '') }}">
                </div>

            </div>
            </fieldset>
        </div>
    </div>

    {{-- ══ ACTION BUTTONS ══ --}}
    <div class="section-card">
        <div class="section-body">
            <div class="form-actions">
                <a href="{{ route('wali.santri.show', $santri->id) }}" class="btn-cancel">
                    <i class="fas fa-xmark"></i> Batal
                </a>
                <button type="submit" class="btn-save" id="saveBtn">
                    <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
    // Preview foto sebelum upload
    function setupPreview(inputId, previewId, headerAvatarId = null) {
        const input   = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const headerAvatar = headerAvatarId ? document.getElementById(headerAvatarId) : null;
        input?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
                    if (headerAvatar) {
                        if (headerAvatar.tagName.toLowerCase() === 'img') {
                            headerAvatar.src = e.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.id = headerAvatarId;
                            img.alt = 'Foto';
                            headerAvatar.parentNode.replaceChild(img, headerAvatar);
                        }
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    setupPreview('inputFoto', 'previewFoto', 'headerAvatar');
    setupPreview('inputKK',   'previewKK');

    // Disable tombol saat submit agar tidak double-click
    document.getElementById('editForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    });

    // ── EMSIFA API Wilayah ──────────────────────────────────────────────────
    const apiWilayah = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    function loadSelectOptions(url, selectElement, defaultText, oldVal) {
        return fetch(url)
            .then(r => r.json())
            .then(data => {
                let opts = `<option value="">-- ${defaultText} --</option>`;
                data.forEach(d => {
                    let selected = (oldVal && oldVal === d.name) ? 'selected' : '';
                    opts += `<option value="${d.name}" data-id="${d.id}" ${selected}>${d.name}</option>`;
                });
                selectElement.innerHTML = opts;
                if (oldVal) selectElement.dispatchEvent(new Event('change'));
            }).catch(e => console.error(e));
    }

    function initWilayah(provId, kabId, kecId, desaId) {
        const provSelect = document.getElementById(provId);
        const kabSelect  = document.getElementById(kabId);
        const kecSelect  = document.getElementById(kecId);
        const desaSelect = document.getElementById(desaId);
        if (!provSelect) return;

        let oldProv = provSelect.dataset.old;
        let oldKab  = kabSelect.dataset.old;
        let oldKec  = kecSelect.dataset.old;
        let oldDesa = desaSelect.dataset.old;

        loadSelectOptions(`${apiWilayah}/provinces.json`, provSelect, 'Pilih Provinsi', oldProv);

        provSelect.addEventListener('change', function() {
            kabSelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            let opt = this.options[this.selectedIndex];
            let id = opt ? opt.getAttribute('data-id') : null;
            if (id) loadSelectOptions(`${apiWilayah}/regencies/${id}.json`, kabSelect, 'Pilih Kabupaten', oldKab);
            oldKab = null;
        });

        kabSelect.addEventListener('change', function() {
            kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            let opt = this.options[this.selectedIndex];
            let id = opt ? opt.getAttribute('data-id') : null;
            if (id) loadSelectOptions(`${apiWilayah}/districts/${id}.json`, kecSelect, 'Pilih Kecamatan', oldKec);
            oldKec = null;
        });

        kecSelect.addEventListener('change', function() {
            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            let opt = this.options[this.selectedIndex];
            let id = opt ? opt.getAttribute('data-id') : null;
            if (id) loadSelectOptions(`${apiWilayah}/villages/${id}.json`, desaSelect, 'Pilih Desa', oldDesa);
            oldDesa = null;
        });
    }

    initWilayah('provinsi_ayah', 'kabupaten_ayah', 'kecamatan_ayah', 'desa_ayah');
    initWilayah('provinsi_ibu', 'kabupaten_ibu', 'kecamatan_ibu', 'desa_ibu');
    initWilayah('provinsi_wali', 'kabupaten_wali', 'kecamatan_wali', 'desa_wali');
    initWilayah('provinsi', 'kabupaten', 'kecamatan', 'desa');

    /* ── Daftarkan Crop Input ── */
    window.addEventListener('load', function () {
        if (typeof registerCropInput === 'function') {
            registerCropInput('inputFoto', '#previewFoto', 'foto');
            registerCropInput('inputKK',   '#previewKK',  'kk');
        }
    });

    /* ── Sync Wali dari Ayah / Ibu ── */
    (function () {
        // Peta: [id field sumber ayah/ibu] => [id field tujuan wali]
        // Prefix sumber: ayah_ / ibu_   |   Prefix tujuan: wali_
        var waliFieldMap = [
            { src: 'nama_lengkap', dst: 'wali_nama_lengkap' },
            { src: 'no_hp',        dst: 'wali_no_hp' },
            { src: 'nik',          dst: 'wali_nik' },
            { src: 'kewarganegaraan', dst: 'wali_kewarganegaraan' },
            { src: 'tempat_lahir', dst: 'wali_tempat_lahir' },
            { src: 'tanggal_lahir', dst: 'wali_tanggal_lahir' },
            { src: 'pendidikan_terakhir', dst: 'wali_pendidikan_terakhir' },
            { src: 'pekerjaan_utama',    dst: 'wali_pekerjaan_utama' },
            { src: 'penghasilan_perbulan', dst: 'wali_penghasilan_perbulan' },
        ];

        function syncWaliEdit(srcPrefix, lock) {
            waliFieldMap.forEach(function (map) {
                var srcId = srcPrefix + '_' + map.src;   // cth: ayah_nama_lengkap
                var dstId = map.dst;                     // cth: wali_nama_lengkap
                var s = document.querySelector('[name="' + srcId + '"]');
                var d = document.getElementById(dstId);
                if (!s || !d) return;

                if (lock) {
                    // Salin nilai
                    if (d.tagName === 'SELECT' && s.tagName === 'SELECT') {
                        // Cukup set value yang sama (option sudah tersedia)
                        d.value = s.value;
                    } else {
                        d.value = s.value;
                    }
                    // Kunci input
                    d.readOnly   = true;
                    d.style.pointerEvents = 'none';
                    d.style.background    = '#f1f5f9';
                    d.style.cursor        = 'not-allowed';
                } else {
                    d.readOnly   = false;
                    d.style.pointerEvents = 'auto';
                    d.style.background    = '';
                    d.style.cursor        = '';
                }
            });

            // Badge notifikasi
            var badge = document.getElementById('wali-sync-badge');
            if (badge) badge.style.display = lock ? 'inline-flex' : 'none';
        }

        document.querySelectorAll('.cb-wali-sync-edit').forEach(function (cb) {
            cb.addEventListener('change', function () {
                if (this.checked) {
                    // Uncheck yang lain
                    document.querySelectorAll('.cb-wali-sync-edit').forEach(function (o) {
                        if (o !== cb) { o.checked = false; }
                    });
                    syncWaliEdit(cb.value, true);
                } else {
                    syncWaliEdit(cb.value, false);
                }
            });
        });

        // Live update saat field sumber berubah selagi tersinkronisasi
        ['ayah', 'ibu'].forEach(function (prefix) {
            waliFieldMap.forEach(function (map) {
                var srcEl = document.querySelector('[name="' + prefix + '_' + map.src + '"]');
                if (!srcEl) return;
                srcEl.addEventListener('input', function () {
                    var cb = document.getElementById('cb_wali_sama_' + prefix);
                    if (cb && cb.checked) syncWaliEdit(prefix, true);
                });
                srcEl.addEventListener('change', function () {
                    var cb = document.getElementById('cb_wali_sama_' + prefix);
                    if (cb && cb.checked) syncWaliEdit(prefix, true);
                });
            });
        });
    })();

    /* ── Sync Alamat Ibu & Wali ── */
    (function () {
        var alamatFields = ['alamat', 'rt', 'rw', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'kode_pos', 'status_kepemilikan'];
        
        function syncAlamatEdit(srcPrefix, dstPrefix, lock) {
            alamatFields.forEach(function (f) {
                var srcName = f + '_' + srcPrefix;
                var dstName = f + '_' + dstPrefix;
                
                var s = document.querySelector('[name="' + srcName + '"]');
                var d = document.querySelector('[name="' + dstName + '"]');
                
                if (!s || !d) return;

                if (lock) {
                    if (d.tagName === 'SELECT' && s.tagName === 'SELECT') {
                        // Salin opsi dropdown untuk provinsi, kabupaten, dsb agar validasinya cocok
                        if (['provinsi', 'kabupaten', 'kecamatan', 'desa'].includes(f)) {
                            d.innerHTML = s.innerHTML;
                        }
                        d.value = s.value;
                    } else {
                        d.value = s.value;
                    }
                    d.readOnly = true;
                    d.style.pointerEvents = 'none';
                    d.style.background = '#f1f5f9';
                    d.style.cursor = 'not-allowed';
                } else {
                    d.readOnly = false;
                    d.style.pointerEvents = 'auto';
                    d.style.background = '';
                    d.style.cursor = '';
                }
            });

            var badge = document.getElementById('alamat-' + dstPrefix + '-sync-badge');
            if (badge) badge.style.display = lock ? 'inline-flex' : 'none';
        }

        // Checkbox Alamat Ibu Sama dengan Ayah
        var cbIbu = document.getElementById('cb_alamat_ibu_sama_ayah');
        if (cbIbu) {
            cbIbu.addEventListener('change', function () {
                syncAlamatEdit('ayah', 'ibu', this.checked);
            });
        }
        
        // Checkbox Alamat Wali
        document.querySelectorAll('.cb-alamat-wali-sync-edit').forEach(function (cb) {
            cb.addEventListener('change', function () {
                if (this.checked) {
                    document.querySelectorAll('.cb-alamat-wali-sync-edit').forEach(function (o) {
                        if (o !== cb) o.checked = false;
                    });
                    syncAlamatEdit(this.value, 'wali', true);
                } else {
                    syncAlamatEdit(this.value, 'wali', false);
                }
            });
        });

        // Live update jika sumber diubah
        ['ayah', 'ibu'].forEach(function (prefix) {
            alamatFields.forEach(function (f) {
                var srcEl = document.querySelector('[name="' + f + '_' + prefix + '"]');
                if (!srcEl) return;
                
                var triggerSync = function() {
                    if (prefix === 'ayah') {
                        var cbIbu = document.getElementById('cb_alamat_ibu_sama_ayah');
                        if (cbIbu && cbIbu.checked) syncAlamatEdit('ayah', 'ibu', true);
                    }
                    var cbWali = document.getElementById('cb_alamat_wali_sama_' + prefix);
                    if (cbWali && cbWali.checked) syncAlamatEdit(prefix, 'wali', true);
                };

                srcEl.addEventListener('input', triggerSync);
                srcEl.addEventListener('change', triggerSync);
            });
        });
    })();


</script>
@endpush

{{-- Crop Modal Partial --}}
@include('partials._crop_modal')
