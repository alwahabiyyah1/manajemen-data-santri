@if(empty($draft))
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle mr-1"></i>
    Tidak ada data draft. Silakan kembali ke tab Identitas Santri dan klik <strong>Simpan & Lanjutkan</strong>.
</div>
@else

@php
    $pribadi = $draft['pribadi'] ?? [];
    $ayahD   = $draft['ayah']    ?? [];
    $ibuD    = $draft['ibu']     ?? [];
    $waliD   = $draft['wali']    ?? [];
    $alamat  = $draft['alamat']  ?? [];
    $foto    = $draft['foto']    ?? [];
    $utama   = $draft['utama']   ?? [];
    function previewVal($val, $default='-') { return !empty($val) ? $val : $default; }
@endphp

<div class="alert alert-info py-2 mb-3">
    <i class="fas fa-check-circle mr-1"></i>
    Periksa kembali semua data secara saksama. Jika sudah benar, klik <strong>Simpan ke Database</strong> di bagian bawah.
</div>

{{-- ─── IDENTITAS SANTRI ─────────────────────────────────────────────── --}}
<div class="card bg-light border-primary mb-3">
    <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
        <strong><i class="fas fa-id-card mr-1"></i> Identitas Santri</strong>
    </div>
    <div class="card-body py-3">
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Nama Lengkap:</strong> {{ previewVal($pribadi['nama_lengkap'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>NIK:</strong> {{ previewVal($pribadi['nik'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>No. KK:</strong> {{ previewVal($pribadi['no_kk'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Tempat Lahir:</strong> {{ previewVal($pribadi['tempat_lahir'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Tanggal Lahir:</strong> {{ previewVal($pribadi['tanggal_lahir'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Jenis Kelamin:</strong> {{ previewVal($pribadi['jenis_kelamin'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Agama:</strong> {{ previewVal($pribadi['agama'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>No. HP:</strong> {{ previewVal($pribadi['no_hp'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Email:</strong> {{ previewVal($pribadi['email'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Tahun Masuk:</strong> {{ previewVal($pribadi['tahun_masuk'] ?? '') }}</div>
            <div class="col-md-3 mb-2"><strong>Status Data:</strong> {{ previewVal($utama['status_data'] ?? '') }}</div>
        </div>
    </div>
</div>

{{-- ─── DATA ORANG TUA ────────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-6">
        <div class="card bg-light border-primary mb-3">
            <div class="card-header bg-primary text-white py-2">
                <strong><i class="fas fa-user-tie mr-1"></i> Data Ayah</strong>
            </div>
            <div class="card-body py-3">
                @if(!empty($ayahD['nama_lengkap_ayah']))
                <div class="mb-1"><strong>Nama:</strong> {{ $ayahD['nama_lengkap_ayah'] }}</div>
                <div class="mb-1"><strong>Status:</strong> {{ previewVal($ayahD['status_ayah'] ?? '') }}</div>
                <div class="mb-1"><strong>Lahir:</strong> {{ previewVal($ayahD['tempat_lahir_ayah'] ?? '') }}, {{ previewVal($ayahD['tanggal_lahir_ayah'] ?? '') }}</div>
                <div class="mb-1"><strong>No. HP:</strong> {{ previewVal($ayahD['no_hp_ayah'] ?? '') }}</div>
                <div class="mb-1"><strong>Pekerjaan:</strong> {{ previewVal($ayahD['pekerjaan_utama_ayah'] ?? '') }}</div>
                @else
                <p class="text-muted mb-0"><i class="fas fa-minus-circle mr-1"></i> Tidak diisi.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-light border-danger mb-3">
            <div class="card-header bg-danger text-white py-2">
                <strong><i class="fas fa-person-dress mr-1"></i> Data Ibu</strong>
            </div>
            <div class="card-body py-3">
                @if(!empty($ibuD['nama_lengkap_ibu']))
                <div class="mb-1"><strong>Nama:</strong> {{ $ibuD['nama_lengkap_ibu'] }}</div>
                <div class="mb-1"><strong>Status:</strong> {{ previewVal($ibuD['status_ibu'] ?? '') }}</div>
                <div class="mb-1"><strong>Lahir:</strong> {{ previewVal($ibuD['tempat_lahir_ibu'] ?? '') }}, {{ previewVal($ibuD['tanggal_lahir_ibu'] ?? '') }}</div>
                <div class="mb-1"><strong>No. HP:</strong> {{ previewVal($ibuD['no_hp_ibu'] ?? '') }}</div>
                <div class="mb-1"><strong>Pekerjaan:</strong> {{ previewVal($ibuD['pekerjaan_utama_ibu'] ?? '') }}</div>
                @else
                <p class="text-muted mb-0"><i class="fas fa-minus-circle mr-1"></i> Tidak diisi.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ─── DATA WALI & ALAMAT ────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-6">
        <div class="card bg-light border-secondary mb-3 height-100">
            <div class="card-header bg-secondary text-white py-2">
                <strong><i class="fas fa-user-shield mr-1"></i> Data Wali / Pengasuh</strong>
            </div>
            <div class="card-body py-3">
                @if(!empty($waliD['nama_lengkap_wali']))
                <div class="mb-1"><strong>Nama:</strong> {{ $waliD['nama_lengkap_wali'] }}</div>
                <div class="mb-1"><strong>Hubungan:</strong> {{ previewVal($waliD['status_wali'] ?? '') }}</div>
                <div class="mb-1"><strong>No. HP:</strong> {{ previewVal($waliD['no_hp_wali'] ?? '') }}</div>
                <div class="mb-1"><strong>Pekerjaan:</strong> {{ previewVal($waliD['pekerjaan_utama_wali'] ?? '') }}</div>
                <div class="mb-1"><strong>Alamat:</strong> {{ previewVal($waliD['alamat_wali'] ?? '') }}</div>
                @else
                <p class="text-muted mb-0"><i class="fas fa-minus-circle mr-1"></i> Tidak diisi.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-light border-success mb-3 height-100">
            <div class="card-header bg-success text-white py-2">
                <strong><i class="fas fa-map-location-dot mr-1"></i> Alamat &amp; Transport.</strong>
            </div>
            <div class="card-body py-3">
                <div class="mb-2">
                    <strong>Alamat ID:</strong><br>
                    {{ previewVal($alamat['alamat_santri'] ?? '') }} 
                    @if(!empty($alamat['desa_santri'])) , {{ $alamat['desa_santri'] }} @endif
                    @if(!empty($alamat['kecamatan_santri'])) , Kec. {{ $alamat['kecamatan_santri'] }} @endif
                </div>
                <div class="mb-1"><strong>Status Mukim:</strong> {{ previewVal($alamat['status_mukim'] ?? '') }}</div>
                <div class="mb-1"><strong>Transportasi:</strong> {{ previewVal($alamat['transportasi'] ?? '') }} ({{ previewVal($alamat['waktu_tempuh'] ?? '') }} mnt)</div>
            </div>
        </div>
    </div>
</div>

{{-- ─── BERKAS / FOTO ────────────────────────────────────────────────── --}}
<div class="card border-dark mb-3">
    <div class="card-header bg-dark text-white py-2">
        <strong><i class="fas fa-camera mr-1"></i> Berkas Foto Draft</strong>
    </div>
    <div class="card-body py-3">
        <div class="row">
            <div class="col-md-6 text-center">
                <p class="font-weight-bold mb-2">Foto 3x4</p>
                @if(!empty($foto['foto_3x4_tmp']))
                    <img src="{{ asset('storage/tmp/' . $foto['foto_3x4_tmp']) }}"
                         style="max-height:150px;max-width:100%;border:2px solid #dee2e6;border-radius:8px;"
                         alt="Foto 3x4">
                @else
                    <div class="text-muted"><i class="fas fa-image fa-2x mb-2 d-block"></i>-</div>
                @endif
            </div>
            <div class="col-md-6 text-center">
                <p class="font-weight-bold mb-2">Foto KK</p>
                @if(!empty($foto['foto_kk_tmp']))
                    <img src="{{ asset('storage/tmp/' . $foto['foto_kk_tmp']) }}"
                         style="max-height:150px;max-width:100%;border:2px solid #dee2e6;border-radius:8px;"
                         alt="Foto KK">
                @else
                    <div class="text-muted"><i class="fas fa-image fa-2x mb-2 d-block"></i>-</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ─── INFO AKUN WALI OTOMATIS ──────────────────────────────────────── --}}
<div class="card border-warning mb-4">
    <div class="card-header bg-warning py-2">
        <strong><i class="fas fa-key mr-1"></i> Akun Wali Otomatis</strong>
    </div>
    <div class="card-body py-3 text-center">
        <p class="mb-1">Sistem akan otomatis membuat akun wali (username, password = no_hp wali/random).</p>
        <p class="font-weight-bold text-danger mb-0">Klik "Simpan Pendaftaran" untuk memproses data ini secara mutlak.</p>
    </div>
</div>

{{-- ─── ACTION BUTTONS ───────────────────────────────────────────────── --}}
<button type="button" class="btn btn-primary btn-block btn-lg shadow-sm" id="btnStoreFinalModal">
    <i class="fas fa-save mr-1"></i> SELESAI &amp; SIMPAN PENDAFTARAN KE DATABASE
</button>

@endif
