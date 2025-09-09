<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Diri - Sistem Informasi KKN</title>
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

        /* Profile Container */
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .profile-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .profile-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--light-color);
            margin-bottom: 20px;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .profile-nim {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .profile-status {
            display: inline-block;
            padding: 5px 15px;
            background: var(--light-color);
            color: var(--primary-color);
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
        }

        .info-label {
            min-width: 150px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .info-value {
            color: #495057;
            flex: 1;
        }

        /* Action Buttons */
        .profile-actions {
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

            .info-item {
                flex-direction: column;
                margin-bottom: 20px;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }

            .profile-actions {
                flex-direction: column;
            }

            .profile-actions .btn {
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
                <li class="active">
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Data Diri">
                        <i class="fas fa-user"></i> <span>Data Diri</span>
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
            <div class="profile-container">
                <!-- Header -->
                <div class="profile-header">
                    <h1><i class="fas fa-user me-2"></i> Data Diri Mahasiswa</h1>
                    <p>Informasi lengkap data pribadi dan akademik Anda</p>
                </div>

                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-info">
                        <img src="https://via.placeholder.com/150" alt="Profile" class="profile-avatar">
                        <h2 class="profile-name">Ahmad Rizky</h2>
                        <div class="profile-nim">NIM: 1234567890</div>
                        <div class="profile-status">Aktif</div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-user-circle"></i> Data Pribadi</h3>

                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">Ahmad Rizky</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">NIM</div>
                            <div class="info-value">1234567890</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Tempat, Tanggal Lahir</div>
                            <div class="info-value">Bandung, 15 Januari 2000</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jenis Kelamin</div>
                            <div class="info-value">Laki-laki</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">ahmad.rizky@example.com</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Nomor Telepon</div>
                            <div class="info-value">081234567890</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Alamat</div>
                            <div class="info-value">Jl. Merdeka No. 123, Bandung, Jawa Barat</div>
                        </div>
                    </div>

                    <!-- Data Akademik -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Data Akademik</h3>

                        <div class="info-item">
                            <div class="info-label">Fakultas</div>
                            <div class="info-value">Fakultas Ilmu Komputer</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Program Studi</div>
                            <div class="info-value">Teknik Informatika</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Angkatan</div>
                            <div class="info-value">2019</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Semester</div>
                            <div class="info-value">8</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">IPK</div>
                            <div class="info-value">3.75</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jumlah SKS</div>
                            <div class="info-value">144</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">Aktif</div>
                        </div>
                    </div>

                    <!-- Data KKN -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Data KKN</h3>

                        <div class="info-item">
                            <div class="info-label">Status Pendaftaran</div>
                            <div class="info-value">
                                <span class="badge bg-success">Terverifikasi</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Lokasi KKN</div>
                            <div class="info-value">Desa Sukamaju, Kec. Cimenyan, Kab. Bandung</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Kelompok KKN</div>
                            <div class="info-value">Kelompok 15 - Teknologi Informasi</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Dosen Pembimbing</div>
                            <div class="info-value">Dr. Surya Adi, M.Kom.</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Periode KKN</div>
                            <div class="info-value">1 Juli 2023 - 31 Agustus 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i> Edit Data Diri
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-download me-2"></i> Unduh Kartu Peserta
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
        });
    </script>
</body>
</html>
