<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Admin Panel') | Manajemen Santri</title>

    <!-- Google Fonts: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SB Admin 2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
    {{-- Logo Kecil --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @stack('styles')

    <style>
    /* ===================================================
       ADMIN RESPONSIVE — Mobile / HP Support
       SB Admin 2 sudah responsif untuk sidebar,
       kita tambahkan penyesuaian khusus HP di bawah.
    =================================================== */

    /* Bottom Navigation Bar — khusus HP (< 768px) */
    .admin-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 60px;
        background: #fff;
        border-top: 1px solid #e3e6f0;
        z-index: 2000;
        padding: 0 4px;
        justify-content: space-around;
        align-items: center;
        box-shadow: 0 -3px 12px rgba(0,0,0,.08);
    }
    .admin-bottom-nav .abn-item {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 2px; flex: 1;
        text-decoration: none;
        color: #b7b9cc;
        font-size: .6rem; font-weight: 700;
        padding: 6px 2px;
        border-radius: 8px;
        transition: color .2s;
        border: none; background: none; cursor: pointer;
        letter-spacing: .02em;
        text-transform: uppercase;
    }
    .admin-bottom-nav .abn-item i { font-size: 1rem; }
    .admin-bottom-nav .abn-item.active { color: #4e73df; }
    .admin-bottom-nav .abn-item:hover  { color: #4e73df; }
    .admin-bottom-nav .abn-item.logout { color: #e74a3b; }

    @media (max-width: 768px) {
        /* Tampilkan bottom nav */
        .admin-bottom-nav { display: flex; }

        /* Tambahkan padding bawah agar konten tidak tertutup bottom nav */
        #content-wrapper { padding-bottom: 62px; }

        /* Topbar lebih ringkas */
        .topbar .navbar-brand { font-size: .85rem; }

        /* Page heading stack di mobile */
        .d-sm-flex.align-items-center.justify-content-between {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px;
        }
        .d-sm-flex .btn, .d-sm-flex div { width: 100%; }
        .d-sm-flex div .btn { width: 100%; margin: 2px 0; }

        /* Filter form — full width di HP */
        .form-inline .input-group,
        .form-inline .form-control,
        .form-inline select.form-control {
            width: 100% !important;
            margin-right: 0 !important;
        }
        .form-inline { flex-direction: column; align-items: stretch; gap: 8px; }
        .form-inline .btn { width: 100%; }

        /* Tabel — horizontal scroll sudah ada (.table-responsive), perkecil font */
        .table td, .table th { font-size: .8rem; padding: .5rem .6rem; }

        /* Tombol aksi di tabel — lebih kecil */
        .action-buttons .btn { padding: .25rem .4rem; font-size: .75rem; }

        /* Card header font */
        .card-header h6 { font-size: .85rem; }

        /* Modal lebih besar di HP */
        .modal-dialog { margin: .5rem; max-width: calc(100% - 1rem); }
        .modal-footer { flex-wrap: wrap; gap: 8px; }
        .modal-footer .btn { flex: 1; min-width: 120px; }

        /* Footer tersembunyi (diganti bottom nav) */
        .sticky-footer { display: none; }

        /* Stat cards stat text */
        .card-body .h5 { font-size: 1.1rem; }

        /* Scroll ke atas atas bottom nav */
        .scroll-to-top { bottom: 70px !important; }
    }

    @media (max-width: 480px) {
        .table td, .table th { font-size: .75rem; padding: .4rem .45rem; }
        .card-body { padding: .85rem; }
        #content { padding: 0; }
        .container-fluid { padding-left: 12px; padding-right: 12px; }
        h1.h3 { font-size: 1.1rem; }
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Data Santri</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item: Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Data Master</div>

            <!-- Nav Item: Data Santri -->
            <li class="nav-item {{ request()->routeIs('admin.santri.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.santri.index') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Data Santri</span>
                </a>
            </li>

            <!-- Nav Item: Akun Wali -->
            <li class="nav-item {{ request()->routeIs('admin.wali.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.wali.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Akun Wali Santri</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Page Title -->
                    <div class="d-none d-sm-inline-block mr-auto">
                        <h1 class="h5 mb-0 text-gray-800 font-weight-bold">@yield('page-title')</h1>
                        <p class="mb-0 text-xs text-muted">@yield('page-subtitle')</p>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item: Tanggal -->
                        <li class="nav-item d-none d-sm-flex align-items-center mr-3">
                            <span class="text-muted small">
                                <i class="fas fa-calendar-alt fa-fw mr-1 text-primary"></i>
                                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                            </span>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item: User Info -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-bold">
                                    {{ Auth::guard('admin')->user()->nama_admin }}
                                </span>
                                <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center"
                                     style="width:40px;height:40px;color:#fff;font-weight:700;font-size:1rem;">
                                    {{ strtoupper(substr(Auth::guard('admin')->user()->nama_admin, 0, 1)) }}
                                </div>
                            </a>

                            <!-- Dropdown: User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <div class="dropdown-header py-3">
                                    <p class="mb-0 font-weight-bold text-primary">{{ Auth::guard('admin')->user()->nama_admin }}</p>
                                    <p class="mb-0 small text-muted">Administrator</p>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong>Terjadi Kesalahan!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @yield('content')

                </div>
                <!-- End of Page Content -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; {{ date('Y') }} Sistem Manajemen Data Santri. All rights reserved.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- ======= MOBILE BOTTOM NAV (Admin) ======= -->
    <nav class="admin-bottom-nav" id="adminBottomNav">
        <a href="{{ route('admin.dashboard') }}"
           class="abn-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.santri.index') }}"
           class="abn-item {{ request()->routeIs('admin.santri.*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i>
            <span>Santri</span>
        </a>
        <a href="{{ route('admin.wali.index') }}"
           class="abn-item {{ request()->routeIs('admin.wali.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Akun Wali</span>
        </a>
        <button class="abn-item logout"
                data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </button>
    </nav>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Keluar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin keluar dari sistem?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Ya, Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SB Admin 2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

    @stack('scripts')
</body>
</html>
