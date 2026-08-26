<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Wali — Portal Wali Santri</title>
    <meta name="description" content="Masuk ke Portal Wali Santri untuk memantau data dan perkembangan anak Anda.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            color: #1e293b;
        }

        /* ====== LEFT PANEL ====== */
        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background: linear-gradient(160deg, #022c22 0%, #064e3b 40%, #065f46 70%, #0aa174 100%);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .left-content { position: relative; z-index: 1; text-align: center; color: #fff; max-width: 420px; }
        .left-logo {
            width: 80px; height: 80px;
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,.2);
            border-radius: 22px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem; margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,.2);
        }
        .left-title { font-size: 2rem; font-weight: 800; margin-bottom: 12px; line-height: 1.2; }
        .left-title span { color: #6ee7b7; }
        .left-sub { font-size: .9rem; opacity: .75; margin-bottom: 36px; line-height: 1.7; }

        .feature-list { display: flex; flex-direction: column; gap: 14px; text-align: left; }
        .feature-item {
            display: flex; align-items: center; gap: 12px;
            background: rgba(255,255,255,.08);
            border-radius: 12px; padding: 12px 16px;
            font-size: .85rem;
        }
        .feature-icon {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; flex-shrink: 0;
            color: #6ee7b7;
        }
        .feature-label { color: rgba(255,255,255,.9); font-weight: 600; }
        .feature-desc  { color: rgba(255,255,255,.5); font-size: .75rem; margin-top: 1px; }

        /* ====== RIGHT PANEL ====== */
        .right-panel {
            width: 460px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .login-brand {
            display: flex; align-items: center; gap: 10px; margin-bottom: 36px;
        }
        .login-brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; color: #fff;
            box-shadow: 0 4px 12px rgba(16,185,129,.3);
        }
        .login-brand-text { font-weight: 700; color: #1e293b; font-size: .95rem; line-height: 1.3; }
        .login-brand-sub  { font-size: .72rem; color: #94a3b8; }

        .login-heading { font-size: 1.6rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .login-sub     { font-size: .875rem; color: #64748b; margin-bottom: 32px; }

        /* Form */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: .8rem; font-weight: 700;
            color: #374151; margin-bottom: 7px; letter-spacing: .01em;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: .85rem; z-index: 1;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: inherit;
            font-size: .875rem;
            color: #1e293b;
            background: #fafafa;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #10b981;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }
        .form-input.is-invalid { border-color: #ef4444; }
        .field-error {
            font-size: .75rem; color: #ef4444;
            margin-top: 5px; display: flex; align-items: center; gap: 4px;
        }

        .pass-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #94a3b8;
            font-size: .85rem; padding: 4px;
        }
        .pass-toggle:hover { color: #64748b; }

        .form-remember {
            display: flex; align-items: center; gap: 8px;
            font-size: .82rem; color: #64748b; cursor: pointer;
        }
        .form-remember input { accent-color: #10b981; width: 15px; height: 15px; cursor: pointer; }

        .btn-login {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; font-family: inherit;
            font-size: .9rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            box-shadow: 0 4px 14px rgba(16,185,129,.35);
            transition: all .2s; margin-top: 8px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,.45); }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* Alert */
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 10px; padding: 12px 16px;
            font-size: .82rem; color: #991b1b;
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 20px;
        }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0; color: #cbd5e1; font-size: .78rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }

        .admin-link {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px; border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            color: #64748b; text-decoration: none; font-size: .82rem; font-weight: 600;
            transition: all .2s;
        }
        .admin-link:hover { border-color: #94a3b8; color: #374151; background: #fafafa; }

        .login-footer {
            text-align: center; margin-top: 32px;
            font-size: .75rem; color: #cbd5e1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 36px 24px; }
        }
    </style>
</head>
<body>

    <!-- Left Panel: Branding -->
    <div class="left-panel">
        <div class="left-content">
            <div class="left-logo">🕌</div>
            <div class="left-title">Portal <span>Wali Santri</span></div>
            <div class="left-sub">
                Pantau perkembangan dan data lengkap anak Anda di pesantren, kapan saja dan di mana saja.
            </div>
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="feature-label">Profil Lengkap Santri</div>
                        <div class="feature-desc">Lihat biodata, status, dan informasi akademis</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-house-chimney"></i></div>
                    <div>
                        <div class="feature-label">Data Domisili & Keluarga</div>
                        <div class="feature-desc">Informasi alamat, ayah, ibu, dan wali santri</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                    <div>
                        <div class="feature-label">Akses Aman & Terpercaya</div>
                        <div class="feature-desc">Data terlindungi, hanya bisa diakses wali terdaftar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Login Form -->
    <div class="right-panel">
        <div class="login-brand">
            <div class="login-brand-icon"><i class="fas fa-mosque"></i></div>
            <div>
                <div class="login-brand-text">Manajemen Data Santri</div>
                <div class="login-brand-sub">Portal Wali</div>
            </div>
        </div>

        <h1 class="login-heading">Masuk ke Portal</h1>
        <p class="login-sub">Gunakan nomor HP atau email yang terdaftar sebagai wali santri.</p>

        {{-- Error Alert --}}
        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-circle-exclamation" style="flex-shrink:0;margin-top:2px;"></i>
            <div>
                <strong>Login gagal.</strong><br>
                {{ $errors->first() }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-circle-exclamation" style="flex-shrink:0;margin-top:2px;"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('wali.login.post') }}">
            {{-- Perhatian: field name harus 'username' sesuai controller --}}
            @csrf

            {{-- Username --}}
            <div class="form-group">
                <label class="form-label" for="username">
                    Username
                </label>
                <div class="input-wrap">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input {{ $errors->has('username') ? 'is-invalid' : '' }}"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username Anda"
                        autocomplete="username"
                        required
                    >
                </div>
                @error('username')
                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="pass-toggle" id="togglePass" aria-label="Tampilkan kata sandi">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="field-error"><i class="fas fa-triangle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Remember + Submit --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <label class="form-remember">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <i class="fas fa-right-to-bracket"></i>
                Masuk ke Portal
            </button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('admin.login') }}" class="admin-link">
            <i class="fas fa-user-shield"></i>
            Login sebagai Admin
        </a>

        <div class="login-footer">
            &copy; {{ date('Y') }} Sistem Manajemen Data Santri<br>
            Jika mengalami kendala, hubungi administrasi pesantren.
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePass = document.getElementById('togglePass');
        const passInput  = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        togglePass?.addEventListener('click', () => {
            const isText = passInput.type === 'text';
            passInput.type = isText ? 'password' : 'text';
            toggleIcon.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
        });

        // Disable button on submit to prevent double click
        document.getElementById('loginForm')?.addEventListener('submit', () => {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });
    </script>
</body>
</html>
