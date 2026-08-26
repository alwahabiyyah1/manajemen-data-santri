@extends('layouts.admin')

@section('title', 'Tambah Wali Santri')
@section('page-title', 'Pendaftaran Akun Wali')
@section('page-subtitle', 'Buat akun portal baru untuk wali santri')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong><i class="fas fa-exclamation-circle mr-1"></i> Periksa kembali inputan Anda:</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <form action="{{ route('admin.wali.store') }}" method="POST" id="formWali">
            @csrf

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-plus mr-2"></i> Form Data Wali Santri
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">Data ini digunakan untuk login ke Portal Wali. Pastikan Username unik.</p>

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Lengkap Wali <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror"
                                   value="{{ old('nama_wali') }}" placeholder="Contoh: H. Abdul Rasyid" required>
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
                                           value="{{ old('no_hp') }}" placeholder="08xx...">
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
                                           value="{{ old('email') }}" placeholder="nama@email.com">
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
                                  rows="3" placeholder="Jl. Raya No. 123, Desa, Kec, Kab...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h6 class="font-weight-bold text-warning mb-3">
                        <i class="fas fa-lock mr-1"></i> Kredensial Login Portal
                    </h6>

                    <div class="row">
                        {{-- Username --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Username Login <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                           value="{{ old('username') }}" placeholder="Contoh: wali_ahmad" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Min. 6 karakter" required autocomplete="new-password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                                data-target="password" title="Perlihatkan / Sembunyikan Sandi">
                                            <i class="fas fa-eye" id="icon-password"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                                data-target="password_confirmation" title="Perlihatkan / Sembunyikan Sandi">
                                            <i class="fas fa-eye" id="icon-password_confirmation"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Harus sama dengan password di samping.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('admin.wali.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning font-weight-bold" id="submitBtn">
                        <i class="fas fa-user-check mr-1"></i> Buat Akun Wali
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Submit button loading state
    document.getElementById('formWali').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-1"></i> Memproses...';
        btn.disabled = true;
    });

    // Toggle show/hide password
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon  = document.getElementById('icon-' + targetId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
</script>
@endpush
@endsection
