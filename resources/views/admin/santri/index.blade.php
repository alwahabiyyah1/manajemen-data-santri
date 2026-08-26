@extends('layouts.admin')

@section('title', 'Data Santri')
@section('page-title', 'Database Santri')
@section('page-subtitle', 'Kelola, filter, dan cari seluruh data santri')

@section('content')

@push('styles')
<style>
    /* Custom table styles for better responsiveness */
    .table td, .table th {
        vertical-align: middle;
        white-space: nowrap; /* Mencegah teks terpotong ke bawah */
    }
    .table td.wrap-text {
        white-space: normal; /* Membiarkan teks panjang (seperti nama) membungkus */
        min-width: 200px;
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
    }
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
    }
</style>
@endpush

<!-- Page Heading -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap" style="gap:10px;">
    <h1 class="h3 mb-0 text-gray-800">Daftar Santri</h1>
    <div class="d-flex flex-wrap" style="gap:8px;">
        <a href="{{ route('admin.santri.export', request()->all()) }}" class="btn btn-success shadow-sm" target="_blank">
            <i class="fas fa-file-excel fa-sm mr-1"></i> Unduh Excel
        </a>
        <a href="{{ route('admin.santri.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm mr-1"></i> Tambah Santri
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

@if(session('wali_account_created') && session('new_wali_account'))
@php $wa = session('new_wali_account'); @endphp
<div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
    <strong><i class="fas fa-key mr-1"></i> Akun Wali Santri Berhasil Dibuat!</strong>
    <hr class="my-2">
    <div class="row">
        <div class="col-md-4 col-12 mb-1"><strong>Nama Wali:</strong> {{ $wa['nama'] }}</div>
        <div class="col-md-4 col-12 mb-1"><strong>Username:</strong> <code>{{ $wa['username'] }}</code></div>
        <div class="col-md-4 col-12 mb-1"><strong>Password Default:</strong> <code>{{ $wa['password'] }}</code></div>
    </div>
    <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i>Catat password ini! Password tidak dapat ditampilkan kembali setelah halaman ditutup.</small>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif


<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter mr-1"></i> Filter & Pencarian
        </h6>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row" style="gap:0;">
                <div class="col-12 col-sm-6 col-md-3 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama..." class="form-control">
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-2 mb-2">
                    <select name="tahun_masuk" class="form-control">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ request('tahun_masuk') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm-6 col-md-2 mb-2">
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-6 col-sm-6 col-md-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif"       {{ request('status')=='aktif'       ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ request('status')=='tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="lulus"       {{ request('status')=='lulus'       ? 'selected' : '' }}>Lulus</option>
                        <option value="keluar"      {{ request('status')=='keluar'      ? 'selected' : '' }}>Keluar/DO</option>
                    </select>
                </div>
                <div class="col-6 col-sm-auto mb-2 d-flex" style="gap:6px;">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request('search') || request('status') || request('tahun_masuk') || request('jenis_kelamin'))
                        <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">
                            <i class="fas fa-rotate-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table mr-1"></i> Data Santri
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Profil Santri</th>
                        <th>Wali / Penanggung Jawab</th>
                        <th class="text-center">Tahun Masuk</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santri as $i => $s)
                    <tr>
                        <td class="text-center text-muted">{{ $santri->firstItem() + $i }}</td>
                        <td class="wrap-text">
                            <div class="d-flex align-items-center">
                                @if(!empty($s->dataSantri->foto_3x4))
                                    <img src="{{ asset('storage/berkas/' . $s->dataSantri->foto_3x4) }}" 
                                         alt="Foto {{ $s->dataSantri->nama_lengkap }}"
                                         class="rounded-circle mr-3 flex-shrink-0 shadow-sm"
                                         style="width:45px;height:45px;object-fit:cover;border:2px solid #fff;">
                                @else
                                    <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center mr-3 flex-shrink-0 shadow-sm"
                                         style="width:45px;height:45px;color:#fff;font-weight:700;">
                                        {{ strtoupper(substr($s->dataSantri->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-weight-bold text-dark mb-1">
                                        {{ $s->dataSantri->nama_lengkap ?? 'Data Belum Lengkap' }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.85rem;">
                                        {{ $s->dataSantri->jenis_kelamin ?? '-' }} &bull;
                                        NIS: #{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($s->wali)
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-2 border" style="width:30px;height:30px;">
                                        <i class="fas fa-user-shield text-secondary" style="font-size:0.8rem;"></i>
                                    </div>
                                    <span class="font-weight-medium text-dark">{{ $s->wali->nama_wali }}</span>
                                </div>
                            @else
                                <span class="badge badge-warning px-2 py-1">
                                    <i class="fas fa-triangle-exclamation mr-1"></i> Belum ada wali
                                </span>
                            @endif
                        </td>
                        <td class="text-center font-weight-bold text-secondary">{{ $s->dataSantri->tahun_masuk ?? '-' }}</td>
                        <td class="text-center">
                            @php
                                $badgeMap = [
                                    'aktif'       => 'success',
                                    'lulus'       => 'info',
                                    'keluar'      => 'danger',
                                    'tidak aktif' => 'secondary',
                                ];
                                $badgeColor = $badgeMap[$s->status_data] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $badgeColor }} px-3 py-2">
                                {{ ucfirst($s->status_data) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.santri.show', $s->id) }}"
                                   class="btn btn-info btn-sm shadow-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.santri.edit', $s->id) }}"
                                   class="btn btn-warning btn-sm shadow-sm text-white" title="Edit Data">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.santri.destroy', $s->id) }}" method="POST"
                                      onsubmit="return confirm('Peringatan: Menghapus data santri ini akan menghapus seluruh data yang terkait secara permanen. Lanjutkan?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3 d-block"></i>
                            <h5 class="text-gray-600">Data Santri Kosong</h5>
                            <p class="text-muted mb-3">Belum ada data santri yang terdaftar atau ditemukan.</p>
                            @if(!request('search') && !request('status'))
                                <a href="{{ route('admin.santri.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Tambah Santri Perdana
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($santri->hasPages())
        <div class="card-footer bg-white">
            {{ $santri->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
