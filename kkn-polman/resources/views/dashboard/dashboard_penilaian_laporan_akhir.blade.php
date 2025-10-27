<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Akhir - Sistem Informasi KKN</title>
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

        #sidebar ul li.active>a {
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
            margin-bottom: 25px;
            transition: transform 0.3s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
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

        /* Report Card Styles */
        .report-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .report-card.final-report {
            border-left-color: #28a745;
        }

        .report-card.final-report:hover {
            border-left-color: #218838;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-reviewed {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #b8e0e6;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-late {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f1b0b7;
        }

        .status-revision {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .score-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .grade-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            flex: 1;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            transform: translateY(-2px);
        }

        /* Filter Section */
        .filter-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 10px;
            border: none;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .document-preview {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 400px;
        }

        .document-info {
            background-color: #e8f0fe;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        /* Search and Filter */
        .search-box {
            position: relative;
        }

        .search-box .form-control {
            padding-left: 40px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        /* Report Card Content */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .student-main-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            margin-bottom: 2px;
            font-size: 0.95rem;
        }

        .student-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .report-meta {
            text-align: right;
        }

        .report-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        /* Results Indicator */
        .results-indicator {
            background-color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
        }

        .results-count {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.1rem;
        }

        .results-text {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Document Icons */
        .document-icons {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .doc-icon {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: white;
        }

        .doc-pdf {
            background-color: #dc3545;
        }

        .doc-word {
            background-color: #2b579a;
        }

        .doc-ppt {
            background-color: #d24726;
        }

        .doc-zip {
            background-color: #6c757d;
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

            .action-buttons {
                flex-direction: column;
            }

            .report-header {
                flex-direction: column;
                gap: 10px;
            }

            .report-meta {
                text-align: left;
                width: 100%;
            }

            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap me-2"></i> SIKKN</h3>
                <p class="mb-0 text-light">Sistem Informasi KKN</p>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard.html" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
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
                <li class="active">
                    <a href="daftar-laporan-akhir.html" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Penilaian">
                        <i class="fas fa-clipboard-check"></i> <span>Penilaian</span>
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
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://via.placeholder.com/40" alt="User" width="40" height="40"
                                    class="rounded-circle me-2">
                                <span class="d-none d-md-inline">Dr. Ahmad Wijaya, M.Si.</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>
                                        Pengaturan</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>
                                        Logout</a></li>
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
                        <div class="card bg-success text-white">
                            <div class="card-body py-4">
                                <h1 class="card-title"><i class="fas fa-file-contract me-2"></i> Daftar Laporan Akhir
                                    Mahasiswa</h1>
                                <p class="card-text mb-0">Kelola dan nilai laporan akhir/tugas akhir KKN mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="filter-section">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="form-control"
                                            placeholder="Cari nama mahasiswa atau kelompok...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Menunggu Penilaian</option>
                                        <option value="reviewed">Sudah Dinilai</option>
                                        <option value="completed">Selesai</option>
                                        <option value="revision">Perlu Revisi</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select">
                                        <option value="">Semua Periode</option>
                                        <option value="2023-1">Januari - Juni 2023</option>
                                        <option value="2023-2">Juli - Desember 2023</option>
                                        <option value="2024-1">Januari - Juni 2024</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success w-100">
                                        <i class="fas fa-filter me-2"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <h3 class="card-title">8</h3>
                                <p class="card-text">Menunggu Penilaian</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-success mb-2">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <h3 class="card-title">15</h3>
                                <p class="card-text">Sudah Dinilai</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-edit fa-2x"></i>
                                </div>
                                <h3 class="card-title">6</h3>
                                <p class="card-text">Perlu Revisi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-info mb-2">
                                    <i class="fas fa-graduation-cap fa-2x"></i>
                                </div>
                                <h3 class="card-title">29</h3>
                                <p class="card-text">Total Laporan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Indicator -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="results-indicator">
                            <span class="results-count">12 Laporan Akhir Ditemukan</span>
                            <span class="results-text"> - Menampilkan semua laporan akhir mahasiswa periode Januari -
                                Juni 2024</span>
                        </div>
                    </div>
                </div>

                <!-- Reports List - 4 cards per row on large screens, 3 on medium -->
                <div class="row" id="reportsList">
                    <!-- Report Card 1 - Kelompok -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 1 - Desa Sukamaju</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">5 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">28 Juni 2024</div>
                                        <span class="status-badge status-pending">Menunggu</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                    <span class="doc-icon doc-zip" title="Lampiran"><i
                                            class="fas fa-file-archive"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit me-1"></i> Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 2 - Kelompok dengan Nilai -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 2 - Desa Sukaasih</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">6 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">27 Juni 2024</div>
                                        <span class="grade-badge">A (92/100)</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                    <span class="doc-icon doc-word" title="Dokumen Tambahan"><i
                                            class="fas fa-file-word"></i></span>
                                    <span class="doc-icon doc-zip" title="Lampiran"><i
                                            class="fas fa-file-archive"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-redo me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 3 - Kelompok Perlu Revisi -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 3 - Desa Mekarsari</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">5 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">29 Juni 2024</div>
                                        <span class="status-badge status-revision">Revisi</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i> Review
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 4 - Kelompok Selesai -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 4 - Desa Cipadung</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">4 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">26 Juni 2024</div>
                                        <span class="status-badge status-completed">Selesai</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                    <span class="doc-icon doc-zip" title="Lampiran"><i
                                            class="fas fa-file-archive"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-redo me-1"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 5 - Kelompok dengan Nilai B -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 5 - Desa Sindangreret</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">6 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">25 Juni 2024</div>
                                        <span class="grade-badge">B+ (85/100)</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-redo me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 6 - Kelompok Menunggu -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 6 - Desa Cileunyi</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">5 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">30 Juni 2024</div>
                                        <span class="status-badge status-pending">Menunggu</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                    <span class="doc-icon doc-zip" title="Lampiran"><i
                                            class="fas fa-file-archive"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit me-1"></i> Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 7 - Kelompok dengan Nilai A -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 7 - Desa Pameuntasan</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">4 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">24 Juni 2024</div>
                                        <span class="grade-badge">A- (88/100)</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                    <span class="doc-icon doc-word" title="Dokumen Tambahan"><i
                                            class="fas fa-file-word"></i></span>
                                    <span class="doc-icon doc-zip" title="Lampiran"><i
                                            class="fas fa-file-archive"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-redo me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Card 8 - Kelompok Terlambat -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card report-card final-report">
                            <div class="card-body">
                                <div class="report-header">
                                    <div class="student-main-info">
                                        <div class="student-details">
                                            <div class="student-name">Kelompok 8 - Desa Cimenyan</div>
                                            <div class="student-meta">Periode: Januari - Juni 2024</div>
                                            <div class="student-meta">5 Anggota</div>
                                        </div>
                                    </div>
                                    <div class="report-meta">
                                        <div class="report-date">1 Juli 2024</div>
                                        <span class="status-badge status-late">Terlambat</span>
                                    </div>
                                </div>
                                <div class="document-icons">
                                    <span class="doc-icon doc-pdf" title="Laporan Utama"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <span class="doc-icon doc-ppt" title="Presentasi"><i
                                            class="fas fa-file-powerpoint"></i></span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#previewModal">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                    <a href="form-penilaian-akhir.html" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit me-1"></i> Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load More Button -->
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <button class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i> Muat Lebih Banyak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal untuk Laporan Akhir -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="fas fa-file-contract me-2"></i> Preview Laporan Akhir
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Document Info -->
                    <div class="document-info">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kelompok:</strong> Kelompok 1 - Desa Sukamaju</p>
                                <p class="mb-1"><strong>Periode KKN:</strong> Januari - Juni 2024</p>
                                <p class="mb-1"><strong>Jumlah Anggota:</strong> 5 Mahasiswa</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Pengumpulan:</strong> 28 Juni 2024</p>
                                <p class="mb-1"><strong>Dosen Pembimbing:</strong> Dr. Ahmad Wijaya, M.Si.</p>
                                <p class="mb-0"><strong>Status:</strong> <span
                                        class="status-badge status-pending">Menunggu Penilaian</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Document List -->
                    <div class="mb-4">
                        <h6><i class="fas fa-paperclip me-2"></i> Dokumen Laporan Akhir</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <span>Laporan_Akhir_KKN_Kelompok1_2024.pdf</span>
                                        <small class="text-muted ms-2">(5.2 MB)</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download
                                    </button>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-powerpoint text-warning me-2"></i>
                                        <span>Presentasi_KKN_Kelompok1.pptx</span>
                                        <small class="text-muted ms-2">(8.7 MB)</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download
                                    </button>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-archive text-secondary me-2"></i>
                                        <span>Lampiran_Dokumentasi_Kelompok1.zip</span>
                                        <small class="text-muted ms-2">(15.3 MB)</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Preview -->
                    <div class="document-preview">
                        <div class="text-center py-5">
                            <i class="fas fa-file-contract fa-4x text-success mb-3"></i>
                            <h5>Laporan Akhir KKN - Kelompok 1</h5>
                            <p class="text-muted">Dokumen laporan akhir akan ditampilkan di sini</p>
                            <div class="mt-4">
                                <button class="btn btn-success me-2">
                                    <i class="fas fa-download me-2"></i> Download Semua
                                </button>
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-print me-2"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="form-penilaian-akhir.html" class="btn btn-success">
                        <i class="fas fa-edit me-2"></i> Lanjut ke Penilaian
                    </a>
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
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue(
                        '--sidebar-collapsed-width');
                } else {
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue(
                        '--sidebar-width');
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
            });

            // Search functionality
            const searchInput = document.querySelector('.search-box input');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const reportCards = document.querySelectorAll('.report-card');
                let visibleCount = 0;

                reportCards.forEach(card => {
                    const groupName = card.querySelector('.student-name').textContent.toLowerCase();

                    if (groupName.includes(searchTerm)) {
                        card.parentElement.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                });

                // Update results indicator
                document.querySelector('.results-count').textContent =
                    `${visibleCount} Laporan Akhir Ditemukan`;
            });
        });
    </script>
</body>

</html>
