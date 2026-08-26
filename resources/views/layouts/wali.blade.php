<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Portal Wali') — Manajemen Santri</title>
    <meta name="description" content="Portal Wali Santri — Pantau perkembangan dan data anak Anda secara digital">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary:       #10b981;
            --primary-dark:  #059669;
            --primary-light: #d1fae5;
            --accent:        #6366f1;
            --sidebar-bg:    #0f172a;
            --sidebar-width: 260px;
            --topbar-h:      68px;
            --text-main:     #1e293b;
            --text-muted:    #64748b;
            --bg-page:       #f1f5f9;
            --card-bg:       #ffffff;
            --border:        #e2e8f0;
            --shadow-sm:     0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md:     0 4px 16px rgba(0,0,0,.10);
            --shadow-lg:     0 10px 40px rgba(0,0,0,.12);
            --radius:        14px;
            --radius-sm:     8px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* ========== SIDEBAR ========== */
        .wali-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
        }
        .sidebar-brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff;
            box-shadow: 0 4px 12px rgba(16,185,129,.4);
        }
        .sidebar-brand-text { color: #f8fafc; font-weight: 700; font-size: .95rem; line-height: 1.3; }
        .sidebar-brand-sub  { color: rgba(255,255,255,.4); font-size: .72rem; font-weight: 400; }

        .sidebar-section-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255,255,255,.28);
            padding: 20px 20px 6px;
        }

        .sidebar-nav { list-style: none; padding: 8px 12px; flex: 1; }
        .sidebar-nav li { margin-bottom: 2px; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .875rem; font-weight: 500;
            transition: all .2s;
        }
        .sidebar-nav a:hover { color: #fff; background: rgba(255,255,255,.07); }
        .sidebar-nav a.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(16,185,129,.25), rgba(16,185,129,.1));
            box-shadow: inset 3px 0 0 var(--primary);
        }
        .sidebar-nav a .nav-icon { width: 20px; text-align: center; font-size: .9rem; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.07);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,.05);
        }
        .sidebar-user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .9rem;
            flex-shrink: 0;
        }
        .sidebar-user-name { color: #f8fafc; font-size: .82rem; font-weight: 600; }
        .sidebar-user-role { color: rgba(255,255,255,.4); font-size: .72rem; }
        .sidebar-logout-btn {
            margin-left: auto;
            width: 30px; height: 30px;
            border-radius: 6px;
            background: rgba(239,68,68,.15);
            border: none; cursor: pointer;
            color: #ef4444; font-size: .8rem;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s;
        }
        .sidebar-logout-btn:hover { background: rgba(239,68,68,.3); }

        /* ========== TOPBAR ========== */
        .wali-topbar {
            position: fixed;
            top: 0; left: var(--sidebar-width); right: 0;
            height: var(--topbar-h);
            background: rgba(255,255,255,.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            z-index: 900;
            box-shadow: var(--shadow-sm);
        }
        .topbar-title h1 { font-size: 1.1rem; font-weight: 700; color: var(--text-main); }
        .topbar-title p  { font-size: .78rem; color: var(--text-muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-date {
            font-size: .78rem; color: var(--text-muted);
            background: var(--bg-page);
            border-radius: 20px;
            padding: 6px 14px;
            display: flex; align-items: center; gap: 6px;
        }
        .topbar-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .9rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(16,185,129,.3);
        }

        /* ========== MAIN CONTENT ========== */
        .wali-main {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            flex: 1;
        }
        .wali-content {
            padding: 28px;
            max-width: 1200px;
        }

        /* ========== CARDS ========== */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: var(--card-bg);
        }
        .card-header h6, .card-header .card-title {
            font-size: .875rem; font-weight: 700; color: var(--text-main);
            margin: 0; display: flex; align-items: center; gap: 8px;
        }
        .card-body { padding: 20px; }

        /* ========== BADGES ========== */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 20px;
            font-size: .72rem; font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-info    { background: #dbeafe; color: #1e40af; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-secondary { background: #f1f5f9; color: #475569; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-primary { background: #ede9fe; color: #5b21b6; }

        /* ========== ALERTS (FLASH) ========== */
        .flash-alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 18px; border-radius: var(--radius-sm);
            margin-bottom: 20px; font-size: .875rem;
            animation: slideDown .3s ease;
        }
        @keyframes slideDown {
            from { opacity:0; transform: translateY(-10px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .flash-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .flash-alert .flash-close {
            margin-left: auto; background: none; border: none; cursor: pointer;
            color: inherit; opacity: .5; font-size: .9rem;
        }
        .flash-alert .flash-close:hover { opacity: 1; }

        /* ========== TABLES ========== */
        table.info-table { width: 100%; border-collapse: collapse; }
        table.info-table td { padding: 9px 6px; vertical-align: top; font-size: .85rem; }
        table.info-table tr + tr td { border-top: 1px solid var(--border); }
        table.info-table td:first-child { color: var(--text-muted); width: 42%; font-weight: 500; }
        table.info-table td:last-child  { color: var(--text-main); font-weight: 600; }

        /* ========== BUTTONS ========== */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: var(--radius-sm);
            font-size: .85rem; font-weight: 600; cursor: pointer;
            border: none; text-decoration: none; transition: all .2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff; box-shadow: 0 2px 8px rgba(16,185,129,.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(16,185,129,.45); }
        .btn-outline {
            background: transparent; border: 1.5px solid var(--border);
            color: var(--text-muted);
        }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 6px 14px; font-size: .8rem; }

        /* ========== FOOTER ========== */
        .wali-footer {
            text-align: center;
            font-size: .78rem;
            color: var(--text-muted);
            padding: 24px 28px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        /* ========== MOBILE ========== */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 999;
        }
        .topbar-hamburger {
            display: none;
            background: none; border: none; cursor: pointer;
            font-size: 1.1rem; color: var(--text-main);
            margin-right: 12px;
        }

        /* Bottom Nav Bar — hanya tampil di HP */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 62px;
            background: #fff;
            border-top: 1px solid var(--border);
            z-index: 950;
            padding: 0 8px;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 16px rgba(0,0,0,.08);
        }
        .mobile-nav-item {
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 3px; flex: 1;
            text-decoration: none;
            color: #94a3b8;
            font-size: .65rem; font-weight: 600;
            padding: 8px 4px;
            border-radius: 10px;
            transition: color .2s;
            border: none; background: none; cursor: pointer;
        }
        .mobile-nav-item i { font-size: 1.1rem; }
        .mobile-nav-item.active { color: var(--primary); }
        .mobile-nav-item:hover  { color: var(--primary); }
        .mobile-nav-item.logout-btn { color: #ef4444; }

        @media (max-width: 768px) {
            /* Sidebar jadi drawer dari kiri */
            .wali-sidebar { transform: translateX(-100%); }
            .wali-sidebar.open { transform: translateX(0); }

            /* Topbar full-width, hamburger tampil */
            .wali-topbar { left: 0; padding: 0 16px; }
            .topbar-hamburger { display: block; }
            .topbar-date { display: none; }
            .topbar-title h1 { font-size: .95rem; }
            .topbar-title p  { display: none; }

            /* Main content tanpa margin sidebar */
            .wali-main  { margin-left: 0; }
            .wali-content { padding: 14px 14px 80px; } /* padding-bottom untuk bottom nav */

            /* Overlay sidebar aktif */
            .sidebar-overlay.show { display: block; }

            /* Bottom nav tampil */
            .mobile-bottom-nav { display: flex; }

            /* Scroll-to-top lebih ke atas (atas bottom nav) */
            .scroll-top-btn { bottom: 74px; right: 16px; }

            /* Footer disembunyikan di mobile — sudah ada bottom nav */
            .wali-footer { display: none; }

            /* Card dan konten */
            .card-body { padding: 14px; }
            .card-header { padding: 12px 14px; }
            .btn { padding: 8px 14px; font-size: .82rem; }

            /* Modal lebih friendly di HP */
            .modal-box { width: 95vw; padding: 20px; }
        }

        @media (max-width: 480px) {
            .wali-content { padding: 10px 10px 80px; }
            .topbar-title h1 { font-size: .88rem; }
            .topbar-avatar { width: 32px; height: 32px; font-size: .78rem; }
        }

        /* ========== LOGOUT MODAL ========== */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 2000;
            align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff; border-radius: var(--radius);
            padding: 28px; width: 380px; max-width: 90vw;
            box-shadow: var(--shadow-lg);
            animation: popIn .2s ease;
        }
        @keyframes popIn {
            from { opacity:0; transform: scale(.95); }
            to   { opacity:1; transform: scale(1); }
        }
        .modal-box h5 { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
        .modal-box p  { font-size: .875rem; color: var(--text-muted); margin-bottom: 20px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }

        /* ========== SCROLL TO TOP ========== */
        .scroll-top-btn {
            position: fixed; bottom: 24px; right: 24px;
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--primary); color: #fff; border: none;
            cursor: pointer; box-shadow: 0 4px 12px rgba(16,185,129,.4);
            display: none; align-items: center; justify-content: center;
            font-size: .9rem; transition: all .2s; z-index: 500;
        }
        .scroll-top-btn.show { display: flex; }
        .scroll-top-btn:hover { transform: translateY(-2px); }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ========== SIDEBAR ========== -->
<aside class="wali-sidebar" id="waliSidebar">
    <!-- Brand -->
    <a class="sidebar-brand" href="{{ route('wali.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-mosque"></i>
        </div>
        <div>
            <div class="sidebar-brand-text">Portal Wali</div>
            <div class="sidebar-brand-sub">Manajemen Data Santri</div>
        </div>
    </a>

    <!-- Nav -->
    <p class="sidebar-section-label">Menu Utama</p>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('wali.dashboard') }}"
               class="{{ request()->routeIs('wali.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-house"></i></span>
                Beranda
            </a>
        </li>
        <li>
            <a href="{{ route('wali.santri.index') }}"
               class="{{ request()->routeIs('wali.santri.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-user-graduate"></i></span>
                Data Santri Saya
            </a>
        </li>
    </ul>

    <!-- Footer / User -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::guard('wali')->user()->nama_wali, 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Auth::guard('wali')->user()->nama_wali }}</div>
                <div class="sidebar-user-role">Wali Santri</div>
            </div>
            <button class="sidebar-logout-btn" onclick="document.getElementById('logoutModal').classList.add('show')"
                    title="Keluar">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </div>
    </div>
</aside>

<!-- ========== TOPBAR ========== -->
<header class="wali-topbar">
    <div style="display:flex;align-items:center;">
        <button class="topbar-hamburger" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title">
            <h1>@yield('page-title', 'Portal Wali Santri')</h1>
            <p>@yield('page-subtitle', '')</p>
        </div>
    </div>
    <div class="topbar-right">
        <div class="topbar-date">
            <i class="fas fa-calendar-days" style="color:var(--primary);"></i>
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM Y') }}
        </div>
        <div class="topbar-avatar" title="{{ Auth::guard('wali')->user()->nama_wali }}">
            {{ strtoupper(substr(Auth::guard('wali')->user()->nama_wali, 0, 1)) }}
        </div>
    </div>
</header>

<!-- ========== MAIN ========== -->
<main class="wali-main">
    <div class="wali-content">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="flash-alert flash-success" id="flashSuccess">
            <i class="fas fa-circle-check"></i>
            <span><strong>Berhasil!</strong> {{ session('success') }}</span>
            <button class="flash-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash-alert flash-error" id="flashError">
            <i class="fas fa-circle-exclamation"></i>
            <span><strong>Kesalahan!</strong> {{ session('error') }}</span>
            <button class="flash-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
        </div>
        @endif

        @yield('content')

    </div>

    <footer class="wali-footer">
        &copy; {{ date('Y') }} Sistem Manajemen Data Santri &mdash; All rights reserved.
    </footer>
</main>

<!-- ========== MOBILE BOTTOM NAV ========== -->
<nav class="mobile-bottom-nav" id="mobileBottomNav">
    <a href="{{ route('wali.dashboard') }}"
       class="mobile-nav-item {{ request()->routeIs('wali.dashboard') ? 'active' : '' }}">
        <i class="fas fa-house"></i>
        <span>Beranda</span>
    </a>
    <a href="{{ route('wali.santri.index') }}"
       class="mobile-nav-item {{ request()->routeIs('wali.santri.*') ? 'active' : '' }}">
        <i class="fas fa-user-graduate"></i>
        <span>Data Santri</span>
    </a>
    <button class="mobile-nav-item logout-btn"
            onclick="document.getElementById('logoutModal').classList.add('show')">
        <i class="fas fa-right-from-bracket"></i>
        <span>Keluar</span>
    </button>
</nav>

<!-- ========== LOGOUT MODAL ========== -->
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <h5><i class="fas fa-right-from-bracket" style="color:#ef4444;margin-right:8px;"></i>Konfirmasi Keluar</h5>
        <p>Apakah Anda yakin ingin keluar dari Portal Wali? Sesi Anda akan diakhiri.</p>
        <div class="modal-actions">
            <button class="btn btn-outline btn-sm" onclick="document.getElementById('logoutModal').classList.remove('show')">
                Batal
            </button>
            <form action="{{ route('wali.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-right-from-bracket"></i> Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Scroll to Top -->
<button class="scroll-top-btn" id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
    // Sidebar toggle (mobile)
    const sidebar  = document.getElementById('waliSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggleBtn= document.getElementById('sidebarToggle');
    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });

    // Scroll to top button
    const scrollBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', () => {
        scrollBtn.classList.toggle('show', window.scrollY > 200);
    });

    // Auto-dismiss flash after 5s
    setTimeout(() => {
        document.getElementById('flashSuccess')?.remove();
        document.getElementById('flashError')?.remove();
    }, 5000);
</script>

@stack('scripts')
</body>
</html>
