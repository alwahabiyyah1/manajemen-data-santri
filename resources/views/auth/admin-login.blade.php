<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator | Manajemen Data Santri</title>

    <!-- Google Fonts: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SB Admin 2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- Left Panel -->
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"
                                 style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); min-height: 500px; display: flex !important; align-items: center; justify-content: center; flex-direction: column;">
                                <div class="text-center text-white p-5">
                                    <div class="mb-4">
                                        <i class="fas fa-mosque fa-5x opacity-75"></i>
                                    </div>
                                    <h2 class="font-weight-bold">Sistem Manajemen</h2>
                                    <h3 class="font-weight-bold">Data Santri</h3>
                                    <p class="mt-3 opacity-75">Platform terpadu untuk mengelola data santri pesantren secara digital dan efisien.</p>
                                </div>
                            </div>
                            <!-- Right Panel: Login Form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900 font-weight-bold">Portal Administrator</h1>
                                        <p class="text-muted small">Masuk menggunakan akun admin Anda</p>
                                    </div>

                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                    </div>
                                    @endif

                                    <form class="user" action="{{ route('admin.login.post') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-user-shield text-primary"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="username" class="form-control form-control-user"
                                                       value="{{ old('username') }}"
                                                       placeholder="Username Admin" required autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </span>
                                                </div>
                                                <input type="password" name="password" class="form-control form-control-user"
                                                       placeholder="Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Ingat sesi saya</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt mr-1"></i>
                                            Masuk ke Dashboard
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <p class="small text-muted mb-2">Login sebagai Wali Santri?</p>
                                        <a href="{{ route('wali.login') }}" class="small font-weight-bold">
                                            <i class="fas fa-users mr-1"></i> Ke Portal Wali Santri
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
</body>
</html>
