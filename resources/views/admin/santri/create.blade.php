@extends('layouts.admin')

@section('title', 'Pendataaan Santri Baru')
@section('page-title', 'Form Pendataan Santri')
@section('page-subtitle', 'Silakan lengkapi formulir pendataan santri baru di bawah ini')

@section('content')

<form action="{{ route('admin.santri.saveStep') }}" method="POST" id="formSantri" enctype="multipart/form-data">
@csrf

<!-- Data Utama Card -->
<div class="card shadow mb-3">
    <div class="card-body py-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <i class="fas fa-address-card fa-2x text-primary opacity-75"></i>
            </div>
            <div class="col">
                <strong>Data Utama</strong>
                <p class="text-muted small mb-0">Tentukan status aktivitas dan wali santri.</p>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold text-muted">Status Data <span class="text-danger">*</span></label>
                <select name="status_data" class="form-control form-control-sm" required>
                    @foreach(['aktif','tidak aktif','lulus','keluar'] as $s)
                    <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="small font-weight-bold text-muted">Wali Santri Terkait</label>
                <select name="id_wali" class="form-control form-control-sm">
                    <option value="">-- Pilih Wali (Opsional) --</option>
                    @foreach($waliList as $w)
                    <option value="{{ $w->id_wali }}">{{ $w->nama_wali }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-exclamation-circle mr-1"></i> Terdapat kesalahan pada inputan:</strong>
    <ul class="mb-0 mt-1 pl-3">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<!-- Tab Navigation -->
<div class="card shadow mb-4">
    <div class="card-header p-0">
        <ul class="nav nav-tabs nav-tabs-form" id="formTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-pribadi-tab" data-toggle="tab" href="#tab-pribadi" role="tab">
                    <i class="fas fa-user mr-1"></i> Identitas Santri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-ayah-tab" data-toggle="tab" href="#tab-ayah" role="tab">
                    <i class="fas fa-user-tie mr-1"></i> Data Ayah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-ibu-tab" data-toggle="tab" href="#tab-ibu" role="tab">
                    <i class="fas fa-person-dress mr-1"></i> Data Ibu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-alamat-tab" data-toggle="tab" href="#tab-alamat" role="tab">
                    <i class="fas fa-house-chimney mr-1"></i> Alamat &amp; Transportasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-wali-tab" data-toggle="tab" href="#tab-wali" role="tab">
                    <i class="fas fa-user-shield mr-1"></i> Data Wali
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-foto-tab" data-toggle="tab" href="#tab-foto" role="tab">
                    <i class="fas fa-camera mr-1"></i> Upload Foto
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-preview-tab" data-toggle="tab" href="#tab-preview" role="tab" style="pointer-events: none; opacity: 0.6;">
                    <i class="fas fa-eye mr-1"></i> Preview & Simpan
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="formTabsContent">

            <!-- TAB: Identitas Santri -->
            <div class="tab-pane fade show active" id="tab-pribadi" role="tabpanel">
                <h6 class="font-weight-bold text-primary mb-3">
                    <i class="fas fa-id-card mr-1"></i> Identitas Santri
                </h6>

                <!-- Informasi Utama -->
                <div class="card bg-light border mb-3">
                    <div class="card-body py-3">
                        <h6 class="font-weight-bold mb-3 text-secondary border-bottom pb-2">
                            <i class="fas fa-address-book mr-1"></i> Informasi Utama Sesuai Dokumen
                        </h6>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap Sesuai Dokumen <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Ahmad Zaini" required>
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="16 digit NIK"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>No. Kartu Keluarga (KK)</label><input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}" placeholder="16 digit KK"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan','WNI') }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Nama Kepala Keluarga (KK)</label><input type="text" name="nama_kapala_keluarga" class="form-control" value="{{ old('nama_kapala_keluarga') }}"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Data Kelahiran -->
                <div class="card bg-light border mb-3">
                    <div class="card-body py-3">
                        <h6 class="font-weight-bold mb-3 text-secondary border-bottom pb-2">
                            <i class="fas fa-cake-candles mr-1"></i> Data Kelahiran &amp; Personal
                        </h6>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Kab/Kota"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}"></div></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'checked':'' }}>
                                            <label class="form-check-label" for="lk"><i class="fas fa-mars text-primary mr-1"></i> Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'checked':'' }}>
                                            <label class="form-check-label" for="pr"><i class="fas fa-venus text-danger mr-1"></i> Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"><div class="form-group"><label>Agama</label><input type="text" name="agama" class="form-control" value="{{ old('agama','Islam') }}"></div></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Susunan Keluarga</label>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">Anak Ke-</span>
                                        <input type="number" name="anak_ke" class="form-control mr-2" style="width:80px" value="{{ old('anak_ke') }}" min="1">
                                        <span class="mr-2">Dari</span>
                                        <input type="number" name="jumlah_saudara" class="form-control mr-2" style="width:80px" value="{{ old('jumlah_saudara') }}" min="1">
                                        <span>Bersaudara</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak & Akademik -->
                <div class="card bg-light border mb-3">
                    <div class="card-body py-3">
                        <h6 class="font-weight-bold mb-3 text-secondary border-bottom pb-2">
                            <i class="fas fa-graduation-cap mr-1"></i> Kontak &amp; Akademik
                        </h6>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group"><label>No. HP / WA Santri</label><input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08xx..."></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Email Santri</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Cita-cita</label><input type="text" name="cita_cita" class="form-control" value="{{ old('cita_cita') }}"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Hobi / Minat</label><input type="text" name="hobi" class="form-control" value="{{ old('hobi') }}"></div></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pembiaya Sekolah</label>
                                    <select name="pembiaya_sekolah" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Orang Tua','Wali/Orang Tua Asuh','Tanggungan Sendiri','Lainnya'] as $pb)
                                        <option value="{{ $pb }}" {{ old('pembiaya_sekolah')==$pb?'selected':'' }}>{{ $pb }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"><div class="form-group"><label>Tahun Masuk</label><input type="number" name="tahun_masuk" class="form-control" value="{{ old('tahun_masuk', date('Y')) }}" min="2000" max="2100"></div></div>
                            <div class="col-md-4"><div class="form-group"><label>Tahun Keluar</label><input type="number" name="tahun_keluar" class="form-control" value="{{ old('tahun_keluar') }}" min="2000" max="2100" placeholder="Kosongkan bila belum"></div></div>
                            <div class="col-md-6"><div class="form-group"><label>Kebutuhan Disabilitas</label><input type="text" name="kebutuhan_disabilitas" class="form-control" value="{{ old('kebutuhan_disabilitas') }}" placeholder="Tuna Netra/Rungu/dll (Kosongkan bila tidak ada)"></div></div>
                            <div class="col-md-6"><div class="form-group"><label class="text-warning"><i class="fas fa-notes-medical mr-1"></i> Kebutuhan Medis Khusus</label><input type="text" name="kebutuhan_khusus" class="form-control border-warning" value="{{ old('kebutuhan_khusus') }}" placeholder="Riwayat alergi/medis (Kosongkan bila tidak ada)"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Nav Identitas -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-simpan-lanjut" data-step="pribadi" data-next="tab-ayah">
                        <i class="fas fa-arrow-right mr-1"></i> Simpan &amp; Lanjutkan
                    </button>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-ayah" role="tabpanel">
                <h6 class="font-weight-bold text-primary mb-3">
                    <i class="fas fa-user-tie mr-1"></i> Data Lengkap Ayah
                </h6>
                <div class="row">
                    <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Ayah</label><input type="text" name="nama_lengkap_ayah" id="nama_lengkap_ayah" class="form-control" value="{{ old('nama_lengkap_ayah') }}" placeholder="Contoh: Budi Santoso"></div></div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Status Hidup / Hubungan</label>
                            <select name="status_ayah" class="form-control">
                                @foreach(['Ayah Kandung (Masih Hidup)','Ayah Kandung (Meninggal)','Ayah Tiri/Angkat'] as $sa)
                                <option value="{{ $sa }}" {{ old('status_ayah')==$sa?'selected':'' }}>{{ $sa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP / WA Ayah</label><input type="text" name="no_hp_ayah" id="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah') }}" placeholder="08xx..."></div></div>
                    <div class="col-md-6"><div class="form-group"><label>NIK Ayah</label><input type="text" name="nik_ayah" id="nik_ayah" class="form-control" value="{{ old('nik_ayah') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ayah" id="kewarganegaraan_ayah" class="form-control" value="{{ old('kewarganegaraan_ayah','WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" value="{{ old('tempat_lahir_ayah') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah') }}"></div></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir_ayah" id="pendidikan_terakhir_ayah" class="form-control">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Bersekolah', 'Lainnya'] as $pendidikan)
                                <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir_ayah') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pekerjaan Utama</label>
                            <select name="pekerjaan_utama_ayah" id="pekerjaan_utama_ayah" class="form-control">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach([
                                    'Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pengacara/Jaksa/Hakim/Notaris','Seniman/Pelukis/Artis/Sejenis','Dokter/Bidan/Perawat','Pilot/Pramugara','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Politikus','Lainnya'
                                ] as $pekerjaan)
                                <option value="{{ $pekerjaan }}" {{ old('pekerjaan_utama_ayah') == $pekerjaan ? 'selected' : '' }}>
                                    {{ $pekerjaan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Rata-rata Penghasilan per Bulan</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <select name="penghasilan_perbulan_ayah" id="penghasilan_perbulan_ayah" class="form-control">
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
                                        <option value="{{ $penghasilan }}" {{ old('penghasilan_perbulan_ayah') == $penghasilan ? 'selected' : '' }}>
                                            {{ $penghasilan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav Ayah -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-simpan-lanjut" data-step="ayah" data-next="tab-ibu">
                        <i class="fas fa-arrow-right mr-1"></i> Simpan &amp; Lanjutkan
                    </button>
                </div>
            </div>

            <!-- TAB: Data Ibu -->
            <div class="tab-pane fade" id="tab-ibu" role="tabpanel">
                <h6 class="font-weight-bold text-danger mb-3">
                    <i class="fas fa-person-dress mr-1"></i> Data Lengkap Ibu
                </h6>
                <div class="row">
                    <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Ibu</label><input type="text" name="nama_lengkap_ibu" id="nama_lengkap_ibu" class="form-control" value="{{ old('nama_lengkap_ibu') }}" placeholder="Contoh: Siti Aminah"></div></div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Status Hidup / Hubungan</label>
                            <select name="status_ibu" class="form-control">
                                @foreach(['Ibu Kandung (Masih Hidup)','Ibu Kandung (Meninggal)','Ibu Tiri/Angkat'] as $si)
                                <option value="{{ $si }}" {{ old('status_ibu')==$si?'selected':'' }}>{{ $si }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6"><div class="form-group"><label>No. HP / WA Ibu</label><input type="text" name="no_hp_ibu" id="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu') }}" placeholder="08xx..."></div></div>
                    <div class="col-md-6"><div class="form-group"><label>NIK Ibu</label><input type="text" name="nik_ibu" id="nik_ibu" class="form-control" value="{{ old('nik_ibu') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ibu" id="kewarganegaraan_ibu" class="form-control" value="{{ old('kewarganegaraan_ibu','WNI') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" value="{{ old('tempat_lahir_ibu') }}"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu') }}"></div></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir_ibu" id="pendidikan_terakhir_ibu" class="form-control">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Bersekolah', 'Lainnya'] as $pendidikan)
                                <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir_ibu') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pekerjaan Utama</label>
                            <select name="pekerjaan_utama_ibu" id="pekerjaan_utama_ibu" class="form-control">
                                <option value="">-- Pilih Pekerjaan --</option>
                                @foreach([
                                    'Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pengacara/Jaksa/Hakim/Notaris','Seniman/Pelukis/Artis/Sejenis','Dokter/Bidan/Perawat','Pilot/Pramugara','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Politikus','Ibu Rumah Tangga','Lainnya'
                                ] as $pekerjaan)
                                <option value="{{ $pekerjaan }}" {{ old('pekerjaan_utama_ibu') == $pekerjaan ? 'selected' : '' }}>
                                    {{ $pekerjaan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Rata-rata Penghasilan per Bulan</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <select name="penghasilan_perbulan_ayah" id="penghasilan_perbulan_ayah" class="form-control">
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
                                        <option value="{{ $penghasilan }}" {{ old('penghasilan_perbulan_ayah') == $penghasilan ? 'selected' : '' }}>
                                            {{ $penghasilan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav Ibu -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-simpan-lanjut" data-step="ibu" data-next="tab-alamat">
                        <i class="fas fa-arrow-right mr-1"></i> Simpan &amp; Lanjutkan
                    </button>
                </div>
            </div>

            <!-- TAB: Data Wali -->
            <div class="tab-pane fade" id="tab-wali" role="tabpanel">
                <div class="alert alert-info py-2 mb-3">
                    <strong><i class="fas fa-circle-info mr-1"></i> Data Wali / Pengasuh</strong>
                </div>

                <!-- Sinkronisasi -->                
                <div class="card border-secondary mb-3">
                    <div class="card-header py-2 bg-secondary text-white d-flex align-items-center justify-content-between">
                        <strong><i class="fas fa-copy mr-1"></i> Salin Data Dari</strong>
                        <div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input cb-wali-sync" id="cb_wali_sama_ayah" value="ayah">
                                <label class="custom-control-label small" for="cb_wali_sama_ayah">Sama dengan Ayah</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input cb-wali-sync" id="cb_wali_sama_ibu" value="ibu">
                                <label class="custom-control-label small" for="cb_wali_sama_ibu">Sama dengan Ibu</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Manual Wali -->
                <div id="form-wali-manual">
                    <h6 class="font-weight-bold text-secondary mb-3"><i class="fas fa-user-shield mr-1"></i> Data Lengkap Wali / Pengasuh</h6>
                    <div class="row">
                        <div class="col-md-12"><div class="form-group"><label class="font-weight-bold">Nama Lengkap Wali</label><input type="text" name="nama_lengkap_wali" id="nama_lengkap_wali" class="form-control" value="{{ old('nama_lengkap_wali') }}" placeholder="Contoh: Hasan Abdullah"></div></div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Hubungan dengan Santri</label>
                                <select name="status_wali" class="form-control">
                                    @foreach(['Ayah/Ibu','Paman/Bibi','Kakek/Nenek','Kakak Kandung','Saudara','Pesantren/Lembaga','Lainnya'] as $hw)
                                    <option value="{{ $hw }}" {{ old('status_wali','Ayah/Ibu')==$hw?'selected':'' }}>{{ $hw }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"><div class="form-group"><label>No. HP / WA Wali</label><input type="text" name="no_hp_wali" id="no_hp_wali" class="form-control" value="{{ old('no_hp_wali') }}" placeholder="08xx..."></div></div>
                        <div class="col-md-6"><div class="form-group"><label>NIK Wali</label><input type="text" name="nik_wali" id="nik_wali" class="form-control" value="{{ old('nik_wali') }}"></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_wali" id="kewarganegaraan_wali" class="form-control" value="{{ old('kewarganegaraan_wali','WNI') }}"></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_wali" id="tempat_lahir_wali" class="form-control" value="{{ old('tempat_lahir_wali') }}"></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir_wali" id="tanggal_lahir_wali" class="form-control" value="{{ old('tanggal_lahir_wali') }}"></div></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir_wali" id="pendidikan_terakhir_wali" class="form-control">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3', 'Tidak Bersekolah', 'Lainnya'] as $pendidikan)
                                    <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir_wali') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pekerjaan Utama</label>
                                <select name="pekerjaan_utama_wali" id="pekerjaan_utama_wali" class="form-control">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach([
                                        'Tidak Bekerja','Pensiunan','PNS','TNI/Polisi','Guru/Dosen','Pegawai Swasta','Wiraswasta','Pengacara/Jaksa/Hakim/Notaris','Seniman/Pelukis/Artis/Sejenis','Dokter/Bidan/Perawat','Pilot/Pramugara','Pedagang','Petani/Peternak','Nelayan','Buruh (Tani/Pabrik/Bangunan)','Sopir/Masinis/Kondektur','Politikus','Lainnya'
                                    ] as $pekerjaan)
                                    <option value="{{ $pekerjaan }}" {{ old('pekerjaan_utama_wali') == $pekerjaan ? 'selected' : '' }}>
                                        {{ $pekerjaan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Penghasilan per Bulan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                    <input type="number" name="penghasilan_perbulan_wali" id="penghasilan_perbulan_wali" class="form-control" value="{{ old('penghasilan_perbulan_wali') }}" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Wali -->
                    <div class="card border-secondary mt-2">
                        <div class="card-header py-2 bg-secondary text-white d-flex justify-content-between align-items-center">
                            <strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Wali</strong>
                            {{-- <div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input cb-alamat-wali-sync" id="cb_alamat_wali_sama_ayah" value="ayah">
                                    <label class="custom-control-label small" for="cb_alamat_wali_sama_ayah">Sama dg Ayah</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input cb-alamat-wali-sync" id="cb_alamat_wali_sama_ibu" value="ibu">
                                    <label class="custom-control-label small" for="cb_alamat_wali_sama_ibu">Sama dg Ibu</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_wali" id="alamat_wali" class="form-control" rows="2" placeholder="Jl. Anggrek No. 123...">{{ old('alamat_wali') }}</textarea></div></div>
                                <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_wali" id="rt_wali" class="form-control form-control-sm" value="{{ old('rt_wali') }}"></div></div>
                                <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_wali" id="rw_wali" class="form-control form-control-sm" value="{{ old('rw_wali') }}"></div></div>
                                <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_wali" id="provinsi_wali" class="form-control form-control-sm" data-old="{{ old('provinsi_wali') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                                <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_wali" id="kabupaten_wali" class="form-control form-control-sm" data-old="{{ old('kabupaten_wali') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                                <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_wali" id="kecamatan_wali" class="form-control form-control-sm" data-old="{{ old('kecamatan_wali') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                                <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_wali" id="desa_wali" class="form-control form-control-sm" data-old="{{ old('desa_wali') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                                <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_wali" id="kode_pos_wali" class="form-control form-control-sm" value="{{ old('kode_pos_wali') }}"></div></div>
                                <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_wali" id="status_kepemilikan_wali" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_wali') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav Wali -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-simpan-lanjut" data-step="wali" data-next="tab-foto">
                        <i class="fas fa-arrow-right mr-1"></i> Simpan &amp; Lanjutkan
                    </button>
                </div>
            </div>

            <!-- TAB: Alamat & Transportasi -->
            <div class="tab-pane fade" id="tab-alamat" role="tabpanel">
                <h6 class="font-weight-bold text-success mb-3">
                    <i class="fas fa-map-location-dot mr-1"></i> Alamat &amp; Transportasi
                </h6>

                <!-- Alamat Ayah -->
                <div class="card border-primary mb-3">
                    <div class="card-header py-2 bg-primary text-white"><strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Ayah</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_ayah" id="provinsi_ayah" class="form-control form-control-sm" data-old="{{ old('provinsi_ayah') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_ayah" id="kabupaten_ayah" class="form-control form-control-sm" data-old="{{ old('kabupaten_ayah') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_ayah" id="kecamatan_ayah" class="form-control form-control-sm" data-old="{{ old('kecamatan_ayah') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_ayah" id="desa_ayah" class="form-control form-control-sm" data-old="{{ old('desa_ayah') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_ayah" id="rt_ayah" class="form-control form-control-sm" value="{{ old('rt_ayah') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_ayah" id="rw_ayah" class="form-control form-control-sm" value="{{ old('rw_ayah') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_ayah" id="kode_pos_ayah" class="form-control form-control-sm" value="{{ old('kode_pos_ayah') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_ayah" id="status_kepemilikan_ayah" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_ayah') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="2" placeholder="Jl. Anggrek No. 123...">{{ old('alamat_ayah') }}</textarea></div></div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Ibu -->
                <div class="card border-danger mb-3">
                    <div class="card-header py-2 bg-danger text-white d-flex justify-content-between align-items-center">
                        <strong><i class="fas fa-map-location mr-1"></i> Alamat Domisili Ibu</strong>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cb_ibu_sama_ayah">
                            <label class="custom-control-label small" for="cb_ibu_sama_ayah">Sama dengan Ayah</label>
                        </div>
                    </div>
                    <div class="card-body py-3" id="form-alamat-ibu">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_ibu" id="provinsi_ibu" class="form-control form-control-sm" data-old="{{ old('provinsi_ibu') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_ibu" id="kabupaten_ibu" class="form-control form-control-sm" data-old="{{ old('kabupaten_ibu') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_ibu" id="kecamatan_ibu" class="form-control form-control-sm" data-old="{{ old('kecamatan_ibu') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_ibu" id="desa_ibu" class="form-control form-control-sm" data-old="{{ old('desa_ibu') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_ibu" id="rt_ibu" class="form-control form-control-sm" value="{{ old('rt_ibu') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_ibu" id="rw_ibu" class="form-control form-control-sm" value="{{ old('rw_ibu') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_ibu" id="kode_pos_ibu" class="form-control form-control-sm" value="{{ old('kode_pos_ibu') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Status Tempat</label><select name="status_kepemilikan_ibu" id="status_kepemilikan_ibu" class="form-control form-control-sm"><option value="">-- Pilih --</option>@foreach(['Milik Sendiri','Kontrak/Sewa','Menumpang','Lainnya'] as $sk)<option value="{{ $sk }}" {{ old('status_kepemilikan_ibu') == $sk ? 'selected' : '' }}>{{ $sk }}</option>@endforeach</select></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="2">{{ old('alamat_ibu') }}</textarea></div></div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Santri -->
                <div class="card border-success mb-3">
                    <div class="card-header py-2 bg-success text-white d-flex justify-content-between align-items-center">
                        <strong><i class="fas fa-house-chimney-user mr-1"></i> Alamat Domisili Santri</strong>
                        {{-- <div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input cb-santri-sync" id="cb_santri_sama_ayah" value="ayah">
                                <label class="custom-control-label small" for="cb_santri_sama_ayah">Sama dg Ayah</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input cb-santri-sync" id="cb_santri_sama_ibu" value="ibu">
                                <label class="custom-control-label small" for="cb_santri_sama_ibu">Sama dg Ibu</label>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body py-3" id="form-alamat-santri">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group"><label class="small">Provinsi</label><select name="provinsi_santri" id="provinsi_santri" class="form-control form-control-sm" data-old="{{ old('provinsi_santri') }}"><option value="">-- Pilih Provinsi --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kabupaten / Kota</label><select name="kabupaten_santri" id="kabupaten_santri" class="form-control form-control-sm" data-old="{{ old('kabupaten_santri') }}"><option value="">-- Pilih Kabupaten --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Kecamatan</label><select name="kecamatan_santri" id="kecamatan_santri" class="form-control form-control-sm" data-old="{{ old('kecamatan_santri') }}"><option value="">-- Pilih Kecamatan --</option></select></div></div>
                            <div class="col-md-3"><div class="form-group"><label class="small">Desa / Kelurahan</label><select name="desa_santri" id="desa_santri" class="form-control form-control-sm" data-old="{{ old('desa_santri') }}"><option value="">-- Pilih Desa --</option></select></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RT</label><input type="text" name="rt_santri" id="rt_santri" class="form-control form-control-sm" value="{{ old('rt_santri') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">RW</label><input type="text" name="rw_santri" id="rw_santri" class="form-control form-control-sm" value="{{ old('rw_santri') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Kode Pos</label><input type="text" name="kode_pos_santri" id="kode_pos_santri" class="form-control form-control-sm" value="{{ old('kode_pos_santri') }}"></div></div>
                            <div class="col-md-2"><div class="form-group"><label class="small">Koordinat</label><input type="text" name="koordinat" id="koordinat" class="form-control form-control-sm" value="{{ old('koordinat') }}" placeholder="-7.123, 110.45"></div></div>
                            <div class="col-md-12"><div class="form-group"><label class="small">Jalan / Alamat Detail</label><textarea name="alamat_santri" id="alamat_santri" class="form-control" rows="2">{{ old('alamat_santri') }}</textarea></div></div>
                        </div>
                        <div class="row border-top pt-3 mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Status Mukim di Pesantren</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_mukim" id="mukim" value="Mukim" {{ old('status_mukim')=='Mukim'?'checked':'' }}>
                                            <label class="form-check-label" for="mukim"><span class="text-success font-weight-bold">Mukim</span></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_mukim" id="pulper" value="Tidak Mukim" {{ old('status_mukim')=='Tidak Mukim'?'checked':'' }}>
                                            <label class="form-check-label" for="pulper"><span class="text-warning font-weight-bold">Pulang Pergi</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small">Tinggal Bersama</label>
                                    <select name="status_tempat_tinggal" class="form-control form-control-sm">
                                        @foreach(['Orang Tua','Wali / Keluarga','Asrama Pesantren','Kost / Kontrakan'] as $st)
                                        <option value="{{ $st }}" {{ old('status_tempat_tinggal')==$st?'selected':'' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transportasi -->
                <div class="card border-warning mb-3">
                    <div class="card-header py-2 bg-warning"><strong><i class="fas fa-car mr-1"></i> Akses &amp; Transportasi ke Lembaga</strong></div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Moda Transportasi</label>
                                    <select name="transportasi" class="form-control form-control-sm">
                                        @foreach(['Jalan Kaki','Sepeda','Sepeda Motor','Mobil Pribadi','Angkutan Umum'] as $tr)
                                        <option value="{{ $tr }}">{{ $tr }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Jarak Tempuh</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="jarak_ke_lembaga" class="form-control" value="{{ old('jarak_ke_lembaga') }}" placeholder="Jarak">
                                        <div class="input-group-append"><span class="input-group-text">Km</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small">Waktu Tempuh</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="waktu_tempuh" class="form-control" value="{{ old('waktu_tempuh') }}" placeholder="Waktu">
                                        <div class="input-group-append"><span class="input-group-text">Menit</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav Alamat -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-simpan-lanjut" data-step="alamat" data-next="tab-wali">
                        <i class="fas fa-arrow-right mr-1"></i> Simpan &amp; Lanjutkan
                    </button>
                </div>
            </div>

            <!-- TAB: Upload Foto -->
            <div class="tab-pane fade" id="tab-foto" role="tabpanel">
                <h6 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-camera mr-1"></i> Upload Berkas Foto
                </h6>
                <div class="alert alert-info py-2 mb-3">
                    <i class="fas fa-circle-info mr-1"></i>
                    Upload <strong>foto 3x4</strong> santri dan <strong>foto Kartu Keluarga (KK)</strong>. Maksimal ukuran file <strong>2 MB</strong> per foto (format: JPG, PNG, JPEG).
                    <br><i class="fas fa-scissors mr-1 text-warning"></i> <strong>Perhatian:</strong> Setelah memilih foto, akan muncul jendela untuk menyesuaikan ukuran sebelum disimpan.
                </div>

                <div class="row">
                    <!-- Foto 3x4 (Portrait) -->
                    <div class="col-md-5">
                        <div class="card border mb-3">
                            <div class="card-header py-2 bg-primary text-white d-flex align-items-center gap-2">
                                <strong><i class="fas fa-portrait mr-1"></i> Foto 3x4 Santri</strong>
                                <span class="badge badge-light ml-auto" style="font-size:.7rem;">Rasio 3 : 4</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="preview-foto3x4" class="mb-3 d-flex align-items-center justify-content-center"
                                     style="height:160px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:8px;">
                                    <span class="text-muted small"><i class="fas fa-image fa-2x d-block mb-1"></i>Preview foto 3×4</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto_3x4" name="foto_3x4" accept="image/*">
                                    <label class="custom-file-label" for="foto_3x4">Pilih foto 3x4...</label>
                                </div>
                                <small class="text-muted d-block mt-1">Maks. 2 MB &bull; JPG/PNG/JPEG &bull; Akan dicrop otomatis</small>
                            </div>
                        </div>
                    </div>
                    <!-- Foto KK (Landscape) -->
                    <div class="col-md-7">
                        <div class="card border mb-3">
                            <div class="card-header py-2 bg-success text-white d-flex align-items-center">
                                <strong><i class="fas fa-id-card mr-1"></i> Foto Kartu Keluarga (KK)</strong>
                                <span class="badge badge-light ml-auto" style="font-size:.7rem;">Landscape / Lebar</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="preview-fotokk" class="mb-3 d-flex align-items-center justify-content-center"
                                     style="height:160px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:8px;">
                                    <span class="text-muted small"><i class="fas fa-image fa-2x d-block mb-1"></i>Preview foto KK</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" accept="image/*">
                                    <label class="custom-file-label" for="foto_kk">Pilih foto KK...</label>
                                </div>
                                <small class="text-muted d-block mt-1">Maks. 2 MB &bull; JPG/PNG/JPEG &bull; Akan dicrop otomatis</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="foto-error" class="alert alert-danger d-none"></div>

                <!-- Nav Foto -->
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" id="btn-ke-preview" class="btn btn-success">
                        <i class="fas fa-eye mr-1"></i> Simpan Foto &amp; Lihat Preview
                    </button>
                </div>
            </div>

            <!-- TAB: Preview & Simpan -->
            <div class="tab-pane fade" id="tab-preview" role="tabpanel">
                <div id="preview-content-container">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>Memuat data preview...</p>
                    </div>
                </div>
            </div>

        <!-- Form Actions -->
        <div class="border-top pt-3 d-flex justify-content-between align-items-center">
            <small class="text-muted"><i class="fas fa-circle-info mr-1 text-primary"></i> Pastikan semua data bertanda (*) telah terisi.</small>
            <div>
                <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-times mr-1"></i> Batalkan
                </a>
            </div>
        </div>
    </div>
</div>

</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const saveStepUrl = '{{ route("admin.santri.saveStep") }}';
    const previewUrl  = '{{ route("admin.santri.preview") }}';
    const csrfToken   = '{{ csrf_token() }}';

    // â”€â”€ Image file preview â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    function setupFilePreview(inputId, previewId, labelText) {
        var input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('change', function() {
            var label = input.nextElementSibling;
            if (this.files && this.files[0]) {
                var file = this.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    alert('File ' + labelText + ' melebihi batas 2 MB!');
                    this.value = '';
                    if (label) label.textContent = 'Pilih ' + labelText + '...';
                    return;
                }
                if (label) label.textContent = file.name;
                var reader = new FileReader();
                reader.onload = function(e) {
                    var prev = document.getElementById(previewId);
                    prev.innerHTML = '<img src="' + e.target.result + '" style="max-height:200px;max-width:100%;border-radius:6px;">';
                };
                reader.readAsDataURL(file);
            }
        });
    }
    setupFilePreview('foto_3x4', 'preview-foto3x4', 'foto 3x4');
    setupFilePreview('foto_kk',  'preview-fotokk',  'foto KK');

    // â”€â”€ Collect form data for a step â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    function collectStep(step) {
        var fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('step',   step);
        document.getElementById('formSantri').querySelectorAll('input,select,textarea').forEach(function(el) {
            if (!el.name) return;
            if (el.type === 'radio'    && !el.checked) return;
            if (el.type === 'checkbox' && !el.checked) return;
            if (el.type === 'file')    return;
            fd.append(el.name, el.value);
        });
        return fd;
    }

    // â”€â”€ Switch bootstrap tab â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    function goToTab(tabId) {
        var tabEl = document.querySelector('#formTabs a[href="#' + tabId + '"]');
        if (tabEl) $(tabEl).tab('show');
    }

    // â”€â”€ "Simpan & Lanjutkan" text-tab buttons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.querySelectorAll('.btn-simpan-lanjut').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var step    = btn.getAttribute('data-step');
            var nextTab = btn.getAttribute('data-next');
            var orig    = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Menyimpan...';
            btn.disabled  = true;
            fetch(saveStepUrl, { method: 'POST', body: collectStep(step) })
                .then(function(r) { return r.json(); })
                .then(function(d) { if (d.success) goToTab(nextTab); else alert('Gagal menyimpan.'); })
                .catch(function() { alert('Terjadi kesalahan koneksi.'); })
                .finally(function() { btn.innerHTML = orig; btn.disabled = false; });
        });
    });

    // â”€â”€ "Simpan Foto & Lihat Preview" button â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    document.getElementById('btn-ke-preview').addEventListener('click', function() {
        var btn = this;
        var errorDiv = document.getElementById('foto-error');
        errorDiv.classList.add('d-none');
        var fd = new FormData();
        fd.append('_token', csrfToken);
        fd.append('step',   'foto');
        var f3 = document.getElementById('foto_3x4');
        var fk = document.getElementById('foto_kk');
        if (f3 && f3.files[0]) fd.append('foto_3x4', f3.files[0]);
        if (fk && fk.files[0]) fd.append('foto_kk',  fk.files[0]);
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Menyimpan...';
        btn.disabled  = true;
        fetch(saveStepUrl, { method: 'POST', body: fd })
            .then(function(r) {
                if (!r.ok) return r.json().then(function(e) { throw e; });
                return r.json();
            })
            .then(function(d) {
                if (d.success) {
                    // Aktifkan tab preview
                    var pTab = document.getElementById('tab-preview-tab');
                    pTab.style.pointerEvents = 'auto';
                    pTab.style.opacity = '1';
                    $(pTab).tab('show');

                    // Ambil konten HTML preview
                    fetch(previewUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('preview-content-container').innerHTML = html;
                        })
                        .catch(err => {
                            document.getElementById('preview-content-container').innerHTML = '<div class="alert alert-danger">Gagal memuat preview.</div>';
                        });

                } else { 
                    errorDiv.textContent = 'Gagal menyimpan foto.'; 
                    errorDiv.classList.remove('d-none'); 
                }
            })
            .catch(function(err) {
                var msg = (err && err.errors) ? Object.values(err.errors).flat().join(' ') : 'Terjadi kesalahan.';
                errorDiv.textContent = msg;
                errorDiv.classList.remove('d-none');
            })
            .finally(function() {
                btn.innerHTML = '<i class="fas fa-eye mr-1"></i> Simpan Foto &amp; Lihat Preview';
                btn.disabled  = false;
            });
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

    // ── Address Sync Logic ──────────────────────────────────────────────────
    const addrFields = ['alamat', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'status_kepemilikan'];
    function syncFields(srcPrefix, dstPrefix, lock) {
        addrFields.forEach(function(f) {
            var s = document.getElementById(f + '_' + srcPrefix);
            var d = document.getElementById(f + '_' + dstPrefix);
            if (!d) return;
            if (lock && s) {
                if (s.tagName === 'SELECT' && d.tagName === 'SELECT') {
                    d.innerHTML = s.innerHTML;
                }
                d.value = s.value;
                if (d.tagName === 'SELECT') {
                    d.style.pointerEvents = 'none';
                    d.classList.add('bg-light');
                } else {
                    d.readOnly = true;
                    d.classList.add('bg-light');
                }
            } else if (!lock) {
                if (d.tagName === 'SELECT') {
                    d.style.pointerEvents = 'auto';
                    d.classList.remove('bg-light');
                } else {
                    d.readOnly = false;
                    d.classList.remove('bg-light');
                }
            }
        });
    }
    document.getElementById('cb_ibu_sama_ayah').addEventListener('change', function() {
        syncFields('ayah', 'ibu', this.checked);
    });
    document.querySelectorAll('.cb-santri-sync').forEach(function(cb) {
        cb.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.cb-santri-sync').forEach(function(o) { if (o !== cb) o.checked = false; });
                syncFields(cb.value, 'santri', true);
            } else { syncFields('', 'santri', false); }
        });
    });
    document.querySelectorAll('.cb-alamat-wali-sync').forEach(function(cb) {
        cb.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.cb-alamat-wali-sync').forEach(function(o) { if (o !== cb) o.checked = false; });
                syncFields(cb.value, 'wali', true);
            } else { syncFields('', 'wali', false); }
        });
    });

    // ── Wali sync ──────────────────────────────────────────────────────────
    const waliMap = {
        'nama_lengkap_': 'nama_lengkap_wali', 'no_hp_': 'no_hp_wali', 'nik_': 'nik_wali',
        'kewarganegaraan_': 'kewarganegaraan_wali', 'tempat_lahir_': 'tempat_lahir_wali',
        'tanggal_lahir_': 'tanggal_lahir_wali', 'pendidikan_terakhir_': 'pendidikan_terakhir_wali',
        'pekerjaan_utama_': 'pekerjaan_utama_wali', 'penghasilan_perbulan_': 'penghasilan_perbulan_wali',
        'alamat_': 'alamat_wali', 'rt_': 'rt_wali', 'rw_': 'rw_wali', 'desa_': 'desa_wali',
        'kecamatan_': 'kecamatan_wali', 'kabupaten_': 'kabupaten_wali', 'provinsi_': 'provinsi_wali',
        'kode_pos_': 'kode_pos_wali', 'status_kepemilikan_': 'status_kepemilikan_wali'
    };
    function syncWali(srcPrefix, lock) {
        Object.entries(waliMap).forEach(function(pair) {
            var srcId = pair[0] + srcPrefix;
            var dstId = pair[1];
            var s = document.getElementById(srcId);
            var d = document.getElementById(dstId);
            if (!d) return;
            if (lock && s) {
                var srcVal = s.value;
                if (s.tagName === 'SELECT' && d.tagName === 'INPUT') {
                    d.value = s.options[s.selectedIndex] ? s.options[s.selectedIndex].value : '';
                } else if (d.tagName === 'SELECT') {
                    if (s.tagName === 'SELECT') d.innerHTML = s.innerHTML;
                    d.value = srcVal;
                    if (d.value !== srcVal) {
                        for (var i = 0; i < d.options.length; i++) {
                            if (d.options[i].value === srcVal) {
                                d.selectedIndex = i;
                                break;
                            }
                        }
                    }
                    d.style.pointerEvents = 'none';
                    d.classList.add('bg-light');
                } else {
                    d.value = srcVal;
                }
                if (d.tagName !== 'SELECT') {
                    d.readOnly = true;
                    d.classList.add('bg-light');
                }
            } else {
                if (d.tagName === 'SELECT') {
                    d.style.pointerEvents = 'auto';
                    d.classList.remove('bg-light');
                } else {
                    d.readOnly = false;
                    d.classList.remove('bg-light');
                }
            }
        });
    }
    document.querySelectorAll('.cb-wali-sync').forEach(function(cb) {
        cb.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.cb-wali-sync').forEach(function(o) { if (o !== cb) o.checked = false; });
                syncWali(cb.value, true);
            } else { syncWali(cb.value, false); }
        });
    });

    // Re-enable disabled selects sebelum submit agar value ikut terkirim
    document.getElementById('formSantri').addEventListener('submit', function() {
        document.querySelectorAll('#form-wali-manual select[disabled]').forEach(function(sel) {
            sel.disabled = false;
        });
    });

    // Live sync
    addrFields.forEach(function(f) {
        var ayahEl = document.getElementById(f + '_ayah');
        var ibuEl  = document.getElementById(f + '_ibu');
        if (ayahEl) ayahEl.addEventListener('input', function() {
            if (document.getElementById('cb_ibu_sama_ayah').checked) syncFields('ayah', 'ibu', true);
            var as = document.querySelector('.cb-santri-sync:checked');
            if (as && as.value === 'ayah') syncFields('ayah', 'santri', true);
        });
        if (ibuEl) ibuEl.addEventListener('input', function() {
            var as = document.querySelector('.cb-santri-sync:checked');
            if (as && as.value === 'ibu') syncFields('ibu', 'santri', true);
        });
    });

    // ── Final Submit dari Tab Preview (Event Delegation) ───────────────────
    document.addEventListener('click', function(e) {
        var finalBtn = e.target.closest('#btnStoreFinalModal');
        if (finalBtn) {
            e.preventDefault();
            if(!confirm('Apakah Anda yakin semua data sudah benar? Proses ini akan menyimpan data secara permanen dan membuat akun Wali.')) {
                return false;
            }
            
            finalBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Menyimpan...';
            finalBtn.disabled = true;

            // Build dynamic form to avoid nesting inside formSantri
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route("admin.santri.storeFinal") }}';
            
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            
            f.appendChild(csrfInput);
            document.body.appendChild(f);
            f.submit();
        }
    });

    /* ── Daftarkan Crop Input setelah semua JS dimuat ── */
    window.addEventListener('load', function () {
        if (typeof registerCropInput === 'function') {
            registerCropInput('foto_3x4', '#preview-foto3x4', 'foto');
            registerCropInput('foto_kk',  '#preview-fotokk',  'kk');
        }
    });

});
</script>
@endpush

{{-- Crop Modal Partial --}}
@include('partials._crop_modal')

@endsection
