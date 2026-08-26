@extends('layouts.admin')

@section('title', 'Akun Wali Santri')
@section('page-title', 'Manajemen Wali Santri')
@section('page-subtitle', 'Kelola hak akses dan akun portal wali santri')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Daftar Akun Wali</h1>
        <small class="text-muted">{{ $walis->total() }} wali terdaftar</small>
    </div>
    <a href="{{ route('admin.wali.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Tambah Akun Wali
    </a>
</div>

<!-- DataTable Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-users mr-1"></i> Data Wali Santri
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th>Profil Wali Santri</th>
                        <th>Kontak &amp; Alamat</th>
                        <th>Akses Login</th>
                        <th class="text-center">Tanggungan</th>
                        <th class="text-center" style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($walis as $i => $w)
                    <tr>
                        <td class="text-center text-muted">{{ $walis->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-gradient-warning d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                                     style="width:38px;height:38px;color:#fff;font-weight:700;">
                                    {{ strtoupper(substr($w->nama_wali, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $w->nama_wali }}</div>
                                    <small class="text-muted">Terdaftar: {{ $w->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-1">
                                <i class="fas fa-phone text-muted fa-fw mr-1"></i>
                                <span class="small">{{ $w->no_hp ?? '-' }}</span>
                            </div>
                            <div>
                                <i class="fas fa-location-dot text-muted fa-fw mr-1"></i>
                                <span class="small text-muted">{{ Str::limit($w->alamat ?? 'Belum diisi', 35) }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light border">
                                <i class="fas fa-key text-warning mr-1"></i>
                                <code>{{ $w->username }}</code>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-primary badge-pill">{{ $w->santris_count }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.wali.edit', $w->id_wali) }}"
                               class="btn btn-warning btn-sm" title="Edit Akun Wali">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.wali.destroy', $w->id_wali) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus akun wali ini? Hak akses mereka ke portal akan dicabut.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus Akun">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-gray-300 mb-3 d-block"></i>
                            <h5 class="text-gray-600">Belum Ada Akun Wali</h5>
                            <p class="text-muted mb-3">Silakan tambah akun wali agar mereka bisa login ke portal.</p>
                            <a href="{{ route('admin.wali.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i> Tambah Perdana
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($walis->hasPages())
        <div class="card-footer bg-white">
            {{ $walis->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
