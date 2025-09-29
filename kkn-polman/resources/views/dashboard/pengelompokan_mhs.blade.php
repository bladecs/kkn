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

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px 25px;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 79, 190, 0.25);
        }

        .modal-footer {
            border-top: 1px solid #eaeaea;
            padding: 20px 25px;
            border-radius: 0 0 15px 15px;
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
                
                <!-- Add Group Button -->
                <div class="d-flex justify-content-end mb-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                        <i class="fas fa-plus me-2"></i> Tambah Kelompok Baru
                    </button>
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

    <!-- Modal Tambah Kelompok -->
    <div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGroupModalLabel">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Kelompok Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGroupForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nimMahasiswa" class="form-label">NIM Mahasiswa</label>
                                    <select class="form-select" id="nimMahasiswa" required>
                                        <option value="" selected disabled>Pilih NIM Mahasiswa</option>
                                        <option value="12345678">12345678 - Ahmad Rizky</option>
                                        <option value="12345679">12345679 - Siti Nurhaliza</option>
                                        <option value="12345680">12345680 - Budi Santoso</option>
                                        <option value="12345681">12345681 - Rina Wijaya</option>
                                        <option value="12345682">12345682 - Dewi Kusuma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nipDosen" class="form-label">NIP Dosen Pembimbing</label>
                                    <select class="form-select" id="nipDosen" required>
                                        <option value="" selected disabled>Pilih NIP Dosen</option>
                                        <option value="198001012003121001">198001012003121001 - Dr. Surya Adi, M.Kom.</option>
                                        <option value="197512102000032002">197512102000032002 - Prof. Dr. Ani Wijayanti</option>
                                        <option value="198205152006041003">198205152006041003 - Dr. Hendra Gunawan, M.Si.</option>
                                        <option value="197803202002121004">197803202002121004 - Dr. Maya Sari, M.T.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lokasiKKN" class="form-label">Lokasi KKN</label>
                                    <select class="form-select" id="lokasiKKN" required>
                                        <option value="" selected disabled>Pilih Lokasi KKN</option>
                                        <option value="bandung">Kabupaten Bandung</option>
                                        <option value="garut">Kabupaten Garut</option>
                                        <option value="sumedang">Kabupaten Sumedang</option>
                                        <option value="ciamis">Kabupaten Ciamis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="namaKelompok" class="form-label">Nama Kelompok</label>
                                    <input type="text" class="form-control" id="namaKelompok" placeholder="Masukkan nama kelompok" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggalMulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggalMulai" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggalSelesai" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" id="judulProjectGroup" style="display: none;">
                            <label for="judulProject" class="form-label">Judul Project</label>
                            <select class="form-select" id="judulProject" disabled>
                                <option value="" selected disabled>Pilih Judul Project</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitGroupBtn">Simpan Kelompok</button>
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

            // Modal functionality - Show/hide judul project based on lokasi selection
            $('#lokasiKKN').on('change', function() {
                const selectedLocation = $(this).val();
                const judulProjectGroup = $('#judulProjectGroup');
                const judulProjectSelect = $('#judulProject');
                
                if (selectedLocation) {
                    // Show judul project section
                    judulProjectGroup.show();
                    judulProjectSelect.prop('disabled', false);
                    
                    // Clear existing options
                    judulProjectSelect.empty();
                    judulProjectSelect.append('<option value="" selected disabled>Pilih Judul Project</option>');
                    
                    // Add options based on selected location
                    let projectOptions = [];
                    
                    switch(selectedLocation) {
                        case 'bandung':
                            projectOptions = [
                                'Pengembangan Sistem Informasi Desa',
                                'Peningkatan Ekonomi Masyarakat melalui UMKM',
                                'Pembuatan Website Promosi Wisata'
                            ];
                            break;
                        case 'garut':
                            projectOptions = [
                                'Pemanfaatan Teknologi untuk Pertanian',
                                'Edukasi Kesehatan Masyarakat',
                                'Pengelolaan Sampah Berbasis Komunitas'
                            ];
                            break;
                        case 'sumedang':
                            projectOptions = [
                                'Digitalisasi Administrasi Desa',
                                'Pelatihan Kewirausahaan Pemuda',
                                'Konservasi Lingkungan Berbasis Teknologi'
                            ];
                            break;
                        case 'ciamis':
                            projectOptions = [
                                'Pengembangan Ekowisata Berkelanjutan',
                                'Peningkatan Literasi Digital Masyarakat',
                                'Sistem Monitoring Kualitas Air'
                            ];
                            break;
                    }
                    
                    // Add options to select
                    projectOptions.forEach(option => {
                        judulProjectSelect.append(`<option value="${option}">${option}</option>`);
                    });
                } else {
                    // Hide judul project section
                    judulProjectGroup.hide();
                    judulProjectSelect.prop('disabled', true);
                }
            });

            // Form submission
            $('#submitGroupBtn').on('click', function() {
                const form = $('#addGroupForm');
                
                // Check if all required fields are filled
                if (form[0].checkValidity()) {
                    // Get form values
                    const nimMahasiswa = $('#nimMahasiswa').val();
                    const nipDosen = $('#nipDosen').val();
                    const lokasiKKN = $('#lokasiKKN').val();
                    const namaKelompok = $('#namaKelompok').val();
                    const tanggalMulai = $('#tanggalMulai').val();
                    const tanggalSelesai = $('#tanggalSelesai').val();
                    const judulProject = $('#judulProject').val();
                    
                    // In a real application, you would send this data to the server
                    console.log('Data kelompok baru:', {
                        nimMahasiswa,
                        nipDosen,
                        lokasiKKN,
                        namaKelompok,
                        tanggalMulai,
                        tanggalSelesai,
                        judulProject
                    });
                    
                    // Show success message and close modal
                    alert('Kelompok berhasil ditambahkan!');
                    $('#addGroupModal').modal('hide');
                    
                    // Reset form
                    form[0].reset();
                    $('#judulProjectGroup').hide();
                    $('#judulProject').prop('disabled', true);
                } else {
                    // Show validation errors
                    form[0].reportValidity();
                }
            });

            // Reset form when modal is closed
            $('#addGroupModal').on('hidden.bs.modal', function() {
                $('#addGroupForm')[0].reset();
                $('#judulProjectGroup').hide();
                $('#judulProject').prop('disabled', true);
            });
        });
    </script>
</body>
</html>