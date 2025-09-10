<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akademik - Sistem Informasi KKN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Academic Container */
        .academic-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .academic-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .academic-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .academic-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        /* Academic Card */
        .academic-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .student-info {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--light-color);
        }

        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--light-color);
            margin-right: 20px;
        }

        .student-details h3 {
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .student-details p {
            color: #6c757d;
            margin-bottom: 0;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: var(--light-color);
            border-radius: 10px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .info-value {
            color: #495057;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Chart Container */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            height: 400px;
        }

        .chart-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .chart-title i {
            margin-right: 10px;
        }

        /* Transcript Table */
        .transcript-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .transcript-table th,
        .transcript-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        .transcript-table th {
            background-color: var(--light-color);
            color: var(--dark-color);
            font-weight: 600;
        }

        .transcript-table tr:hover {
            background-color: #f8f9fa;
        }

        .grade-a {
            color: #28a745;
            font-weight: 600;
        }

        .grade-b {
            color: #17a2b8;
            font-weight: 600;
        }

        .grade-c {
            color: #ffc107;
            font-weight: 600;
        }

        .grade-d {
            color: #fd7e14;
            font-weight: 600;
        }

        .grade-e {
            color: #dc3545;
            font-weight: 600;
        }

        /* Action Buttons */
        .academic-actions {
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

            .info-grid {
                grid-template-columns: 1fr;
            }

            .student-info {
                flex-direction: column;
                text-align: center;
            }

            .student-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .academic-actions {
                flex-direction: column;
            }

            .academic-actions .btn {
                width: 100%;
            }

            .transcript-table {
                display: block;
                overflow-x: auto;
            }

            .chart-container {
                height: 300px;
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
                    <a href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
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
                <li class="active">
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Data Akademik">
                        <i class="fas fa-graduation-cap"></i> <span>Data Akademik</span>
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
            <div class="academic-container">
                <!-- Header -->
                <div class="academic-header">
                    <h1><i class="fas fa-graduation-cap me-2"></i> Data Akademik Mahasiswa</h1>
                    <p>Informasi lengkap mengenai prestasi dan perkembangan akademik Anda</p>
                </div>

                <!-- Academic Card -->
                <div class="academic-card">
                    <div class="student-info">
                        <img src="https://via.placeholder.com/80" alt="Profile" class="student-avatar">
                        <div class="student-details">
                            <h3>Ahmad Rizky</h3>
                            <p>NIM: 1234567890 | Teknik Informatika</p>
                        </div>
                    </div>

                    <!-- Informasi Akademik -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-info-circle"></i> Informasi Akademik</h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Fakultas</span>
                                <span class="info-value">Fakultas Ilmu Komputer</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Program Studi</span>
                                <span class="info-value">Teknik Informatika</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Jenjang</span>
                                <span class="info-value">Strata 1 (S1)</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Angkatan</span>
                                <span class="info-value">2019</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Semester</span>
                                <span class="info-value">8 (Delapan)</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="info-value">Aktif</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">IPK</span>
                                <span class="info-value">3.75</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Total SKS</span>
                                <span class="info-value">144</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">SKS Semester Ini</span>
                                <span class="info-value">18</span>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Perkembangan IPK -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-chart-line"></i> Perkembangan IPK</h3>

                        <div class="chart-container">
                            <h4 class="chart-title"><i class="fas fa-graduation-cap"></i> Perkembangan IPK per Semester</h4>
                            <canvas id="ipkChart"></canvas>
                        </div>
                    </div>

                    <!-- Distribusi Nilai -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-chart-pie"></i> Distribusi Nilai</h3>

                        <div class="chart-container">
                            <h4 class="chart-title"><i class="fas fa-chart-bar"></i> Persentase Grade Nilai</h4>
                            <canvas id="gradeChart"></canvas>
                        </div>
                    </div>

                    <!-- Transkrip Nilai -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-file-alt"></i> Transkrip Nilai</h3>

                        <div class="table-responsive">
                            <table class="transcript-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Nilai</th>
                                        <th>Grade</th>
                                        <th>Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>TIF101</td>
                                        <td>Pemrograman Dasar</td>
                                        <td>3</td>
                                        <td>85</td>
                                        <td class="grade-a">A</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>TIF102</td>
                                        <td>Algoritma dan Struktur Data</td>
                                        <td>4</td>
                                        <td>82</td>
                                        <td class="grade-a">A-</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>TIF201</td>
                                        <td>Basis Data</td>
                                        <td>3</td>
                                        <td>88</td>
                                        <td class="grade-a">A</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>TIF202</td>
                                        <td>Pemrograman Web</td>
                                        <td>3</td>
                                        <td>90</td>
                                        <td class="grade-a">A</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>TIF301</td>
                                        <td>Jaringan Komputer</td>
                                        <td>3</td>
                                        <td>84</td>
                                        <td class="grade-a">A-</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>TIF302</td>
                                        <td>Pemrograman Berorientasi Objek</td>
                                        <td>4</td>
                                        <td>87</td>
                                        <td class="grade-a">A</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>TIF401</td>
                                        <td>Sistem Operasi</td>
                                        <td>3</td>
                                        <td>86</td>
                                        <td class="grade-a">A</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>TIF402</td>
                                        <td>Kecerdasan Buatan</td>
                                        <td>3</td>
                                        <td>89</td>
                                        <td class="grade-a">A</td>
                                        <td>4</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Prestasi Akademik -->
                    <div class="info-section">
                        <h3 class="section-title"><i class="fas fa-trophy"></i> Prestasi Akademik</h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Peringkat</span>
                                <span class="info-value">5 dari 120 mahasiswa</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Beasiswa</span>
                                <span class="info-value">Beasiswa Prestasi 2022</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Mata Kuliah Favorit</span>
                                <span class="info-value">Pemrograman Web</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Rata-rata Nilai</span>
                                <span class="info-value">86.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="academic-actions">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-print me-2"></i> Cetak Transkrip
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i> Unduh KHS
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-file-pdf me-2"></i> Transkrip Lengkap
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

            // Initialize charts
            function initializeCharts() {
                // IPK Chart
                const ipkCtx = document.getElementById('ipkChart').getContext('2d');
                const ipkChart = new Chart(ipkCtx, {
                    type: 'line',
                    data: {
                        labels: ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8'],
                        datasets: [{
                            label: 'IPK',
                            data: [3.25, 3.45, 3.60, 3.65, 3.70, 3.72, 3.74, 3.75],
                            borderColor: '#1e4fbe',
                            backgroundColor: 'rgba(30, 79, 190, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#1e4fbe',
                            pointBorderColor: '#fff',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: 3.0,
                                max: 4.0,
                                ticks: {
                                    stepSize: 0.2
                                },
                                title: {
                                    display: true,
                                    text: 'IPK'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Semester'
                                }
                            }
                        }
                    }
                });

                // Grade Distribution Chart
                const gradeCtx = document.getElementById('gradeChart').getContext('2d');
                const gradeChart = new Chart(gradeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C'],
                        datasets: [{
                            data: [45, 25, 15, 8, 4, 2, 1],
                            backgroundColor: [
                                '#28a745',
                                '#17a2b8',
                                '#6f42c1',
                                '#ffc107',
                                '#fd7e14',
                                '#e83e8c',
                                '#dc3545'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }
            // Initialize charts when page is loaded
            initializeCharts();
        });
    </script>
</body>
</html>
