<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Santri — Platform Digital Pesantren</title>
    <meta name="description" content="Sistem Manajemen Data Santri. Platform digital terpadu untuk mengelola data santri, wali, dan dokumen pesantren.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-dark: #0a0e1a;
            --bg-card: rgba(255,255,255,.04);
            --border-subtle: rgba(255,255,255,.08);
            --text-primary: #f1f5f9;
            --text-secondary: rgba(255,255,255,.55);
            --accent-indigo: #6366f1;
            --accent-emerald: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ===== BACKGROUND ===== */
        .bg-glow {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
        }
        .bg-glow::before {
            content: '';
            position: absolute;
            top: -200px; left: 50%; transform: translateX(-50%);
            width: 900px; height: 600px;
            background: radial-gradient(ellipse, rgba(99,102,241,.12) 0%, transparent 70%);
            animation: glow-pulse 6s ease-in-out infinite alternate;
        }
        .bg-glow::after {
            content: '';
            position: absolute;
            bottom: -150px; right: -100px;
            width: 600px; height: 500px;
            background: radial-gradient(ellipse, rgba(16,185,129,.08) 0%, transparent 70%);
            animation: glow-pulse 8s ease-in-out infinite alternate-reverse;
        }
        @keyframes glow-pulse {
            0% { opacity: .6; transform: translateX(-50%) scale(1); }
            100% { opacity: 1; transform: translateX(-50%) scale(1.1); }
        }

        /* Grid overlay */
        .grid-bg {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ===== PARTICLES ===== */
        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .dot {
            position: absolute;
            width: 2px; height: 2px;
            background: rgba(165,180,252,.5);
            border-radius: 50%;
            animation: float-up linear infinite;
        }
        .dot:nth-child(1) { left: 10%; animation-duration: 18s; animation-delay: 0s; }
        .dot:nth-child(2) { left: 25%; animation-duration: 14s; animation-delay: -4s; width: 3px; height: 3px; background: rgba(52,211,153,.4); }
        .dot:nth-child(3) { left: 45%; animation-duration: 20s; animation-delay: -8s; }
        .dot:nth-child(4) { left: 65%; animation-duration: 16s; animation-delay: -2s; width: 3px; height: 3px; }
        .dot:nth-child(5) { left: 80%; animation-duration: 22s; animation-delay: -6s; background: rgba(52,211,153,.3); }
        .dot:nth-child(6) { left: 90%; animation-duration: 15s; animation-delay: -10s; }
        .dot:nth-child(7) { left: 35%; animation-duration: 19s; animation-delay: -12s; width: 3px; height: 3px; background: rgba(139,92,246,.4); }
        .dot:nth-child(8) { left: 55%; animation-duration: 17s; animation-delay: -3s; }

        @keyframes float-up {
            0% { bottom: -10px; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { bottom: 110vh; opacity: 0; }
        }

        /* ===== LAYOUT ===== */
        .container {
            position: relative; z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== NAV ===== */
        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 0;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--text-primary);
        }
        .nav-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent-indigo), #8b5cf6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px rgba(99,102,241,.3);
        }
        .nav-title { font-weight: 700; font-size: .95rem; line-height: 1.3; }
        .nav-sub { font-size: .7rem; color: var(--text-secondary); font-weight: 500; }
        .nav-links { display: flex; align-items: center; gap: 12px; }
        .nav-link {
            padding: 9px 18px; border-radius: 10px;
            font-size: .82rem; font-weight: 600;
            text-decoration: none;
            transition: all .25s;
        }
        .nav-link-ghost {
            color: rgba(255,255,255,.7);
            border: 1.5px solid transparent;
        }
        .nav-link-ghost:hover { color: #fff; border-color: var(--border-subtle); background: var(--bg-card); }
        .nav-link-solid {
            background: linear-gradient(135deg, var(--accent-indigo), #4f46e5);
            color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,.35);
        }
        .nav-link-solid:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,.45); }

        /* ===== HERO ===== */
        .hero {
            text-align: center;
            padding: 80px 0 60px;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(99,102,241,.12);
            border: 1px solid rgba(99,102,241,.25);
            border-radius: 24px;
            padding: 7px 18px;
            font-size: .72rem; font-weight: 700;
            color: #a5b4fc;
            letter-spacing: .03em;
            margin-bottom: 28px;
        }
        .hero-badge i { font-size: .6rem; }
        .hero-badge .pulse-dot {
            width: 7px; height: 7px;
            background: var(--accent-emerald);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(1.4); }
        }

        .hero h1 {
            font-size: 3.4rem;
            font-weight: 900;
            line-height: 1.12;
            letter-spacing: -0.03em;
            margin-bottom: 20px;
        }
        .hero h1 .gradient {
            background: linear-gradient(135deg, #a5b4fc, #818cf8, #c4b5fd);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero h1 .gradient-green {
            background: linear-gradient(135deg, #6ee7b7, #34d399, #a7f3d0);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-desc {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 580px;
            margin: 0 auto 40px;
            line-height: 1.75;
        }
        .hero-actions { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .btn-hero {
            padding: 15px 30px;
            border-radius: 13px;
            font-family: inherit;
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 9px;
            transition: all .3s;
            cursor: pointer; border: none;
        }
        .btn-admin {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 4px 20px rgba(99,102,241,.4);
        }
        .btn-admin:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(99,102,241,.5); }
        .btn-wali {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            box-shadow: 0 4px 20px rgba(16,185,129,.35);
        }
        .btn-wali:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(16,185,129,.45); }

        /* ===== FEATURES ===== */
        .features {
            padding: 40px 0 80px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .feature-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 32px 28px;
            transition: all .35s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-indigo), transparent);
            opacity: 0;
            transition: opacity .3s;
        }
        .feature-card:hover {
            background: rgba(255,255,255,.07);
            border-color: rgba(255,255,255,.15);
            transform: translateY(-4px);
        }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 48px; height: 48px;
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 18px;
        }
        .fi-indigo { background: rgba(99,102,241,.15); color: #a5b4fc; }
        .fi-emerald { background: rgba(16,185,129,.15); color: #6ee7b7; }
        .fi-amber { background: rgba(245,158,11,.15); color: #fbbf24; }
        .fi-rose { background: rgba(244,63,94,.15); color: #fb7185; }
        .fi-violet { background: rgba(139,92,246,.15); color: #c4b5fd; }
        .fi-cyan { background: rgba(6,182,212,.15); color: #67e8f9; }

        .feature-title { font-size: .95rem; font-weight: 700; margin-bottom: 8px; color: #f1f5f9; }
        .feature-desc { font-size: .8rem; color: var(--text-secondary); line-height: 1.65; }

        /* ===== STATS BAR ===== */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 48px;
            padding: 48px 0;
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
            margin-bottom: 60px;
        }
        .stat-item { text-align: center; }
        .stat-value {
            font-size: 2rem; font-weight: 800; letter-spacing: -0.02em;
            background: linear-gradient(135deg, #e2e8f0, #fff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .stat-label { font-size: .75rem; color: var(--text-secondary); margin-top: 4px; font-weight: 500; }

        /* ===== CTA ===== */
        .cta-section {
            text-align: center;
            padding: 0 0 60px;
        }
        .cta-card {
            background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(139,92,246,.06));
            border: 1px solid rgba(99,102,241,.2);
            border-radius: 24px;
            padding: 56px 40px;
            position: relative;
            overflow: hidden;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(99,102,241,.1), transparent 70%);
            pointer-events: none;
        }
        .cta-title { font-size: 1.8rem; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.02em; }
        .cta-desc { color: var(--text-secondary); margin-bottom: 28px; font-size: .9rem; }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding: 28px 0;
            border-top: 1px solid var(--border-subtle);
            font-size: .75rem;
            color: rgba(255,255,255,.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .hero-desc { font-size: .9rem; }
            .features-grid { grid-template-columns: 1fr; }
            .stats-bar { gap: 28px; flex-wrap: wrap; }
            .nav-links { gap: 8px; }
            .nav-link { padding: 8px 14px; font-size: .78rem; }
            .cta-card { padding: 40px 24px; }
            .cta-title { font-size: 1.4rem; }
            .btn-hero { padding: 13px 22px; font-size: .85rem; }
        }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0; transform: translateY(24px);
            animation: fadeUp .8s ease forwards;
        }
        .fade-up-d1 { animation-delay: .1s; }
        .fade-up-d2 { animation-delay: .2s; }
        .fade-up-d3 { animation-delay: .35s; }
        .fade-up-d4 { animation-delay: .5s; }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>
    <div class="grid-bg"></div>
    <div class="particles">
        <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
        <div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
    </div>

    <div class="container">

        <!-- NAV -->
        <nav class="nav fade-up">
            <a href="/" class="nav-brand">
                <div class="nav-logo">🕌</div>
                <div>
                    <div class="nav-title">Manajemen Data Santri</div>
                    <div class="nav-sub">Platform Digital Pesantren</div>
                </div>
            </a>
            <div class="nav-links">
                <a href="{{ route('wali.login') }}" class="nav-link nav-link-ghost">
                    <i class="fas fa-users"></i> Portal Wali
                </a>
                <a href="{{ route('admin.login') }}" class="nav-link nav-link-solid">
                    <i class="fas fa-shield-halved"></i> Admin
                </a>
            </div>
        </nav>

        <!-- HERO -->
        <section class="hero">
            <div class="fade-up fade-up-d1">
                <div class="hero-badge">
                    <div class="pulse-dot"></div>
                    SISTEM INFORMASI PESANTREN
                </div>
            </div>
            <h1 class="fade-up fade-up-d2">
                Kelola Data Santri<br>
                <span class="gradient">Lebih Cerdas,</span>
                <span class="gradient-green">Lebih Efisien</span>
            </h1>
            <p class="hero-desc fade-up fade-up-d3">
                Platform terpadu untuk pendaftaran, pengelolaan data santri, orang tua, wali, dan dokumen pesantren — semua dalam satu sistem yang aman dan mudah digunakan.
            </p>
            <div class="hero-actions fade-up fade-up-d4">
                <a href="{{ route('admin.login') }}" class="btn-hero btn-admin">
                    <i class="fas fa-shield-halved"></i>
                    Masuk sebagai Admin
                </a>
                <a href="{{ route('wali.login') }}" class="btn-hero btn-wali">
                    <i class="fas fa-users"></i>
                    Portal Wali Santri
                </a>
            </div>
        </section>

        <!-- STATS -->
        <div class="stats-bar fade-up fade-up-d4">
            <div class="stat-item">
                <div class="stat-value">📋</div>
                <div class="stat-label">Data Terintegrasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">🔒</div>
                <div class="stat-label">Akses Aman</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">📱</div>
                <div class="stat-label">Responsif</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">⚡</div>
                <div class="stat-label">Real-time</div>
            </div>
        </div>

        <!-- FEATURES -->
        <section class="features">
            <div class="features-grid">
                <div class="feature-card fade-up">
                    <div class="feature-icon fi-indigo"><i class="fas fa-user-plus"></i></div>
                    <div class="feature-title">Pendaftaran Multi-Step</div>
                    <div class="feature-desc">Formulir pendaftaran santri baru yang terstruktur dengan wizard step-by-step untuk data lengkap.</div>
                </div>
                <div class="feature-card fade-up fade-up-d1">
                    <div class="feature-icon fi-emerald"><i class="fas fa-users"></i></div>
                    <div class="feature-title">Portal Wali Santri</div>
                    <div class="feature-desc">Wali dapat memantau dan memperbarui data santri melalui portal khusus yang aman.</div>
                </div>
                <div class="feature-card fade-up fade-up-d2">
                    <div class="feature-icon fi-amber"><i class="fas fa-database"></i></div>
                    <div class="feature-title">Data Terpusat</div>
                    <div class="feature-desc">Kelola data santri, ayah, ibu, wali, dan alamat dalam satu database terintegrasi.</div>
                </div>
                <div class="feature-card fade-up fade-up-d1">
                    <div class="feature-icon fi-rose"><i class="fas fa-file-export"></i></div>
                    <div class="feature-title">Export Excel</div>
                    <div class="feature-desc">Export seluruh data santri ke format Excel untuk pelaporan dan dokumentasi.</div>
                </div>
                <div class="feature-card fade-up fade-up-d2">
                    <div class="feature-icon fi-violet"><i class="fas fa-camera"></i></div>
                    <div class="feature-title">Berkas & Foto</div>
                    <div class="feature-desc">Upload dan kelola foto santri serta berkas penting seperti kartu keluarga.</div>
                </div>
                <div class="feature-card fade-up fade-up-d3">
                    <div class="feature-icon fi-cyan"><i class="fas fa-sync-alt"></i></div>
                    <div class="feature-title">Sinkronisasi Data</div>
                    <div class="feature-desc">Data otomatis tersinkronisasi antara portal admin dan portal wali secara real-time.</div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section fade-up">
            <div class="cta-card">
                <div class="cta-title">Siap Memulai? 🚀</div>
                <p class="cta-desc">Masuk ke portal Anda untuk mengelola data santri pesantren dengan mudah dan efisien.</p>
                <div class="hero-actions">
                    <a href="{{ route('admin.login') }}" class="btn-hero btn-admin">
                        <i class="fas fa-right-to-bracket"></i>
                        Login Admin
                    </a>
                    <a href="{{ route('wali.login') }}" class="btn-hero btn-wali">
                        <i class="fas fa-right-to-bracket"></i>
                        Login Wali
                    </a>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="footer">
            &copy; {{ date('Y') }} Sistem Manajemen Data Santri — Dibangun dengan ❤️ untuk Pesantren
        </footer>

    </div>

</body>
</html>
