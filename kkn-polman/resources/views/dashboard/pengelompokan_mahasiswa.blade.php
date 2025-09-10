<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelompokan Mahasiswa - Sistem Informasi KKN</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
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
            padding: 20px 0;
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
            display: flex;
            align-items: center;
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

        /* Grouping Container */
        .grouping-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .grouping-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .grouping-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .grouping-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Filters Section */
        .filters-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .filter-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            width: 100%;
            transition: all 0.3s;
        }

        .filter-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        /* Groups Grid */
        .groups-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .group-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .group-card:hover {
            transform: translateY(-5px);
        }

        .group-header {
            background: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .group-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .group-location {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .group-body {
            padding: 20px;
        }

        .group-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark-color);
        }

        .members-list {
            margin-top: 15px;
        }

        .members-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eaeaea;
        }

        .member-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .member-item:last-child {
            border-bottom: none;
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
        }

        .member-details {
            flex: 1;
        }

        .member-name {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .member-faculty {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .group-actions {
            padding: 15px 20px;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
        }

        .btn-group {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-group:hover {
            background: var(--dark-color);
            color: white;
        }

        .btn-group i {
            margin-right: 5px;
        }

        /* Statistics Section */
        .stats-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: var(--light-color);
            border-radius: 10px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Action Buttons */
        .grouping-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .groups-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

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

            .groups-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .group-info {
                grid-template-columns: 1fr;
            }

            .grouping-actions {
                flex-direction: column;
            }

            .grouping-actions .btn {
                width: 100%;
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
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pendaftaran">
                        <i class="fas fa-user-plus"></i> <span>Pendaftaran</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Data Diri">
                        <i class="fas fa-user"></i> <span>Data Diri</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Data Akademik">
                        <i class="fas fa-graduation-cap"></i> <span>Data Akademik</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengelompokan">
                        <i class="fas fa-users"></i> <span>Pengelompokan</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pembekalan">
                        <i class="fas fa-chalkboard-teacher"></i> <span>Pembekalan</span>
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
                                <span class="d-none d-md-inline">Ahmad Rizky</span>
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
            <div class="grouping-container">
                <!-- Header -->
                <div class="grouping-header">
                    <h1><i class="fas fa-users me-2"></i> Pengelompokan Mahasiswa KKN</h1>
                    <p>Informasi kelompok dan anggota KKN periode 2023</p>
                </div>

                <!-- Filters Section -->
                <div class="filters-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Lokasi KKN</label>
                                <select class="filter-select">
                                    <option value="">Semua Lokasi</option>
                                    <option value="bandung">Kabupaten Bandung</option>
                                    <option value="garut">Kabupaten Garut</option>
                                    <option value="sumedang">Kabupaten Sumedang</option>
                                    <option value="ciamis">Kabupaten Ciamis</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Fakultas</label>
                                <select class="filter-select">
                                    <option value="">Semua Fakultas</option>
                                    <option value="fik">Fakultas Ilmu Komputer</option>
                                    <option value="ft">Fakultas Teknik</option>
                                    <option value="fe">Fakultas Ekonomi</option>
                                    <option value="fh">Fakultas Hukum</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Kelompok</label>
                                <select class="filter-select">
                                    <option value="">Semua Kelompok</option>
                                    <option value="1">Kelompok 1</option>
                                    <option value="2">Kelompok 2</option>
                                    <option value="3">Kelompok 3</option>
                                    <option value="4">Kelompok 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label class="filter-label">Status</label>
                                <select class="filter-select">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="stats-section">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">24</div>
                            <div class="stat-label">Total Kelompok</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">120</div>
                            <div class="stat-label">Total Mahasiswa</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">8</div>
                            <div class="stat-label">Lokasi KKN</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">5</div>
                            <div class="stat-label">Dosen Pembimbing</div>
                        </div>
                    </div>
                </div>

                <!-- Groups Grid -->
                <div class="groups-grid">
                    <!-- Group 1 -->
                    <div class="group-card">
                        <div class="group-header">
                            <div class="group-name">Kelompok 1</div>
                            <div class="group-location">Desa Sukamaju, Kec. Cimenyan</div>
                        </div>
                        <div class="group-body">
                            <div class="group-info">
                                <div class="info-item">
                                    <span class="info-label">Dosen Pembimbing</span>
                                    <span class="info-value">Dr. Surya Adi, M.Kom.</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Jumlah Anggota</span>
                                    <span class="info-value">5 Mahasiswa</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Periode</span>
                                    <span class="info-value">Jul - Agu 2023</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="info-value" style="color: #28a745;">Aktif</span>
                                </div>
                            </div>

                            <div class="members-list">
                                <div class="members-title">Anggota Kelompok</div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Ahmad Rizky (Ketua)</div>
                                        <div class="member-faculty">Teknik Informatika</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Siti Nurhaliza</div>
                                        <div class="member-faculty">Sistem Informasi</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Budi Santoso</div>
                                        <div class="member-faculty">Teknik Elektro</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group-actions">
                            <a href="#" class="btn-group">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>

                    <!-- Group 2 -->
                    <div class="group-card">
                        <div class="group-header">
                            <div class="group-name">Kelompok 2</div>
                            <div class="group-location">Desa Cihanjuang, Kec. Cimahi</div>
                        </div>
                        <div class="group-body">
                            <div class="group-info">
                                <div class="info-item">
                                    <span class="info-label">Dosen Pembimbing</span>
                                    <span class="info-value">Prof. Dr. Ani Wijayanti</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Jumlah Anggota</span>
                                    <span class="info-value">5 Mahasiswa</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Periode</span>
                                    <span class="info-value">Jul - Agu 2023</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="info-value" style="color: #28a745;">Aktif</span>
                                </div>
                            </div>

                            <div class="members-list">
                                <div class="members-title">Anggota Kelompok</div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Rina Wijaya (Ketua)</div>
                                        <div class="member-faculty">Manajemen</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Dewi Kusuma</div>
                                        <div class="member-faculty">Akuntansi</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Fajar Nugraha</div>
                                        <div class="member-faculty">Teknik Mesin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group-actions">
                            <a href="#" class="btn-group">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>

                    <!-- Group 3 -->
                    <div class="group-card">
                        <div class="group-header">
                            <div class="group-name">Kelompok 3</div>
                            <div class="group-location">Desa Mekarjaya, Kec. Arjasari</div>
                        </div>
                        <div class="group-body">
                            <div class="group-info">
                                <div class="info-item">
                                    <span class="info-label">Dosen Pembimbing</span>
                                    <span class="info-value">Dr. Hendra Gunawan, M.Si.</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Jumlah Anggota</span>
                                    <span class="info-value">5 Mahasiswa</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Periode</span>
                                    <span class="info-value">Jul - Agu 2023</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="info-value" style="color: #ffc107;">Menunggu</span>
                                </div>
                            </div>

                            <div class="members-list">
                                <div class="members-title">Anggota Kelompok</div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Indra Pratama (Ketua)</div>
                                        <div class="member-faculty">Teknik Sipil</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Maya Sari</div>
                                        <div class="member-faculty">Ilmu Komunikasi</div>
                                    </div>
                                </div>
                                <div class="member-item">
                                    <img src="https://via.placeholder.com/40" alt="Member" class="member-avatar">
                                    <div class="member-details">
                                        <div class="member-name">Rizky Abdullah</div>
                                        <div class="member-faculty">Psikologi</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group-actions">
                            <a href="#" class="btn-group">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grouping-actions">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i> Unduh Daftar Kelompok
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-print me-2"></i> Cetak Kartu Anggota
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Sidebar toggle
            const sidebar = $('#sidebar');
            const content = $('#content');
            const navbar = $('.navbar');
            const sidebarCollapse = $('#sidebarCollapse');

            sidebarCollapse.on('click', function() {
                sidebar.toggleClass('collapsed');
                content.toggleClass('collapsed');

                // Toggle icon
                const icon = $(this).find('i');
                if (sidebar.hasClass('collapsed')) {
                    icon.removeClass('fa-bars').addClass('fa-chevron-right');
                } else {
                    icon.removeClass('fa-chevron-right').addClass('fa-bars');
                }
            });

            // Initialize tooltips when sidebar is collapsed
            function initTooltips() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }

            function destroyTooltips() {
                $('.tooltip').remove();
            }

            // Check sidebar state and init tooltips
            if (sidebar.hasClass('collapsed')) {
                initTooltips();
            }

            // Re-init tooltips when sidebar state changes
            sidebarCollapse.on('click', function() {
                if (sidebar.hasClass('collapsed')) {
                    initTooltips();
                } else {
                    destroyTooltips();
                }
            });

            // Filter functionality
            $('.filter-select').on('change', function() {
                // Simulate filtering
                const location = $('#location-filter').val();
                const faculty = $('#faculty-filter').val();
                const group = $('#group-filter').val();

                // In a real application, you would filter the groups here
                console.log('Filtering by:', { location, faculty, group });
            });
        });
    </script>
</body>
</html>
