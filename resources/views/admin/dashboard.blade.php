@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data santri dan metrik penting pesantren')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Overview Sistem</h1>
    <a href="{{ route('admin.santri.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-user-plus fa-sm text-white-50 mr-1"></i> Tambah Santri Baru
    </a>
</div>


<!-- Content Row: Stat Cards -->
<div class="row">

    <!-- Total Santri Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Santri</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Santri Aktif Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Santri Aktif</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $stats['aktif'] }}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $stats['total'] > 0 ? ($stats['aktif'] / $stats['total'] * 100) : 0 }}%"
                                         aria-valuenow="{{ $stats['aktif'] }}" aria-valuemin="0" aria-valuemax="{{ $stats['total'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['aktif'] / $stats['total']) * 100) : 0 }}% dari total
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-circle-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alumni Lulus Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumni Lulus</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $stats['lulus'] }}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         style="width: {{ $stats['total'] > 0 ? ($stats['lulus'] / $stats['total'] * 100) : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-muted mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['lulus'] / $stats['total']) * 100) : 0 }}% dari total
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Akun Wali Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Akun Wali Santri</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['wali'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row: Kelengkapan Data -->
<div class="row mb-2">

    <!-- Data Sudah Lengkap Card (Clickable) -->
    <div class="col-xl-6 col-md-6 mb-4">
        <a href="#" data-toggle="modal" data-target="#modalDataLengkap" style="text-decoration:none;display:block;height:100%;">
        <div class="card h-100 py-2 shadow" style="border-left: 0.25rem solid {{ $stats['lengkap'] > 0 ? '#1cc88a' : '#cbd5e0' }};{{ $stats['lengkap'] > 0 ? 'cursor:pointer;' : '' }}">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: {{ $stats['lengkap'] > 0 ? '#1cc88a' : '#cbd5e0' }}">
                            Data Sudah Dilengkapi Wali
                            @if($stats['lengkap'] > 0)
                            <span class="ml-1 badge badge-success" style="font-size:0.6rem;"><i class="fas fa-hand-pointer"></i> Klik</span>
                            @endif
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $stats['lengkap'] }}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $stats['total'] > 0 ? ($stats['lengkap'] / $stats['total'] * 100) : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs mt-1">
                            @if($stats['lengkap'] > 0)
                                <span class="text-success">Klik untuk melihat daftar santri &raquo;</span>
                            @else
                                <span class="text-muted">Belum ada data santri yang lengkap.</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <!-- Data Belum Lengkap Card (Clickable) -->
    <div class="col-xl-6 col-md-6 mb-4">
        <a href="#" data-toggle="modal" data-target="#modalDataBelumLengkap" style="text-decoration:none;display:block;height:100%;">
        <div class="card h-100 py-2 shadow" style="border-left: 0.25rem solid {{ $stats['belum_lengkap'] > 0 ? '#e74a3b' : '#1cc88a' }};{{ $stats['belum_lengkap'] > 0 ? 'cursor:pointer;' : '' }}">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: {{ $stats['belum_lengkap'] > 0 ? '#e74a3b' : '#1cc88a' }}">
                            Data Belum Dilengkapi Wali
                            @if($stats['belum_lengkap'] > 0)
                            <span class="ml-1 badge badge-danger" style="font-size:0.6rem;"><i class="fas fa-hand-pointer"></i> Klik</span>
                            @endif
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold {{ $stats['belum_lengkap'] > 0 ? 'text-danger' : 'text-gray-800' }}">
                                    {{ $stats['belum_lengkap'] }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $stats['total'] > 0 ? ($stats['belum_lengkap'] / $stats['total'] * 100) : 0 }}%; background-color: {{ $stats['belum_lengkap'] > 0 ? '#e74a3b' : '#1cc88a' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs mt-1">
                            @if($stats['belum_lengkap'] > 0)
                                <span class="text-danger">Klik untuk lihat siapa saja yang belum melengkapi &raquo;</span>
                            @else
                                <span class="text-success"><i class="fas fa-check-circle mr-1"></i>Semua data sudah lengkap!</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-{{ $stats['belum_lengkap'] > 0 ? 'triangle-exclamation' : 'check-double' }} fa-2x" style="color: {{ $stats['belum_lengkap'] > 0 ? '#e74a3b' : '#cbd5e0' }}"></i>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

</div>

<!-- Content Row: Quick Actions & Distribusi -->
<div class="row">

    <!-- Quick Actions -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center">
                <i class="fas fa-bolt text-warning mr-2"></i>
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <p class="text-sm text-muted mb-4">Pilih menu di bawah ini untuk mengelola data dengan cepat.</p>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <a href="{{ route('admin.santri.create') }}"
                           class="btn btn-primary btn-icon-split btn-block py-3 shadow-sm">
                            <span class="icon text-white-50"><i class="fas fa-user-plus"></i></span>
                            <span class="text">Tambah Santri Baru</span>
                        </a>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <a href="{{ route('admin.wali.create') }}"
                           class="btn btn-warning btn-icon-split btn-block py-3 shadow-sm">
                            <span class="icon text-white-50"><i class="fas fa-address-book"></i></span>
                            <span class="text">Buat Akun Wali Baru</span>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.santri.index') }}"
                           class="btn btn-dark btn-icon-split btn-block py-3 shadow-sm">
                            <span class="icon text-white-50"><i class="fas fa-table-list"></i></span>
                            <span class="text">Lihat Database Santri Lengkap</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribusi Status -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center">
                <i class="fas fa-chart-bar text-primary mr-2"></i>
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Status</h6>
            </div>
            <div class="card-body">
                @php
                    $distribusi = [
                        ['label' => 'Aktif',      'val' => $stats['aktif'],      'color' => 'success'],
                        ['label' => 'Lulus',      'val' => $stats['lulus'],      'color' => 'info'],
                        ['label' => 'Keluar/DO',  'val' => $stats['keluar'],     'color' => 'danger'],
                        ['label' => 'Tidak Aktif','val' => $stats['tidak_aktif'],'color' => 'secondary'],
                    ];
                @endphp
                @foreach($distribusi as $st)
                @php $pct = $stats['total'] > 0 ? round(($st['val'] / $stats['total']) * 100) : 0; @endphp
                <h4 class="small font-weight-bold">
                    {{ $st['label'] }}
                    <span class="float-right">{{ $st['val'] }} <small class="text-muted">({{ $pct }}%)</small></span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-{{ $st['color'] }}" role="progressbar"
                         style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}"
                         aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>


<!-- Modal Data Belum Lengkap -->
<div class="modal fade" id="modalDataBelumLengkap" tabindex="-1" role="dialog" aria-labelledby="modalDataBelumLengkapLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title font-weight-bold text-dark" id="modalDataBelumLengkapLabel">
                    <i class="fas fa-list mr-2"></i> Daftar Santri (Data Belum Lengkap)
                    <span class="badge badge-dark font-weight-normal ml-2" style="font-size:0.7rem;">{{ $stats['belum_lengkap'] }} santri</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" id="tblBelumLengkap">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40px;" class="text-center text-muted">#</th>
                                <th>Nama Santri</th>
                                <th>Wali</th>
                                <th class="text-center" style="width:110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($santriBelumLengkap as $idx => $s)
                            <tr class="blp-row" data-index="{{ $idx }}">
                                <td class="text-center text-muted small align-middle">{{ $idx + 1 }}</td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-dark text-capitalize">{{ $s->dataSantri->nama_lengkap ?? 'Nama belum diisi' }}</div>
                                    <div class="text-muted small">NIS: #{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="align-middle">
                                    @if($s->wali)
                                        <div class="text-capitalize"><i class="fas fa-user-shield text-secondary mr-1"></i> {{ $s->wali->nama_wali }}</div>
                                    @else

                                        <span class="badge badge-warning">Belum ada wali</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('admin.santri.edit', $s->id) }}" class="btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-edit mr-1"></i> Lengkapi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-check-circle text-success fa-2x mb-2 d-block"></i>
                                    Semua data santri sudah lengkap.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="text-muted small" id="blpPageInfo"></div>
                    <div class="d-flex align-items-center" id="blpPagination" style="gap:6px;display:none!important;">
                        <button class="btn btn-sm btn-outline-secondary" id="blpPrev" onclick="blpChangePage(-1)" disabled>
                            <i class="fas fa-chevron-left"></i> Sebelumnya
                        </button>
                        <span class="text-muted small" id="blpPageNum" style="min-width:80px;text-align:center;"></span>
                        <button class="btn btn-sm btn-outline-secondary" id="blpNext" onclick="blpChangePage(1)">
                            Berikutnya <i class="fas fa-chevron-right"></i>
                        </button>
                        <a href="{{ route('admin.santri.index') }}" class="btn btn-sm btn-primary">Ke Data Santri</a>
                    </div>
                    <div id="blpPaginationHidden">
                        <a href="{{ route('admin.santri.index') }}" class="btn btn-sm btn-primary">Ke Halaman Data Santri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Data Lengkap -->
<div class="modal fade" id="modalDataLengkap" tabindex="-1" role="dialog" aria-labelledby="modalDataLengkapLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title font-weight-bold text-white" id="modalDataLengkapLabel">
                    <i class="fas fa-list mr-2"></i> Daftar Santri (Data Lengkap)
                    <span class="badge badge-light font-weight-normal text-success ml-2" style="font-size:0.7rem;">{{ $stats['lengkap'] }} santri</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <form action="{{ route('admin.dashboard.verify') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" id="tblLengkap">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px;" class="text-center text-muted">#</th>
                                    <th>Nama Santri</th>
                                    <th>Wali</th>
                                    <th>Tanggal Dilengkapi</th>
                                    <th class="text-center" style="width:70px;">Cek</th>
                                    <th class="text-center" style="width:110px;">Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($santriLengkap as $idx => $s)
                            <tr class="dlp-row" data-index="{{ $idx }}">
                                <td class="text-center text-muted small align-middle">{{ $idx + 1 }}</td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-dark text-capitalize">{{ $s->dataSantri->nama_lengkap ?? 'Nama belum diisi' }}</div>
                                    <div class="text-muted small">NIS: #{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                <td class="align-middle">
                                    @if($s->wali)
                                        <div class="text-capitalize"><i class="fas fa-user-shield text-secondary mr-1"></i> {{ $s->wali->nama_wali }}</div>
                                    @else
                                        <span class="badge badge-warning">Belum ada wali</span>
                                    @endif
                                </td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    <div class="text-muted small">
                                        <i class="far fa-calendar-check mr-1"></i>
                                        {{ $s->completed_at ? \Carbon\Carbon::parse($s->completed_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : 'Tidak diketahui' }}
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <input type="checkbox" name="verified_santri[]" value="{{ $s->id }}" {{ $s->is_verified ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#2ecc71;cursor:pointer;">
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('admin.santri.show', $s->id) }}" class="btn btn-sm btn-info shadow-sm">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-info-circle text-muted fa-2x mb-2 d-block"></i>
                                    Belum ada data santri yang lengkap.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="text-muted small" id="dlpPageInfo"></div>
                    <div class="d-flex align-items-center" id="dlpPagination" style="gap:6px;display:none!important;">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="dlpPrev" onclick="dlpChangePage(-1)" disabled>
                            <i class="fas fa-chevron-left"></i> Sebelumnya
                        </button>
                        <span class="text-muted small" id="dlpPageNum" style="min-width:80px;text-align:center;"></span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="dlpNext" onclick="dlpChangePage(1)">
                            Berikutnya <i class="fas fa-chevron-right"></i>
                        </button>
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                    </div>
                    <div id="dlpPaginationHidden">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save mr-1"></i> Simpan</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var PER_PAGE = 10;
    var currentPage = 0;

    function blpRender() {
        var rows = document.querySelectorAll('#tblBelumLengkap .blp-row');
        var total = rows.length;
        var totalPages = Math.ceil(total / PER_PAGE);
        var start = currentPage * PER_PAGE;
        var end   = start + PER_PAGE;

        rows.forEach(function(r, i) {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        var pag = document.getElementById('blpPagination');
        var pagHidden = document.getElementById('blpPaginationHidden');
        if (total > PER_PAGE) {
            if (pag) pag.style.cssText = 'display:flex!important;gap:6px;';
            if (pagHidden) pagHidden.style.display = 'none';
        } else {
            if (pag) pag.style.cssText = 'display:none!important;';
            if (pagHidden) pagHidden.style.display = '';
        }

        var prevBtn = document.getElementById('blpPrev');
        var nextBtn = document.getElementById('blpNext');
        var pageNum = document.getElementById('blpPageNum');
        if (prevBtn) prevBtn.disabled = currentPage === 0;
        if (nextBtn) nextBtn.disabled = currentPage >= totalPages - 1;
        if (pageNum) pageNum.textContent = totalPages > 1 ? 'Hal. ' + (currentPage + 1) + ' / ' + totalPages : '';

        var info = document.getElementById('blpPageInfo');
        if (info) {
            var showing = Math.min(end, total);
            info.innerHTML = 'Menampilkan <strong>' + (total > 0 ? (start + 1) : 0) + '&ndash;' + showing + '</strong> dari <strong>' + total + '</strong> santri &mdash; <em>Kriteria: data diri, ayah, ibu, wali &amp; seluruh alamat harus diisi.</em>';
        }
    }

    window.blpChangePage = function (dir) {
        var rows  = document.querySelectorAll('#tblBelumLengkap .blp-row');
        var total = rows.length;
        var totalPages = Math.ceil(total / PER_PAGE);
        currentPage = Math.max(0, Math.min(totalPages - 1, currentPage + dir));
        blpRender();
    };

    if (typeof $ !== 'undefined') {
        $('#modalDataBelumLengkap').on('show.bs.modal', function () {
            currentPage = 0;
            blpRender();
        });
    }

    document.addEventListener('DOMContentLoaded', function() { blpRender(); });
    blpRender();
})();

(function () {
    var PER_PAGE = 10;
    var currentPage = 0;

    function dlpRender() {
        var rows = document.querySelectorAll('#tblLengkap .dlp-row');
        var total = rows.length;
        var totalPages = Math.ceil(total / PER_PAGE);
        var start = currentPage * PER_PAGE;
        var end   = start + PER_PAGE;

        rows.forEach(function(r, i) {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });

        var pag = document.getElementById('dlpPagination');
        var pagHidden = document.getElementById('dlpPaginationHidden');
        if (total > PER_PAGE) {
            if (pag) pag.style.cssText = 'display:flex!important;gap:6px;';
            if (pagHidden) pagHidden.style.display = 'none';
        } else {
            if (pag) pag.style.cssText = 'display:none!important;';
            if (pagHidden) pagHidden.style.display = '';
        }

        var prevBtn = document.getElementById('dlpPrev');
        var nextBtn = document.getElementById('dlpNext');
        var pageNum = document.getElementById('dlpPageNum');
        if (prevBtn) prevBtn.disabled = currentPage === 0;
        if (nextBtn) nextBtn.disabled = currentPage >= totalPages - 1;
        if (pageNum) pageNum.textContent = totalPages > 1 ? 'Hal. ' + (currentPage + 1) + ' / ' + totalPages : '';

        var info = document.getElementById('dlpPageInfo');
        if (info) {
            var showing = Math.min(end, total);
            info.innerHTML = 'Menampilkan <strong>' + (total > 0 ? (start + 1) : 0) + '&ndash;' + showing + '</strong> dari <strong>' + total + '</strong> santri.';
        }
    }

    window.dlpChangePage = function (dir) {
        var rows  = document.querySelectorAll('#tblLengkap .dlp-row');
        var total = rows.length;
        var totalPages = Math.ceil(total / PER_PAGE);
        currentPage = Math.max(0, Math.min(totalPages - 1, currentPage + dir));
        dlpRender();
    };

    if (typeof $ !== 'undefined') {
        $('#modalDataLengkap').on('show.bs.modal', function () {
            currentPage = 0;
            dlpRender();
        });
        
        // Reset centang ke kondisi awal jika modal ditutup (X atau klik luar)
        $('#modalDataLengkap').on('hidden.bs.modal', function () {
            var form = $(this).find('form');
            if(form.length) {
                form[0].reset();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() { dlpRender(); });
    dlpRender();
})();
</script>
@endpush

@endsection
