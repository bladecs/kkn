<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Informasi KKN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e4fbe;
            --secondary-color: #2c6de9;
            --light-color: #e8f0fe;
            --dark-color: #0a2a75;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: var(--dark-color);
            text-align: center;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-header {
            padding: 20px 10px;
        }

        #sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        #sidebar.collapsed .sidebar-header p {
            display: none;
        }

        #sidebar ul.components {
            transition: all 0.3s ease;
            flex-grow: 1;
        }

        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed ul li a {
            padding: 15px;
            text-align: center;
        }

        #sidebar.collapsed ul li a span {
            display: none;
        }

        #sidebar ul li a:hover {
            background: var(--secondary-color);
            color: white;
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        #sidebar.collapsed ul li a i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        #sidebar ul li.active > a {
            background: var(--secondary-color);
            color: white;
        }

        /* Sidebar footer */
        #sidebar .sidebar-footer {
            padding: 15px;
            margin-top: auto;
        }

        #sidebar.collapsed .sidebar-footer {
            padding: 15px 5px;
        }

        #sidebar.collapsed .sidebar-footer .btn span {
            display: none;
        }

        #sidebar.collapsed .sidebar-footer .btn i {
            margin-right: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 999;
            transition: all 0.3s ease;
        }

        #content.collapsed .navbar {
            left: var(--sidebar-collapsed-width);
        }

        /* Content Styles */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            padding-top: 80px;
        }

        #content.collapsed {
            width: calc(100% - var(--sidebar-collapsed-width));
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Card Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            text-align: center;
            padding: 20px;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eaeaea;
        }

        .section-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 15px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
            text-decoration: none;
            color: #495057;
        }

        .menu-item:hover {
            background: var(--light-color);
            border-left-color: var(--primary-color);
            color: var(--dark-color);
        }

        .menu-item i {
            font-size: 1.1rem;
            color: var(--primary-color);
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .menu-item span {
            flex: 1;
            font-weight: 500;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .phase {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin: 0 5px;
            background: white;
            border-radius: 20px;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .phase.active {
            background: var(--primary-color);
            color: white;
            transform: scale(1.05);
        }

        .phase i {
            margin-right: 8px;
        }

        /* Dropdown menu styles */
        .dropdown-menu-container {
            position: relative;
        }

        .dropdown-menu-custom {
            display: none;
            position: static;
            float: none;
            width: 100%;
            margin: 5px 0 15px 0;
            padding: 0;
            background-color: transparent;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .dropdown-menu-custom.show {
            display: block;
        }

        .dropdown-toggle::after {
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(90deg);
        }

        .dropdown-menu-item {
            padding-left: 50px !important;
            background-color: #f0f4f8;
            margin-bottom: 5px;
            border-left: 3px solid transparent;
        }

        .dropdown-menu-item:hover {
            background-color: #e2e8f0 !important;
            border-left-color: var(--primary-color);
        }

        /* Tooltip for collapsed sidebar */
        #sidebar.collapsed ul li a[data-bs-toggle="tooltip"] {
            position: relative;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
                width: var(--sidebar-width);
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
                margin-left: 0;
                padding-top: 0;
            }

            #content.active {
                width: calc(100% - var(--sidebar-width));
                margin-left: var(--sidebar-width);
            }

            #sidebar.collapsed {
                margin-left: -var(--sidebar-collapsed-width);
                width: var(--sidebar-collapsed-width);
            }

            #content.collapsed {
                width: 100%;
                margin-left: 0;
            }

            .navbar {
                left: 0;
                right: 0;
            }

            #content.collapsed .navbar {
                left: 0;
            }

            .phase-indicator {
                flex-wrap: wrap;
            }

            .phase {
                margin-bottom: 10px;
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch ">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap me-2"></i> SIKKN</h3>
                <p class="mb-0 text-light">Sistem Informasi KKN</p>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Penerjunan">
                        <i class="fas fa-rocket"></i> <span>Penerjunan</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pelaksanaan">
                        <i class="fas fa-cogs"></i> <span>Pelaksanaan</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pelaporan">
                        <i class="fas fa-file-alt"></i> <span>Pelaporan</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Statistik">
                        <i class="fas fa-chart-bar"></i> <span>Statistik</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengaturan">
                        <i class="fas fa-cog"></i> <span>Pengaturan</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Bantuan">
                        <i class="fas fa-question-circle"></i> <span>Bantuan</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://via.placeholder.com/40" alt="User" width="40" height="40" class="rounded-circle me-2">
                                <span class="d-none d-md-inline">Nama Mahasiswa</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid p-4">
                <!-- Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body py-4">
                                <h1 class="card-title"><i class="fas fa-graduation-cap me-2"></i> Sistem Informasi KKN</h1>
                                <p class="card-text mb-0">Kuliah Kerja Nyata - Universitas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phase Indicator -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-center phase-indicator">
                                    <div class="phase active">
                                        <i class="fas fa-user-plus"></i>
                                        Pendaftaran
                                    </div>
                                    <div class="phase">
                                        <i class="fas fa-rocket"></i>
                                        Penerjunan
                                    </div>
                                    <div class="phase">
                                        <i class="fas fa-cogs"></i>
                                        Pelaksanaan
                                    </div>
                                    <div class="phase">
                                        <i class="fas fa-file-alt"></i>
                                        Pelaporan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="stat-icon"><i class="fas fa-users"></i></div>
                                <div class="stat-number">1,247</div>
                                <div class="stat-label">Mahasiswa Terdaftar</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="stat-number">85</div>
                                <div class="stat-label">Lokasi KKN</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                                <div class="stat-number">42</div>
                                <div class="stat-label">Dosen Pembimbing</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card stat-card">
                            <div class="card-body">
                                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                                <div class="stat-number">45</div>
                                <div class="stat-label">Hari Tersisa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Grid -->
                <div class="d-flex flex-grow gap-4 justify-content-between">
                    <!-- Tahap Persiapan -->
                    <div class="flex-fill mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="section-header">
                                    <i class="fas fa-clipboard-list section-icon"></i>
                                    <h5 class="section-title">Tahap Persiapan</h5>
                                </div>

                                <!-- Dropdown for Pendaftaran KKN with Kelengkapan Persyaratan inside -->
                                <div class="dropdown-menu-container mb-2">
                                    <a href="#" class="menu-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-plus"></i>
                                        <span>Pendaftaran KKN</span>
                                    </a>
                                    <div class="dropdown-menu-custom">
                                        <a href="{{ route('formulir') }}" class="menu-item dropdown-menu-item">
                                            <i class="fas fa-file-medical"></i>
                                            <span>Formulir Pendaftaran</span>
                                        </a>
                                        <a href="{{ route('data-diri') }}" class="menu-item dropdown-menu-item">
                                            <i class="fas fa-id-card"></i>
                                            <span>Data Pribadi</span>
                                        </a>
                                        <a href="{{ route('data-akademik') }}" class="menu-item dropdown-menu-item">
                                            <i class="fas fa-university"></i>
                                            <span>Data Akademik</span>
                                        </a>
                                    </div>
                                </div>

                                <a href="{{ route('pengelompokan') }}" class="menu-item">
                                    <i class="fas fa-users-cog"></i>
                                    <span>Pengelompokan Mahasiswa</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-map-marked-alt"></i>
                                    <span>Penetapan Lokasi</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap Pelaksanaan -->
                    <div class="flex-fill mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="section-header">
                                    <i class="fas fa-cogs section-icon"></i>
                                    <h5 class="section-title">Pelaksanaan Kegiatan</h5>
                                </div>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>Kegiatan Harian</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-tasks"></i>
                                    <span>Program Kerja</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Monitoring & Evaluasi</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-camera"></i>
                                    <span>Dokumentasi Kegiatan</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap Pelaporan -->
                    <div class="flex-fill mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="section-header">
                                    <i class="fas fa-file-alt section-icon"></i>
                                    <h5 class="section-title">Pelaporan & Evaluasi</h5>
                                </div>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-file-invoice"></i>
                                    <span>Laporan Harian</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-file-contract"></i>
                                    <span>Laporan Akhir</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-presentation"></i>
                                    <span>Responsi/Ujian Akhir</span>
                                </a>
                                <a href="#" class="menu-item">
                                    <i class="fas fa-award"></i>
                                    <span>Sertifikat KKN</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional content to enable scrolling -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Informasi Tambahan</h5>
                                <p>Berikut adalah beberapa informasi tambahan untuk mengisi konten halaman:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Jadwal Penting</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item">Pendaftaran KKN: 1 Januari - 31 Januari 2023</li>
                                            <li class="list-group-item">Pembekalan: 15 Februari 2023</li>
                                            <li class="list-group-item">Penerjunan: 1 Marcel 2023</li>
                                            <li class="list-group-item">Pelaksanaan: 1 Maret - 30 Juni 2023</li>
                                            <li class="list-group-item">Pelaporan: 1 Juli - 15 Juli 2023</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Pengumuman Terbaru</h6>
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">Panduan KKN 2023</h6>
                                                    <small>3 hari yang lalu</small>
                                                </div>
                                                <p class="mb-1">Panduan lengkap KKN tahun 2023 telah tersedia.</p>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">Pembagian Kelompok</h6>
                                                    <small>1 minggu yang lalu</small>
                                                </div>
                                                <p class="mb-1">Pembagian kelompok KKN telah diumumkan.</p>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">Seminar KKN</h6>
                                                    <small>2 minggu yang lalu</small>
                                                </div>
                                                <p class="mb-1">Jadwal seminar hasil KKN telah ditetapkan.</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- More content to enable scrolling -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Galeri Kegiatan KKN</h5>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="https://via.placeholder.com/300x200?text=KKN+1" class="card-img-top" alt="KKN 1">
                                            <div class="card-body">
                                                <p class="card-text">Kegiatan pembangunan fasilitas umum</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="https://via.placeholder.com/300x200?text=KKN+2" class="card-img-top" alt="KKN 2">
                                            <div class="card-body">
                                                <p class="card-text">Penyuluhan kesehatan masyarakat</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="https://via.placeholder.com/300x200?text=KKN+3" class="card-img-top" alt="KKN 3">
                                            <div class="card-body">
                                                <p class="card-text">Pelatihan keterampilan warga</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img src="https://via.placeholder.com/300x200?text=KKN+4" class="card-img-top" alt="KKN 4">
                                            <div class="card-body">
                                                <p class="card-text">Kegiatan pendidikan anak-anak</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const navbar = document.querySelector('.navbar');
            const sidebarCollapse = document.getElementById('sidebarCollapse');

            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');

                // Adjust navbar position
                if (sidebar.classList.contains('collapsed')) {
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-collapsed-width');
                } else {
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width');
                }

                // Toggle icon
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-bars');
                }

                // Initialize tooltips when sidebar is collapsed
                if (sidebar.classList.contains('collapsed')) {
                    initTooltips();
                } else {
                    destroyTooltips();
                }
            });

            // Initialize tooltips
            function initTooltips() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            function destroyTooltips() {
                const tooltipList = document.querySelectorAll('.tooltip');
                tooltipList.forEach(tooltip => {
                    tooltip.remove();
                });
            }

            // Phase indicator animation
            const phases = document.querySelectorAll('.phase');
            let currentPhase = 0;

            setInterval(() => {
                phases[currentPhase].classList.remove('active');
                currentPhase = (currentPhase + 1) % phases.length;
                phases[currentPhase].classList.add('active');
            }, 3000);

            // Update stats dynamically (simulation)
            function updateStats() {
                const statNumbers = document.querySelectorAll('.stat-number');
                statNumbers.forEach(stat => {
                    const currentValue = parseInt(stat.textContent.replace(',', ''));
                    const newValue = currentValue + Math.floor(Math.random() * 5);
                    stat.textContent = newValue.toLocaleString();
                });
            }

            // Update stats every 30 seconds
            setInterval(updateStats, 30000);

            // Handle dropdown menu toggles
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdown = this.nextElementSibling;
                    const isShowing = dropdown.classList.contains('show');

                    // Close all dropdowns first
                    document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                        menu.classList.remove('show');
                    });

                    document.querySelectorAll('.dropdown-toggle').forEach(t => {
                        t.setAttribute('aria-expanded', 'false');
                        const chevron = t.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.remove('fa-rotate-90');
                        }
                    });

                    // Toggle current dropdown if it wasn't already showing
                    if (!isShowing) {
                        dropdown.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        const chevron = this.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.add('fa-rotate-90');
                        }
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-toggle')) {
                    document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                        menu.classList.remove('show');
                    });

                    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                        toggle.setAttribute('aria-expanded', 'false');
                        const chevron = toggle.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.remove('fa-rotate-90');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
