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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
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

        /* Modern Progress Indicator Styles */
        .phase-indicator {
            padding: 20px 0;
        }

        .phase-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 30px 0;
        }

        .phase-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            z-index: 1;
        }

        .phase-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .phase-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 6px;
            background-color: var(--primary-color);
            z-index: 2;
            transform: translateY(-50%);
            transition: all 0.5s ease;
            opacity: 0;
        }

        .phase-step.completed:not(:last-child)::after {
            opacity: 1;
            background: linear-gradient(90deg, var(--success-color) 0%, var(--success-color) 100%);
        }

        .phase-step.active:not(:last-child)::after {
            opacity: 1;
            background: linear-gradient(90deg, var(--success-color) 0%, var(--primary-color) 50%, #e9ecef 100%);
        }

        .phase-indicator-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 3;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1.1rem;
            color: #6c757d;
        }

        .phase-step.completed .phase-indicator-circle {
            background: linear-gradient(135deg, var(--success-color) 0%, #34ce57 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .phase-step.active .phase-indicator-circle {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4d8aff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 79, 190, 0.4);
            transform: scale(1.1);
        }

        .phase-label {
            font-size: 0.85rem;
            text-align: center;
            max-width: 100px;
            margin-top: 5px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .phase-step.completed .phase-label {
            color: var(--success-color);
            font-weight: 600;
        }

        .phase-step.active .phase-label {
            color: var(--primary-color);
            font-weight: 700;
        }

        .phase-date {
            font-size: 0.75rem;
            color: #adb5bd;
            margin-top: 5px;
            text-align: center;
        }

        .phase-status {
            margin-top: 10px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(52, 206, 87, 0.15) 100%);
            color: var(--success-color);
        }

        .status-active {
            background: linear-gradient(135deg, rgba(30, 79, 190, 0.15) 0%, rgba(77, 138, 255, 0.15) 100%);
            color: var(--primary-color);
        }

        .status-pending {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
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

            .phase-steps {
                flex-wrap: wrap;
            }

            .phase-step {
                margin-bottom: 15px;
                flex: 1;
                min-width: 120px;
            }

            .phase-step:not(:last-child)::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        @include('dashboard.mahasiswa.widget.sidebar')

        <!-- Page Content -->
        <div id="content" class="collapsed">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-chevron-right"></i>
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

                <!-- Modern Phase Indicator -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Status KKN</h5>
                                <div class="phase-indicator">
                                    <div class="phase-steps">
                                        <div class="phase-step completed" data-phase="pendaftaran">
                                            <div class="phase-indicator-circle">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                            <div class="phase-label">Pendaftaran</div>
                                            <div class="phase-date">1-31 Jan 2023</div>
                                            <div class="phase-status status-completed">Selesai</div>
                                        </div>
                                        <div class="phase-step active" data-phase="penerjunan">
                                            <div class="phase-indicator-circle">
                                                <i class="fas fa-rocket"></i>
                                            </div>
                                            <div class="phase-label">Penerjunan</div>
                                            <div class="phase-date">1 Mar 2023</div>
                                            <div class="phase-status status-active">Berjalan</div>
                                        </div>
                                        <div class="phase-step" data-phase="pelaksanaan">
                                            <div class="phase-indicator-circle">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <div class="phase-label">Pelaksanaan</div>
                                            <div class="phase-date">1 Mar - 30 Jun 2023</div>
                                            <div class="phase-status status-pending">Menunggu</div>
                                        </div>
                                        <div class="phase-step" data-phase="pelaporan">
                                            <div class="phase-indicator-circle">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="phase-label">Pelaporan</div>
                                            <div class="phase-date">1-15 Jul 2023</div>
                                            <div class="phase-status status-pending">Menunggu</div>
                                        </div>
                                    </div>
                                </div>
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

                                <a href="#" class="menu-item dropdown-menu-item">
                                    <i class="fas fa-file-medical"></i>
                                    <span>Formulir Pendaftaran</span>
                                </a>
                                <a href="#" class="menu-item dropdown-menu-item">
                                    <i class="fas fa-id-card"></i>
                                    <span>Data Pribadi</span>
                                </a>
                                <a href="#" class="menu-item dropdown-menu-item">
                                    <i class="fas fa-university"></i>
                                    <span>Data Akademik</span>
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
                                            <li class="list-group-item">Penerjunan: 1 Maret 2023</li>
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

            // Update phase indicator based on current phase
            function updatePhaseIndicator(currentPhase) {
                const phaseSteps = document.querySelectorAll('.phase-step');
                
                // Reset all indicators
                phaseSteps.forEach(step => {
                    step.classList.remove('completed', 'active');
                    const statusElement = step.querySelector('.phase-status');
                    statusElement.classList.remove('status-completed', 'status-active');
                    statusElement.classList.add('status-pending');
                    statusElement.textContent = 'Menunggu';
                });
                
                // Set phases based on current phase
                let currentPhaseIndex = 0;
                
                switch(currentPhase) {
                    case 'pendaftaran':
                        currentPhaseIndex = 0;
                        break;
                    case 'penerjunan':
                        currentPhaseIndex = 1;
                        break;
                    case 'pelaksanaan':
                        currentPhaseIndex = 2;
                        break;
                    case 'pelaporan':
                        currentPhaseIndex = 3;
                        break;
                    default:
                        currentPhaseIndex = 1;
                }
                
                // Mark previous phases as completed
                for (let i = 0; i < currentPhaseIndex; i++) {
                    phaseSteps[i].classList.add('completed');
                    const statusElement = phaseSteps[i].querySelector('.phase-status');
                    statusElement.classList.remove('status-pending');
                    statusElement.classList.add('status-completed');
                    statusElement.textContent = 'Selesai';
                }
                
                // Mark current phase as active
                phaseSteps[currentPhaseIndex].classList.add('active');
                const currentStatusElement = phaseSteps[currentPhaseIndex].querySelector('.phase-status');
                currentStatusElement.classList.remove('status-pending');
                currentStatusElement.classList.add('status-active');
                currentStatusElement.textContent = 'Berjalan';
            }
            
            // Initialize phase indicator with current phase
            // In a real application, this would come from your backend/database
            updatePhaseIndicator('penerjunan');

            // Example function to update phase from controller
            window.updateKKNPhase = function(phase) {
                updatePhaseIndicator(phase);
            };

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