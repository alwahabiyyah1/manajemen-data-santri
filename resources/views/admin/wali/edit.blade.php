@extends('layouts.admin')

@section('title', 'Edit Wali Santri')
@section('page-title', 'Pembaruan Akun Wali')
@section('page-subtitle', 'Perbarui detail profil atau akses login wali santri')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong><i class="fas fa-exclamation-circle mr-1"></i> Terdapat kesalahan input:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <form action="{{ route('admin.wali.update', $wali->id_wali) }}" method="POST" id="formWali">
            @csrf @method('PUT')

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-pen mr-2"></i> Edit Profil Wali Santri
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">Kosongkan kolom password jika tidak ingin mengubah kata sandi saat ini.</p>

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap Wali <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror"
                                   value="{{ old('nama_wali', $wali->nama_wali) }}" required>
                            @error('nama_wali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">No. WhatsApp / HP<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                           value="{{ old('no_hp', $wali->no_hp) }}">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Email (Opsional)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $wali->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Alamat Tempat Tinggal</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                  rows="3">{{ old('alamat', $wali->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h6 class="font-weight-bold text-warning mb-3">
                        <i class="fas fa-lock mr-1"></i> Kredensial Login Portal
                    </h6>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Username Login <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control font-monospace @error('username') is-invalid @enderror"
                                           value="{{ old('username', $wali->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Ubah Password <span class="text-muted font-weight-normal">(Opsional)</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Biarkan kosong jika tetap">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($wali->plain_password)
                                <small class="form-text text-info mt-1">
                                    <i class="fas fa-info-circle"></i> Password saat ini: <strong>{{ $wali->plain_password }}</strong>
                                </small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('admin.wali.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning font-weight-bold" id="submitBtn">
                        <i class="fas fa-floppy-disk mr-1"></i> Simpan Pembaruan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('formWali').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Menyimpan...';
        btn.disabled = true;
    });
</script>
@endpush
@endsection
