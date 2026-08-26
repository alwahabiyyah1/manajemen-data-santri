@extends('layouts.admin')

@section('title', 'Edit Data Santri')
@section('page-title', 'Pembaruan Data Santri')
@section('page-subtitle', 'Perbarui detail informasi, riwayat, dan alamat santri')

@section('content')

@php
    $ds = $santri->dataSantri;
    $da = $santri->dataAyah;
    $di = $santri->dataIbu;
    $dw = $santri->dataWali;
    $ala = $santri->dataAyah?->alamat;
    $ali = $santri->dataIbu?->alamat;
    $alw = $santri->dataWali?->alamat;
    $as = $santri->alamatSantri;
@endphp

<form action="{{ route('admin.santri.update', $santri->id) }}" method="POST" id="formSantri" enctype="multipart/form-data">
@csrf @method('PUT')

<!-- Data Utama Card -->
<div class="card shadow mb-3">
    <div class="card-body py-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <i class="fas fa-pen-to-square fa-2x text-warning opacity-75"></i>
            </div>
            <div class="col">
                <strong>Data Utama #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}</strong>
                <p class="text-muted small mb-0">Ubah status aktivitas atau perbarui perwalian.</p>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold text-muted">Status Data <span class="text-danger">*</span></label>
                <select name="status_data" class="form-control form-control-sm" required>
                    @foreach(['aktif','tidak aktif','lulus','keluar'] as $s)
                    <option value="{{ $s }}" {{ $santri->status_data == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold text-muted">Wali Santri Terkait</label>
                <select name="id_wali" class="form-control form-control-sm">
                    <option value="">-- Pilih Wali (Opsional) --</option>
                    @foreach($waliList as $w)
                    <option value="{{ $w->id_wali }}" {{ $santri->id_wali == $w->id_wali ? 'selected' : '' }}>{{ $w->nama_wali }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-exclamation-circle mr-1"></i> Periksa kembali inputan Anda:</strong>
    <ul class="mb-0 mt-1 pl-3">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<!-- Tab Navigation -->
<div class="card shadow mb-4">
    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="formTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-pribadi" role="tab">
                    <i class="fas fa-user mr-1"></i> Identitas Santri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-ayah" role="tab">
                    <i class="fas fa-user-tie mr-1"></i> Data Ayah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-ibu" role="tab">
                    <i class="fas fa-person-dress mr-1"></i> Data Ibu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-wali" role="tab">
                    <i class="fas fa-user-shield mr-1"></i> Data Wali
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-alamat" role="tab">
                    <i class="fas fa-house-chimney mr-1"></i> Alamat &amp; Transportasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab-berkas" role="tab">
                    <i class="fas fa-camera mr-1"></i> Arsip &amp; Foto
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">

            <!-- TAB: Identitas Santri -->
            <div class="tab-pane fade show active" id="tab-pribadi" role="tabpanel">
                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-id-card mr-1"></i> Identitas Santri</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap Sesuai Dokumen <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap', $ds->nama_lengkap ?? '') }}" required>
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik', $ds->nik ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>No. KK</label><input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $ds->no_kk ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $ds->kewarganegaraan ?? 'WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Nama Kepala Keluarga</label><input type="text" name="nama_kapala_keluarga" class="form-control" value="{{ old('nama_kapala_keluarga', $ds->nama_kapala_keluarga ?? '') }}"></div></div>
                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $ds->tempat_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $ds->tanggal_lahir ?? '') }}"></div></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-laki" {{ ($ds->jenis_kelamin ?? '') == 'Laki-laki' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lk"><i class="fas fa-mars text-primary mr-1"></i> Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan" {{ ($ds->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pr"><i class="fas fa-venus text-danger mr-1"></i> Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>Agama</label><input type="text" name="agama" class="form-control" value="{{ old('agama', $ds->agama ?? 'Islam') }}"></div></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Susunan Keluarga</label>
                            <div class="d-flex align-items-center">
                                <span class="mr-2">Anak Ke-</span>
                                <input type="number" name="anak_ke" class="form-control mr-2" style="width:80px" value="{{ old('anak_ke', $ds->anak_ke ?? '') }}" min="1">
                                <span class="mr-2">Dari</span>
                                <input type="number" name="jumlah_saudara" class="form-control mr-2" style="width:80px" value="{{ old('jumlah_saudara', $ds->jumlah_saudara ?? '') }}" min="1">
                                <span>Bersaudara</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP / WA</label><input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $ds->no_hp ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $ds->email ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Cita-cita</label><input type="text" name="cita_cita" class="form-control" value="{{ old('cita_cita', $ds->cita_cita ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Hobi</label><input type="text" name="hobi" class="form-control" value="{{ old('hobi', $ds->hobi ?? '') }}"></div></div>
                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pembiaya Sekolah</label>
                            <select name="pembiaya_sekolah" class="form-control">
                                @foreach(['Orang Tua','Wali','Beasiswa','Lainnya'] as $p)
                                <option value="{{ $p }}" {{ ($ds->pembiaya_sekolah ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4"><div class="form-group"><label>Tahun Masuk</label><input type="number" name="tahun_masuk" class="form-control" value="{{ old('tahun_masuk', $ds->tahun_masuk ?? '') }}" min="2000" max="2100"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Tahun Keluar</label><input type="number" name="tahun_keluar" class="form-control" value="{{ old('tahun_keluar', $ds->tahun_keluar ?? '') }}" min="2000" max="2100" placeholder="Kosongkan bila belum"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kebutuhan Khusus</label><input type="text" name="kebutuhan_khusus" class="form-control" value="{{ old('kebutuhan_khusus', $ds->kebutuhan_khusus ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kebutuhan Disabilitas</label><input type="text" name="kebutuhan_disabilitas" class="form-control" value="{{ old('kebutuhan_disabilitas', $ds->kebutuhan_disabilitas ?? '') }}"></div></div>
                </div>
            </div>

            <!-- TAB: Data Ayah -->
            <div class="tab-pane fade" id="tab-ayah" role="tabpanel">
                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-user-tie mr-1"></i> Data Lengkap Ayah</h6>
                <div class="row">
                    <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Ayah</label><input type="text" name="nama_lengkap_ayah" class="form-control" value="{{ old('nama_lengkap_ayah', $da->nama_lengkap ?? '') }}" placeholder="Contoh: Budi Santoso"></div></div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Status Ayah</label>
                            <select name="status_ayah" class="form-control">
                                @foreach(['Ayah Kandung (Masih Hidup)','Ayah Kandung (Meninggal)','Ayah Tiri/Angkat'] as $sa)
                                <option value="{{ $sa }}" {{ ($da->status ?? '') == $sa ? 'selected' : '' }}>{{ $sa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP Ayah</label><input type="text" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah', $da->no_hp ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>NIK Ayah</label><input type="text" name="nik_ayah" class="form-control" value="{{ old('nik_ayah', $da->nik ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ayah" class="form-control" value="{{ old('kewarganegaraan_ayah', $da->kewarganegaraan ?? 'WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_ayah" class="form-control" value="{{ old('tempat_lahir_ayah', $da->tempat_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah', $da->tanggal_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir_ayah" class="form-control" value="{{ old('pendidikan_terakhir_ayah', $da->pendidikan_terakhir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pekerjaan Utama</label><input type="text" name="pekerjaan_utama_ayah" class="form-control" value="{{ old('pekerjaan_utama_ayah', $da->pekerjaan_utama ?? '') }}"></div></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Penghasilan per Bulan</label>
                            <div class="input-group">
                                <select name="penghasilan_perbulan_ayah" class="form-control">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    @foreach([
                                        'dibawah 800.000', '800.001 - 1.200.000', '1.200.001 - 1.800.000',
                                        '1.800.001 - 2.500.000', '2.500.001 - 3.500.000', '3.500.001 - 4.800.000',
                                        '4.800.001 - 6.500.000', '6.500.001 - 10.000.000', '10.000.001 - 20.000.000', 'diatas 20.000.001'
                                    ] as $penghasilan)
                                        <option value="{{ $penghasilan }}" {{ old('penghasilan_perbulan_ayah', $da->penghasilan_perbulan ?? '') == $penghasilan ? 'selected' : '' }}>
                                            {{ $penghasilan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TAB: Data Ibu -->
            <div class="tab-pane fade" id="tab-ibu" role="tabpanel">
                <h6 class="font-weight-bold text-danger mb-3"><i class="fas fa-person-dress mr-1"></i> Data Lengkap Ibu</h6>
                <div class="row">
                    <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Ibu</label><input type="text" name="nama_lengkap_ibu" class="form-control" value="{{ old('nama_lengkap_ibu', $di->nama_lengkap ?? '') }}" placeholder="Contoh: Siti Aminah"></div></div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Status Ibu</label>
                            <select name="status_ibu" class="form-control">
                                @foreach(['Ibu Kandung (Masih Hidup)','Ibu Kandung (Meninggal)','Ibu Tiri/Angkat'] as $si)
                                <option value="{{ $si }}" {{ ($di->status ?? '') == $si ? 'selected' : '' }}>{{ $si }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP Ibu</label><input type="text" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu', $di->no_hp ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>NIK Ibu</label><input type="text" name="nik_ibu" class="form-control" value="{{ old('nik_ibu', $di->nik ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ibu" class="form-control" value="{{ old('kewarganegaraan_ibu', $di->kewarganegaraan ?? 'WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_ibu" class="form-control" value="{{ old('tempat_lahir_ibu', $di->tempat_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu', $di->tanggal_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir_ibu" class="form-control" value="{{ old('pendidikan_terakhir_ibu', $di->pendidikan_terakhir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pekerjaan Utama</label><input type="text" name="pekerjaan_utama_ibu" class="form-control" value="{{ old('pekerjaan_utama_ibu', $di->pekerjaan_utama ?? '') }}"></div></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Penghasilan per Bulan</label>
                            <div class="input-group">
                                <select name="penghasilan_perbulan_ibu" class="form-control">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    @foreach([
                                        'dibawah 800.000', '800.001 - 1.200.000', '1.200.001 - 1.800.000',
                                        '1.800.001 - 2.500.000', '2.500.001 - 3.500.000', '3.500.001 - 4.800.000',
                                        '4.800.001 - 6.500.000', '6.500.001 - 10.000.000', '10.000.001 - 20.000.000', 'diatas 20.000.001'
                                    ] as $penghasilan)
                                        <option value="{{ $penghasilan }}" {{ old('penghasilan_perbulan_ibu', $di->penghasilan_perbulan ?? '') == $penghasilan ? 'selected' : '' }}>
                                            {{ $penghasilan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TAB: Data Wali -->
            <div class="tab-pane fade" id="tab-wali" role="tabpanel">
                <h6 class="font-weight-bold text-warning mb-3"><i class="fas fa-user-shield mr-1"></i> Data Lengkap Wali</h6>

                <!-- Banner Sinkronisasi -->
                <div class="card border-warning mb-3">
                    <div class="card-header py-2 bg-warning d-flex align-items-center flex-wrap" style="gap:10px;">
                        <strong><i class="fas fa-copy mr-1"></i> Salin Data Dari:</strong>
                        <div class="custom-control custom-checkbox custom-control-inline ml-2">
                            <input type="checkbox" class="custom-control-input cb-wali-sync-ad" id="cb_edit_wali_sama_ayah" value="ayah">
                            <label class="custom-control-label small font-weight-bold" for="cb_edit_wali_sama_ayah">
                                <i class="fas fa-user-tie mr-1"></i> Sama dengan Ayah
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input cb-wali-sync-ad" id="cb_edit_wali_sama_ibu" value="ibu">
                            <label class="custom-control-label small font-weight-bold" for="cb_edit_wali_sama_ibu">
                                <i class="fas fa-person-dress mr-1"></i> Sama dengan Ibu
                            </label>
                        </div>
                        <span id="wali-sync-badge-ad" class="badge badge-dark ml-auto" style="display:none;font-size:.75rem;">
                            <i class="fas fa-lock mr-1"></i> Tersinkronisasi &mdash; hapus centang untuk edit manual
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Wali</label><input type="text" name="nama_lengkap_wali" id="nama_lengkap_wali" class="form-control" value="{{ old('nama_lengkap_wali', $dw->nama_lengkap ?? '') }}" placeholder="Contoh: Ahmad Fauzi"></div></div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Hubungan dengan Santri</label>
                            <select name="status_wali" id="status_wali" class="form-control">
                                @foreach(['Ayah/Ibu','Paman/Bibi','Kakek/Nenek','Kakak Kandung','Saudara','Pesantren/Lembaga','Lainnya'] as $sw)
                                <option value="{{ $sw }}" {{ old('status_wali', $dw->status ?? 'Ayah/Ibu') == $sw ? 'selected' : '' }}>{{ $sw }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP Wali</label><input type="text" name="no_hp_wali" id="no_hp_wali" class="form-control" value="{{ old('no_hp_wali', $dw->no_hp ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>NIK Wali</label><input type="text" name="nik_wali" id="nik_wali" class="form-control" value="{{ old('nik_wali', $dw->nik ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_wali" id="kewarganegaraan_wali" class="form-control" value="{{ old('kewarganegaraan_wali', $dw->kewarganegaraan ?? 'WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_wali" id="tempat_lahir_wali" class="form-control" value="{{ old('tempat_lahir_wali', $dw->tempat_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_wali" id="tanggal_lahir_wali" class="form-control" value="{{ old('tanggal_lahir_wali', $dw->tanggal_lahir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir_wali" id="pendidikan_terakhir_wali" class="form-control" value="{{ old('pendidikan_terakhir_wali', $dw->pendidikan_terakhir ?? '') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Pekerjaan Utama</label><input type="text" name="pekerjaan_utama_wali" id="pekerjaan_utama_wali" class="form-control" value="{{ old('pekerjaan_utama_wali', $dw->pekerjaan_utama ?? '') }}"></div></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Penghasilan per Bulan</label>
                            <select name="penghasilan_perbulan_wali" id="penghasilan_perbulan_wali" class="form-control">
                                <option value="">-- Pilih Penghasilan --</option>
                                @foreach([
                                    'dibawah 800.000', '800.001 - 1.200.000', '1.200.001 - 1.800.000',
                                    '1.800.001 - 2.500.000', '2.500.001 - 3.500.000', '3.500.001 - 4.800.000',
                                    '4.800.001 - 6.500.000', '6.500.001 - 10.000.000', '10.000.001 - 20.000.000', 'diatas 20.000.001'
                                ] as $penghasilan)
                                    <option value="{{ $penghasilan }}" {{ old('penghasilan_perbulan_wali', $dw->penghasilan_perbulan ?? '') == $penghasilan ? 'selected' : '' }}>
                                        {{ $penghasilan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TAB: Alamat & Transportasi Santri -->
            <div class="tab-pane fade" id="tab-alamat" role="tabpanel">
                <h6 class="font-weight-bold text-success mb-3"><i class="fas fa-house-chimney-user mr-1"></i> Alamat Domisili Santri</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Mukim di Pesantren</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_mukim" id="mukim" value="Mukim" {{ ($as->status_mukim ?? '') == 'Mukim' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="mukim"><span class="text-success font-weight-bold">Mukim</span></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_mukim" id="pulper" value="Tidak Mukim" {{ ($as->status_mukim ?? '') == 'Tidak Mukim' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pulper"><span class="text-warning font-weight-bold">Tidak Mukim</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tinggal Bersama</label>
                            <select name="status_tempat_tinggal" class="form-control">
                                @foreach(['Orang Tua','Wali / Keluarga','Asrama Pesantren','Kost / Kontrakan'] as $tmpt)
                                <option value="{{ $tmpt }}" {{ ($as->status_tempat_tinggal ?? '') == $tmpt ? 'selected' : '' }}>{{ $tmpt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_santri" id="provinsi_santri" class="form-control form-control-sm" data-old="{{ old('provinsi_santri', $as->provinsi ?? '') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                    <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_santri" id="kabupaten_santri" class="form-control form-control-sm" data-old="{{ old('kabupaten_santri', $as->kabupaten ?? '') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                    <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_santri" id="kecamatan_santri" class="form-control form-control-sm" data-old="{{ old('kecamatan_santri', $as->kecamatan ?? '') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                    <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_santri" id="desa_santri" class="form-control form-control-sm" data-old="{{ old('desa_santri', $as->desa ?? '') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                    <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_santri" id="rt_santri" class="form-control form-control-sm" value="{{ old('rt_santri', $as->rt ?? '') }}"></div></div>
                    <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_santri" id="rw_santri" class="form-control form-control-sm" value="{{ old('rw_santri', $as->rw ?? '') }}"></div></div>
                    <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_santri" id="kode_pos_santri" class="form-control form-control-sm" value="{{ old('kode_pos_santri', $as->kode_pos ?? '') }}"></div></div>
                    <div class="col-md-2"><div class="form-group"><label class="small">Koordinat</label><input type="text" name="koordinat" id="koordinat" class="form-control form-control-sm" value="{{ old('koordinat', $as->koordinat ?? '') }}" placeholder="-7.123, 110.45"></div></div>
                    <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_santri" id="alamat_santri" class="form-control" rows="2">{{ old('alamat_santri', $as->alamat ?? '') }}</textarea></div></div>
                </div>

                <!-- Alamat Ayah -->
                <div class="card border-primary mt-3">
                    <div class="card-header py-2 bg-primary text-white"><strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Ayah</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_ayah" id="provinsi_ayah" class="form-control form-control-sm" data-old="{{ old('provinsi_ayah', $ala->provinsi ?? '') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_ayah" id="kabupaten_ayah" class="form-control form-control-sm" data-old="{{ old('kabupaten_ayah', $ala->kabupaten ?? '') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_ayah" id="kecamatan_ayah" class="form-control form-control-sm" data-old="{{ old('kecamatan_ayah', $ala->kecamatan ?? '') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_ayah" id="desa_ayah" class="form-control form-control-sm" data-old="{{ old('desa_ayah', $ala->desa ?? '') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_ayah" id="rt_ayah" class="form-control form-control-sm" value="{{ old('rt_ayah', $ala->rt ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_ayah" id="rw_ayah" class="form-control form-control-sm" value="{{ old('rw_ayah', $ala->rw ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_ayah" id="kode_pos_ayah" class="form-control form-control-sm" value="{{ old('kode_pos_ayah', $ala->kode_pos ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_ayah" id="status_kepemilikan_ayah" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_ayah', $ala->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="2" placeholder="Jl. Anggrek No. 123...">{{ old('alamat_ayah', $ala->alamat ?? '') }}</textarea></div></div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Ibu -->
                <div class="card border-danger mt-3">
                    <div class="card-header py-2 bg-danger text-white"><strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Ibu</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_ibu" id="provinsi_ibu" class="form-control form-control-sm" data-old="{{ old('provinsi_ibu', $ali->provinsi ?? '') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_ibu" id="kabupaten_ibu" class="form-control form-control-sm" data-old="{{ old('kabupaten_ibu', $ali->kabupaten ?? '') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_ibu" id="kecamatan_ibu" class="form-control form-control-sm" data-old="{{ old('kecamatan_ibu', $ali->kecamatan ?? '') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_ibu" id="desa_ibu" class="form-control form-control-sm" data-old="{{ old('desa_ibu', $ali->desa ?? '') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_ibu" id="rt_ibu" class="form-control form-control-sm" value="{{ old('rt_ibu', $ali->rt ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_ibu" id="rw_ibu" class="form-control form-control-sm" value="{{ old('rw_ibu', $ali->rw ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_ibu" id="kode_pos_ibu" class="form-control form-control-sm" value="{{ old('kode_pos_ibu', $ali->kode_pos ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_ibu" id="status_kepemilikan_ibu" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_ibu', $ali->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="2">{{ old('alamat_ibu', $ali->alamat ?? '') }}</textarea></div></div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Wali -->
                <div class="card border-warning mt-3">
                    <div class="card-header py-2 bg-warning"><strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Wali</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_wali" id="provinsi_wali" class="form-control form-control-sm" data-old="{{ old('provinsi_wali', $alw->provinsi ?? '') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_wali" id="kabupaten_wali" class="form-control form-control-sm" data-old="{{ old('kabupaten_wali', $alw->kabupaten ?? '') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_wali" id="kecamatan_wali" class="form-control form-control-sm" data-old="{{ old('kecamatan_wali', $alw->kecamatan ?? '') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_wali" id="desa_wali" class="form-control form-control-sm" data-old="{{ old('desa_wali', $alw->desa ?? '') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_wali" id="rt_wali" class="form-control form-control-sm" value="{{ old('rt_wali', $alw->rt ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_wali" id="rw_wali" class="form-control form-control-sm" value="{{ old('rw_wali', $alw->rw ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_wali" id="kode_pos_wali" class="form-control form-control-sm" value="{{ old('kode_pos_wali', $alw->kode_pos ?? '') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_wali" id="status_kepemilikan_wali" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_wali', $alw->status_kepemilikan ?? '') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_wali" id="alamat_wali" class="form-control" rows="2">{{ old('alamat_wali', $alw->alamat ?? '') }}</textarea></div></div>
                        </div>
                    </div>
                </div>

                <!-- Transportasi -->
                <div class="card border-warning mt-2">
                    <div class="card-header py-2 bg-warning"><strong><i class="fas fa-car mr-1"></i> Akses &amp; Transportasi ke Lembaga</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Moda Transportasi</label>
                                    <select name="transportasi" class="form-control form-control-sm">
                                        @foreach(['Jalan Kaki','Sepeda','Sepeda Motor','Mobil Pribadi','Angkutan Umum'] as $tr)
                                        <option value="{{ $tr }}" {{ ($as->transportasi ?? '') == $tr ? 'selected' : '' }}>{{ $tr }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Jarak Tempuh</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="jarak_ke_lembaga" class="form-control" value="{{ old('jarak_ke_lembaga', $as->jarak_ke_lembaga ?? '') }}">
                                        <div class="input-group-append"><span class="input-group-text">Km</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Waktu Tempuh</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="waktu_tempuh" class="form-control" value="{{ old('waktu_tempuh', $as->waktu_tempuh ?? '') }}">
                                        <div class="input-group-append"><span class="input-group-text">Menit</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Arsip & Foto -->
            <div class="tab-pane fade" id="tab-berkas" role="tabpanel">
                <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-camera mr-1"></i> Pengaturan Foto Santri</h6>
                
                <div class="alert alert-info py-2 small mb-4">
                    <i class="fas fa-circle-info mr-1"></i> Anda tidak wajib memperbarui foto. Kosongkan field jika tidak ingin mengubah foto saat ini.
                </div>

                <div class="row">
                    <!-- Foto 3x4 (Portrait) -->
                    <div class="col-md-5 mb-4">
                        <div class="card border-primary shadow-sm h-100">
                            <div class="card-header bg-primary text-white py-2 d-flex align-items-center">
                                <strong><i class="fas fa-id-card mr-1"></i> Foto 3x4 (Profil Utama)</strong>
                                <span class="badge badge-light ml-auto" style="font-size:.7rem;">Rasio 3 : 4</span>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3 d-flex justify-content-center">
                                    <div id="preview-foto3x4" style="height:150px;width:112px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                        @if($ds->foto_3x4)
                                            <img src="{{ asset('storage/berkas/' . $ds->foto_3x4) }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <span class="text-muted small"><i class="fas fa-user mb-1 d-block fa-2x"></i>Kosong</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input" id="foto_3x4" name="foto_3x4" accept="image/*">
                                    <label class="custom-file-label" for="foto_3x4">Ganti foto 3x4...</label>
                                </div>
                                <small class="text-muted d-block mt-1">Maks. 2 MB &bull; JPG/PNG &bull; Akan dicrop otomatis</small>
                            </div>
                        </div>
                    </div>

                    <!-- Foto KK (Landscape) -->
                    <div class="col-md-7 mb-4">
                        <div class="card border-success shadow-sm h-100">
                            <div class="card-header bg-success text-white py-2 d-flex align-items-center">
                                <strong><i class="fas fa-users-rectangle mr-1"></i> Foto Kartu Keluarga (KK)</strong>
                                <span class="badge badge-light ml-auto" style="font-size:.7rem;">Landscape</span>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3 d-flex justify-content-center">
                                    <div id="preview-fotokk" style="height:150px;width:100%;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                        @if($ds->foto_kk)
                                            <img src="{{ asset('storage/berkas/' . $ds->foto_kk) }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <span class="text-muted small"><i class="fas fa-image mb-1 d-block fa-2x"></i>Kosong</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" accept="image/*">
                                    <label class="custom-file-label" for="foto_kk">Ganti foto KK...</label>
                                </div>
                                <small class="text-muted d-block mt-1">Maks. 2 MB &bull; JPG/PNG &bull; Akan dicrop otomatis</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="border-top pt-3 d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted"><i class="fas fa-circle-info mr-1 text-primary"></i> Pastikan semua data bertanda (*) telah terisi.</small>
            <div>
                <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-times mr-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning font-weight-bold" id="submitBtn">
                    <i class="fas fa-floppy-disk mr-1"></i> Simpan Pembaruan
                </button>
            </div>
        </div>
    </div>
</div>

</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formSantri').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Memperbarui...';
        btn.disabled = true;
    });

    /* Crop input registration (crop modal partial will handle the open/close) */
    window.addEventListener('load', function () {
        if (typeof registerCropInput === 'function') {
            registerCropInput('foto_3x4', '#preview-foto3x4', 'foto');
            registerCropInput('foto_kk',  '#preview-fotokk',  'kk');
        }
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

    initWilayah('provinsi_wali', 'kabupaten_wali', 'kecamatan_wali', 'desa_wali');
    initWilayah('provinsi_ayah', 'kabupaten_ayah', 'kecamatan_ayah', 'desa_ayah');
    initWilayah('provinsi_ibu', 'kabupaten_ibu', 'kecamatan_ibu', 'desa_ibu');
    initWilayah('provinsi_santri', 'kabupaten_santri', 'kecamatan_santri', 'desa_santri');

    // -- Sync Wali dari Ayah / Ibu (Admin Edit) --
    (function () {
        var waliKeys = ['nama_lengkap_','no_hp_','nik_','kewarganegaraan_','tempat_lahir_',
                        'tanggal_lahir_','pendidikan_terakhir_','pekerjaan_utama_','penghasilan_perbulan_'];

        function syncWaliAdmin(srcSfx, lock) {
            waliKeys.forEach(function(key) {
                var s = document.getElementById(key + srcSfx) || document.querySelector('[name="' + key + srcSfx + '"]');
                var d = document.getElementById(key + 'wali');
                if (!s || !d) return;
                if (lock) {
                    d.value = s.value;
                    d.readOnly = true;
                    d.style.background = '#f8f9fa';
                    d.style.cursor = 'not-allowed';
                    if (d.tagName === 'SELECT') d.style.pointerEvents = 'none';
                } else {
                    d.readOnly = false;
                    d.style.background = '';
                    d.style.cursor = '';
                    if (d.tagName === 'SELECT') d.style.pointerEvents = 'auto';
                }
            });
            var badge = document.getElementById('wali-sync-badge-ad');
            if (badge) badge.style.display = lock ? 'inline-block' : 'none';
        }

        document.querySelectorAll('.cb-wali-sync-ad').forEach(function(cb) {
            cb.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('.cb-wali-sync-ad').forEach(function(o){ if(o!==cb) o.checked=false; });
                    syncWaliAdmin(cb.value, true);
                } else { syncWaliAdmin(cb.value, false); }
            });
        });

        ['ayah','ibu'].forEach(function(sfx) {
            waliKeys.forEach(function(key) {
                var srcEl = document.getElementById(key + sfx) || document.querySelector('[name="' + key + sfx + '"]');
                if (!srcEl) return;
                ['input','change'].forEach(function(ev) {
                    srcEl.addEventListener(ev, function() {
                        var cb = document.getElementById('cb_edit_wali_sama_' + sfx);
                        if (cb && cb.checked) syncWaliAdmin(sfx, true);
                    });
                });
            });
        });
    })();

});
</script>
@endpush

{{-- Crop Modal Partial --}}
@include('partials._crop_modal')

@endsection
