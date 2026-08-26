@extends('layouts.admin')

@section('title', 'Detail Santri')
@section('page-title', 'Profil Lengkap Santri')
@section('page-subtitle', 'Informasi terperinci mencakup identitas, keluarga, dan akomodasi')

@section('content')

@php
    $ds = $santri->dataSantri;
    $da = $santri->dataAyah;
    $di = $santri->dataIbu;
    $dw = $santri->dataWali;
    $as = $santri->alamatSantri;
    $statusColor = ['aktif'=>'success','lulus'=>'info','keluar'=>'danger','tidak aktif'=>'secondary'];
    $badgeColor = $statusColor[$santri->status_data] ?? 'secondary';
@endphp

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Santri</h1>
    <div>
        <a href="{{ route('admin.santri.edit', $santri->id) }}" class="btn btn-warning btn-sm shadow-sm mr-2">
            <i class="fas fa-pen fa-sm mr-1"></i> Edit Data
        </a>
        <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>
</div>

<!-- Profile Header Card -->
<div class="card shadow border-left-primary mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                @if(!empty($ds->foto_3x4))
                    <img src="{{ asset('storage/berkas/' . $ds->foto_3x4) }}" 
                         alt="Foto Santri"
                         class="rounded-circle shadow"
                         style="width:80px;height:80px;object-fit:cover;border:3px solid #fff;">
                @else
                    <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center shadow"
                         style="width:80px;height:80px;color:#fff;font-weight:800;font-size:2rem;">
                        {{ strtoupper(substr($ds->nama_lengkap ?? '?', 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="col">
                <h2 class="h4 font-weight-bold text-dark mb-1">
                    {{ $ds->nama_lengkap ?? 'Nama Belum Diisi' }}
                    <span class="badge badge-{{ $badgeColor }} ml-2">{{ ucfirst($santri->status_data) }}</span>
                </h2>
                <div class="d-flex flex-wrap text-muted small" style="gap: 1rem;">
                    <span><i class="fas fa-id-badge fa-fw mr-1"></i>NIS: #{{ str_pad($santri->id, 4, '0', STR_PAD_LEFT) }}</span>
                    @if($ds->nik)<span><i class="fas fa-credit-card fa-fw mr-1"></i>NIK: {{ $ds->nik }}</span>@endif
                    @if($ds->no_hp)<span><i class="fas fa-phone fa-fw mr-1"></i>{{ $ds->no_hp }}</span>@endif
                    @if($ds->email)<span><i class="fas fa-envelope fa-fw mr-1"></i>{{ $ds->email }}</span>@endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Kolom Kiri -->
    <div class="col-lg-4">

        <!-- Informasi Personal -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clipboard-user mr-1"></i> Informasi Personal
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-borderless mb-0">
                    <tr class="border-bottom">
                        <td class="text-muted pl-3" style="width:45%"><small>TTL</small></td>
                        <td class="small">{{ $ds->tempat_lahir ?? '-' }}, {{ $ds->tanggal_lahir ? date('d M Y', strtotime($ds->tanggal_lahir)) : '-' }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="text-muted pl-3"><small>Jenis Kelamin & Agama</small></td>
                        <td class="small">{{ $ds->jenis_kelamin ?? '-' }} &bull; {{ $ds->agama ?? '-' }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="text-muted pl-3"><small>Tahun Masuk</small></td>
                        <td class="small">{{ $ds->tahun_masuk ?? '-' }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="text-muted pl-3"><small>Cita-cita & Hobi</small></td>
                        <td class="small">{{ $ds->cita_cita ?? '-' }} &bull; {{ $ds->hobi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted pl-3"><small>Susunan Keluarga</small></td>
                        <td class="small">Anak ke-{{ $ds->anak_ke ?? '?' }} dari {{ $ds->jumlah_saudara ?? '?' }} bersaudara</td>
                    </tr>
                    @if($ds->kebutuhan_khusus || $ds->kebutuhan_disabilitas)
                    <tr>
                        <td colspan="2" class="p-0">
                            <div class="alert alert-danger m-2 py-2 small">
                                <strong><i class="fas fa-notes-medical mr-1"></i> Catatan Medis:</strong><br>
                                {{ $ds->kebutuhan_khusus ?? '-' }}<br>
                                {{ $ds->kebutuhan_disabilitas ?? '' }}
                            </div>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Akun Perwalian -->
        <div class="card bg-dark text-white shadow mb-4">
            <div class="card-header py-3 bg-dark border-bottom border-secondary">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-user-shield mr-1"></i> Akun Perwalian
                </h6>
            </div>
            <div class="card-body">
                @if($santri->wali)
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                             style="width:44px;height:44px;font-weight:700;font-size:1.1rem;">
                            {{ strtoupper(substr($santri->wali->nama_wali, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-weight-bold">{{ $santri->wali->nama_wali }}</div>
                            <small class="text-success">Terhubung sebagai Wali</small>
                        </div>
                    </div>
                    <p class="small text-secondary mb-1"><i class="fas fa-phone fa-fw mr-1"></i>{{ $santri->wali->no_hp ?? '-' }}</p>
                    <p class="small text-secondary mb-0"><i class="fas fa-location-dot fa-fw mr-1"></i>{{ $santri->wali->alamat ?? '-' }}</p>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-triangle-exclamation fa-2x text-warning mb-2 d-block"></i>
                        <p class="font-weight-bold mb-1">Wali Belum Terhubung</p>
                        <small class="text-muted d-block mb-2">Santri ini belum memiliki akun wali.</small>
                        <a href="{{ route('admin.santri.edit', $santri->id) }}" class="btn btn-warning btn-sm">
                            Setting Perwalian &rarr;
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Kolom Kanan -->
    <div class="col-lg-8">

        <!-- Alamat & Akomodasi -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-house-chimney mr-1"></i> Alamat &amp; Akomodasi Santri
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted small font-weight-bold text-uppercase mb-2">Status Tempat Tinggal</p>
                        <span class="badge badge-secondary mr-1">{{ $as->status_mukim ?? '-' }}</span>
                        <span class="badge badge-secondary">{{ $as->status_tempat_tinggal ?? '-' }}</span>
                        <p class="text-muted small font-weight-bold text-uppercase mb-1 mt-3">Alamat Lengkap</p>
                        <div class="bg-light rounded p-2 small">
                            {{ $as->alamat ?? '-' }}<br>
                            RT {{ $as->rt ?? '-' }} / RW {{ $as->rw ?? '-' }}, Desa {{ $as->desa ?? '-' }}<br>
                            Kec. {{ $as->kecamatan ?? '-' }}, {{ $as->kabupaten ?? '-' }}<br>
                            {{ $as->provinsi ?? '-' }} {{ $as->kode_pos ?? '' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small font-weight-bold text-uppercase mb-2">Pembiaya Pendidikan</p>
                        <p class="font-weight-bold">{{ $ds->pembiaya_sekolah ?? '-' }}</p>
                        <div class="alert alert-success py-2 small mt-2">
                            <strong><i class="fas fa-route mr-1"></i> Akses Transportasi</strong>
                            <table class="table table-sm table-borderless mb-0 mt-1">
                                <tr><td class="text-muted p-0">Moda</td><td class="p-0">{{ $as->transportasi ?? '-' }}</td></tr>
                                <tr><td class="text-muted p-0">Jarak</td><td class="p-0">{{ $as->jarak_ke_lembaga ?? '-' }} Km</td></tr>
                                <tr><td class="text-muted p-0">Waktu Tempuh</td><td class="p-0">{{ $as->waktu_tempuh ?? '-' }} Menit</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua & Wali -->
        <div class="row">
            <!-- Data Ayah -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-2"
                             style="width:26px;height:26px;color:#fff;font-size:0.7rem;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h6 class="m-0 font-weight-bold text-primary">Detail Ayah</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="px-3 py-2 border-bottom">
                            <div class="font-weight-bold">{{ $da->nama_lengkap ?? '-' }}</div>
                            <span class="badge badge-primary badge-sm">{{ $da->status ?? '-' }}</span>
                        </div>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted pl-3 small" style="width:45%">NIK</td><td class="small"><code>{{ $da->nik ?? '-' }}</code></td></tr>
                            <tr><td class="text-muted pl-3 small">TTL</td><td class="small">{{ $da->tempat_lahir ?? '-' }}, {{ $da->tanggal_lahir ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">No. HP</td><td class="small">{{ $da->no_hp ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Pendidikan</td><td class="small">{{ $da->pendidikan_terakhir ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Pekerjaan</td><td class="small">{{ $da->pekerjaan_utama ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Penghasilan</td><td class="small">Rp {{ $da->penghasilan_perbulan ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Data Ibu -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center mr-2"
                             style="width:26px;height:26px;color:#fff;font-size:0.7rem;">
                            <i class="fas fa-person-dress"></i>
                        </div>
                        <h6 class="m-0 font-weight-bold text-danger">Detail Ibu</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="px-3 py-2 border-bottom">
                            <div class="font-weight-bold">{{ $di->nama_lengkap ?? '-' }}</div>
                            <span class="badge badge-danger badge-sm">{{ $di->status ?? '-' }}</span>
                        </div>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted pl-3 small" style="width:45%">NIK</td><td class="small"><code>{{ $di->nik ?? '-' }}</code></td></tr>
                            <tr><td class="text-muted pl-3 small">TTL</td><td class="small">{{ $di->tempat_lahir ?? '-' }}, {{ $di->tanggal_lahir ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">No. HP</td><td class="small">{{ $di->no_hp ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Pendidikan</td><td class="small">{{ $di->pendidikan_terakhir ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Pekerjaan</td><td class="small">{{ $di->pekerjaan_utama ?? '-' }}</td></tr>
                            <tr><td class="text-muted pl-3 small">Penghasilan</td><td class="small">Rp {{ $di->penghasilan_perbulan ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Data Wali -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex align-items-center">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center mr-2"
                             style="width:26px;height:26px;color:#fff;font-size:0.7rem;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h6 class="m-0 font-weight-bold text-warning">Detail Wali</h6>
                    </div>
                    <div class="card-body p-0">
                        @if($dw)
                            <div class="px-3 py-2 border-bottom">
                                <div class="font-weight-bold">{{ $dw->nama_lengkap ?? '-' }}</div>
                                <span class="badge badge-warning badge-sm">{{ $dw->status ?? '-' }}</span>
                            </div>
                            <table class="table table-sm table-borderless mb-0">
                                <tr><td class="text-muted pl-3 small" style="width:45%">NIK</td><td class="small"><code>{{ $dw->nik ?? '-' }}</code></td></tr>
                                <tr><td class="text-muted pl-3 small">TTL</td><td class="small">{{ $dw->tempat_lahir ?? '-' }}, {{ $dw->tanggal_lahir ?? '-' }}</td></tr>
                                <tr><td class="text-muted pl-3 small">No. HP</td><td class="small">{{ $dw->no_hp ?? '-' }}</td></tr>
                                <tr><td class="text-muted pl-3 small">Pendidikan</td><td class="small">{{ $dw->pendidikan_terakhir ?? '-' }}</td></tr>
                                <tr><td class="text-muted pl-3 small">Pekerjaan</td><td class="small">{{ $dw->pekerjaan_utama ?? '-' }}</td></tr>
                                <tr><td class="text-muted pl-3 small">Penghasilan</td><td class="small">Rp {{ $dw->penghasilan_perbulan ?? '-' }}</td></tr>
                                @if($dw->alamat)
                                <tr>
                                    <td colspan="2" class="pl-3 pb-2">
                                        <small class="text-muted font-weight-bold"><i class="fas fa-map-pin mr-1"></i>Alamat:</small><br>
                                        <small>{{ $dw->alamat->alamat ?? '-' }},
                                        RT {{ $dw->alamat->rt ?? '-' }}/RW {{ $dw->alamat->rw ?? '-' }},
                                        {{ $dw->alamat->desa ?? '-' }},
                                        {{ $dw->alamat->kecamatan ?? '-' }},
                                        {{ $dw->alamat->kabupaten ?? '-' }}</small>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted mb-2 d-block"></i>
                                <small class="text-muted">Data wali belum diisi.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Berkas dan Arsip -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-folder-open mr-1"></i> Arsip &amp; Berkas Foto
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="font-weight-bold mb-2">Foto Kartu Keluarga (KK)</p>
                        @if(!empty($ds->foto_kk))
                            <a href="{{ asset('storage/berkas/' . $ds->foto_kk) }}" target="_blank">
                                <img src="{{ asset('storage/berkas/' . $ds->foto_kk) }}" class="img-fluid rounded border shadow-sm" style="max-height:300px;object-fit:cover;" alt="Foto KK">
                            </a>
                            <p class="small text-muted mt-2"><i class="fas fa-search-plus mr-1"></i>Klik gambar untuk memperbesar</p>
                        @else
                            <div class="alert alert-secondary py-3 text-center mb-0">
                                <i class="fas fa-image fa-2x text-muted mb-2 d-block"></i>
                                Tidak ada arsip Foto KK yang diunggah.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
