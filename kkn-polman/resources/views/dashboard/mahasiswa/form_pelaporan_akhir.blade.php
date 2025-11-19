<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Akhir KKN - Sistem Informasi KKN</title>
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

        /* Form Styles */
        .form-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 79, 190, 0.25);
        }

        .file-upload-area {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
        }

        .file-upload-area.dragover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
            transform: scale(1.02);
        }

        .file-upload-area i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-upload-area h5 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .file-upload-area p {
            margin-bottom: 0;
            color: #6c757d;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 3px solid var(--primary-color);
        }

        .file-item i {
            color: var(--primary-color);
            margin-right: 12px;
            font-size: 1.3rem;
        }

        .file-item .file-info {
            flex-grow: 1;
        }

        .file-item .file-name {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .file-item .file-size {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .file-item .file-remove {
            color: #dc3545;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .file-item .file-remove:hover {
            background-color: #f8d7da;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
            transform: translateY(-2px);
        }

        .upload-status {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            display: none;
        }

        .upload-status.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .upload-status.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .document-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .document-section h6 {
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
        }

        .action-buttons .left-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons .right-buttons {
            display: flex;
            gap: 10px;
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

            .form-container {
                padding: 0 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .action-buttons .left-buttons,
            .action-buttons .right-buttons {
                width: 100%;
                justify-content: center;
            }

            .action-buttons .left-buttons {
                order: 2;
            }

            .action-buttons .right-buttons {
                order: 1;
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
                    <a href="laporan-akhir.html" data-bs-toggle="tooltip" data-bs-placement="right" title="Pelaporan">
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
                                <h1 class="card-title"><i class="fas fa-file-contract me-2"></i> Form Laporan Akhir KKN</h1>
                                <p class="card-text mb-0">Upload dokumen lengkap laporan akhir KKN Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-header">
                                    <i class="fas fa-file-upload section-icon"></i>
                                    <h5 class="section-title">Upload Dokumen Laporan Akhir</h5>
                                </div>

                                <div class="form-container">
                                    <form id="laporanAkhirForm">
                                        <!-- Informasi Dasar -->
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3">
                                                <label for="periode" class="form-label">Periode KKN <span class="text-danger">*</span></label>
                                                <select class="form-select" id="periode" required>
                                                    <option value="" selected disabled>Pilih periode KKN</option>
                                                    <option value="2023-1">KKN Periode Januari - Juni 2023</option>
                                                    <option value="2023-2">KKN Periode Juli - Desember 2023</option>
                                                    <option value="2024-1">KKN Periode Januari - Juni 2024</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="kelompok" class="form-label">Kelompok KKN <span class="text-danger">*</span></label>
                                                <select class="form-select" id="kelompok" required>
                                                    <option value="" selected disabled>Pilih kelompok KKN</option>
                                                    <option value="kelompok-1">Kelompok 1 - Desa Sukamaju</option>
                                                    <option value="kelompok-2">Kelompok 2 - Desa Sukaasih</option>
                                                    <option value="kelompok-3">Kelompok 3 - Desa Mekarsari</option>
                                                    <option value="kelompok-4">Kelompok 4 - Desa Cipadung</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Dokumen Utama -->
                                        <div class="document-section">
                                            <h6><i class="fas fa-file-pdf me-2 text-danger"></i> Dokumen Utama Laporan Akhir</h6>
                                            <p class="text-muted mb-3">Upload laporan akhir dalam format PDF sesuai dengan template yang telah disediakan.</p>

                                            <div class="file-upload-area" id="laporanUtamaArea">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                                <h5>Laporan Akhir (PDF)</h5>
                                                <p>Seret file laporan akhir ke sini atau klik untuk mengunggah</p>
                                                <p class="small">Format: PDF | Maksimal: 20MB</p>
                                                <input type="file" id="laporanUtamaInput" style="display: none;" accept=".pdf">
                                            </div>
                                            <div class="file-list" id="laporanUtamaList"></div>
                                        </div>

                                        <!-- Lampiran -->
                                        <div class="document-section">
                                            <h6><i class="fas fa-paperclip me-2 text-primary"></i> Lampiran Pendukung</h6>
                                            <p class="text-muted mb-3">Upload lampiran pendukung seperti foto dokumentasi, data survey, dan dokumen tambahan lainnya.</p>

                                            <div class="file-upload-area" id="lampiranArea">
                                                <i class="fas fa-file-archive text-primary"></i>
                                                <h5>Lampiran Pendukung</h5>
                                                <p>Seret file lampiran ke sini atau klik untuk mengunggah</p>
                                                <p class="small">Format: PDF, DOC, DOCX, JPG, PNG, ZIP | Maksimal: 50MB total</p>
                                                <input type="file" id="lampiranInput" style="display: none;" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" multiple>
                                            </div>
                                            <div class="file-list" id="lampiranList"></div>
                                        </div>

                                        <!-- Presentasi -->
                                        <div class="document-section">
                                            <h6><i class="fas fa-presentation me-2 text-success"></i> File Presentasi</h6>
                                            <p class="text-muted mb-3">Upload file presentasi untuk sesi responsi akhir KKN.</p>

                                            <div class="file-upload-area" id="presentasiArea">
                                                <i class="fas fa-file-powerpoint text-success"></i>
                                                <h5>File Presentasi</h5>
                                                <p>Seret file presentasi ke sini atau klik untuk mengunggah</p>
                                                <p class="small">Format: PPT, PPTX, PDF | Maksimal: 30MB</p>
                                                <input type="file" id="presentasiInput" style="display: none;" accept=".ppt,.pptx,.pdf">
                                            </div>
                                            <div class="file-list" id="presentasiList"></div>
                                        </div>

                                        <!-- Informasi Tambahan -->
                                        <div class="mb-4">
                                            <label for="informasiTambahan" class="form-label">Informasi Tambahan</label>
                                            <textarea class="form-control" id="informasiTambahan" rows="4" placeholder="Tambahkan informasi tambahan yang perlu disampaikan kepada dosen pembimbing..."></textarea>
                                        </div>

                                        <!-- Persetujuan -->
                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="persetujuan" required>
                                                <label class="form-check-label" for="persetujuan">
                                                    Saya menyatakan bahwa semua dokumen yang diunggah adalah benar dan asli hasil kerja kelompok kami selama KKN
                                                </label>
                                            </div>
                                        </div>

                                        <div class="upload-status" id="uploadStatus"></div>

                                        <!-- Tombol Aksi -->
                                        <div class="action-buttons">
                                            <div class="left-buttons">
                                                <a href="dashboard.html" class="btn btn-outline-secondary">
                                                    <i class="fas fa-arrow-left me-2"></i> Kembali
                                                </a>
                                            </div>
                                            <div class="right-buttons">
                                                <button type="button" class="btn btn-outline-primary" id="resetBtn">
                                                    <i class="fas fa-redo me-2"></i> Reset
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-info-circle me-2"></i> Panduan Upload Laporan Akhir</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Struktur Laporan Akhir</h6>
                                        <ol>
                                            <li>Halaman Judul dan Pengesahan</li>
                                            <li>Abstrak</li>
                                            <li>BAB I Pendahuluan</li>
                                            <li>BAB II Gambaran Umum Lokasi</li>
                                            <li>BAB III Pelaksanaan Kegiatan</li>
                                            <li>BAB IV Hasil dan Pembahasan</li>
                                            <li>BAB V Penutup</li>
                                            <li>Daftar Pustaka</li>
                                            <li>Lampiran</li>
                                        </ol>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Ketentuan Teknis</h6>
                                        <ul>
                                            <li>Laporan utama harus dalam format PDF</li>
                                            <li>Minimal 30 halaman (tidak termasuk lampiran)</li>
                                            <li>Menggunakan template resmi universitas</li>
                                            <li>File presentasi dapat berupa PPT, PPTX, atau PDF</li>
                                            <li>Lampiran dikompres dalam format ZIP jika banyak file</li>
                                            <li>Batas akhir pengumpulan: 30 Juli 2023</li>
                                        </ul>
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

            // File upload functionality
            const uploadAreas = {
                laporanUtama: {
                    area: document.getElementById('laporanUtamaArea'),
                    input: document.getElementById('laporanUtamaInput'),
                    list: document.getElementById('laporanUtamaList'),
                    maxSize: 20 * 1024 * 1024, // 20MB
                    allowedTypes: ['application/pdf'],
                    file: null
                },
                lampiran: {
                    area: document.getElementById('lampiranArea'),
                    input: document.getElementById('lampiranInput'),
                    list: document.getElementById('lampiranList'),
                    maxSize: 50 * 1024 * 1024, // 50MB total
                    allowedTypes: ['application/pdf', 'application/msword',
                                  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                  'image/jpeg', 'image/png', 'application/zip'],
                    files: []
                },
                presentasi: {
                    area: document.getElementById('presentasiArea'),
                    input: document.getElementById('presentasiInput'),
                    list: document.getElementById('presentasiList'),
                    maxSize: 30 * 1024 * 1024, // 30MB
                    allowedTypes: ['application/vnd.ms-powerpoint',
                                  'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                  'application/pdf'],
                    file: null
                }
            };

            const uploadStatus = document.getElementById('uploadStatus');

            // Initialize file upload for each section
            Object.keys(uploadAreas).forEach(section => {
                const config = uploadAreas[section];

                config.area.addEventListener('click', function() {
                    config.input.click();
                });

                // Drag and drop functionality
                config.area.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    config.area.classList.add('dragover');
                });

                config.area.addEventListener('dragleave', function() {
                    config.area.classList.remove('dragover');
                });

                config.area.addEventListener('drop', function(e) {
                    e.preventDefault();
                    config.area.classList.remove('dragover');

                    if (e.dataTransfer.files.length > 0) {
                        if (section === 'lampiran') {
                            handleFiles(e.dataTransfer.files, config);
                        } else {
                            handleFile(e.dataTransfer.files[0], config);
                        }
                    }
                });

                config.input.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        if (section === 'lampiran') {
                            handleFiles(this.files, config);
                        } else {
                            handleFile(this.files[0], config);
                        }
                    }
                });
            });

            function handleFile(file, config) {
                // Clear previous file
                if (config.file) {
                    config.file = null;
                }
                config.list.innerHTML = '';
                hideUploadStatus();

                // Check file size
                if (file.size > config.maxSize) {
                    showUploadStatus(`File ${file.name} terlalu besar. Maksimal ukuran file adalah ${formatFileSize(config.maxSize)}.`, 'error');
                    return;
                }

                // Check file type
                if (!config.allowedTypes.includes(file.type)) {
                    showUploadStatus(`File ${file.name} tidak didukung.`, 'error');
                    return;
                }

                // Add to uploaded files
                config.file = file;

                // Add to file list
                addFileToList(file, config);

                // Show success message
                showUploadStatus(`File "${file.name}" berhasil dipilih.`, 'success');
            }

            function handleFiles(files, config) {
                hideUploadStatus();
                let totalSize = config.files.reduce((sum, file) => sum + file.size, 0);

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Check file size
                    if (file.size + totalSize > config.maxSize) {
                        showUploadStatus(`Total ukuran file lampiran melebihi batas ${formatFileSize(config.maxSize)}.`, 'error');
                        continue;
                    }

                    // Check file type
                    if (!config.allowedTypes.includes(file.type)) {
                        showUploadStatus(`File ${file.name} tidak didukung.`, 'error');
                        continue;
                    }

                    // Add to uploaded files
                    config.files.push(file);
                    totalSize += file.size;

                    // Add to file list
                    addFileToList(file, config);
                }

                // Show success message
                if (files.length > 0) {
                    showUploadStatus(`${files.length} file lampiran berhasil dipilih.`, 'success');
                }

                // Clear file input
                config.input.value = '';
            }

            function addFileToList(file, config) {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';

                // Determine icon based on file type
                let fileIcon = 'fa-file';
                if (file.type.startsWith('image/')) {
                    fileIcon = 'fa-file-image';
                } else if (file.type === 'application/pdf') {
                    fileIcon = 'fa-file-pdf';
                } else if (file.type.includes('word')) {
                    fileIcon = 'fa-file-word';
                } else if (file.type.includes('powerpoint') || file.type.includes('presentation')) {
                    fileIcon = 'fa-file-powerpoint';
                } else if (file.type === 'application/zip') {
                    fileIcon = 'fa-file-archive';
                }

                // Format file size
                const fileSize = formatFileSize(file.size);

                fileItem.innerHTML = `
                    <i class="fas ${fileIcon}"></i>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${fileSize}</div>
                    </div>
                    <div class="file-remove">
                        <i class="fas fa-times"></i>
                    </div>
                `;

                config.list.appendChild(fileItem);

                // Add event listener to remove button
                fileItem.querySelector('.file-remove').addEventListener('click', function() {
                    if (config.files) {
                        // For multiple files (lampiran)
                        const index = config.files.findIndex(f => f.name === file.name && f.size === file.size);
                        if (index > -1) {
                            config.files.splice(index, 1);
                        }
                    } else {
                        // For single file
                        config.file = null;
                    }
                    fileItem.remove();
                    hideUploadStatus();
                });
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function showUploadStatus(message, type) {
                uploadStatus.textContent = message;
                uploadStatus.className = `upload-status ${type}`;
                uploadStatus.style.display = 'block';
            }

            function hideUploadStatus() {
                uploadStatus.style.display = 'none';
            }

            // Reset button
            document.getElementById('resetBtn').addEventListener('click', function() {
                document.getElementById('laporanAkhirForm').reset();

                // Clear all file uploads
                Object.keys(uploadAreas).forEach(section => {
                    const config = uploadAreas[section];
                    if (config.files) {
                        config.files = [];
                    } else {
                        config.file = null;
                    }
                    config.list.innerHTML = '';
                });

                hideUploadStatus();
            });

            // Form submission
            document.getElementById('laporanAkhirForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                const periode = document.getElementById('periode').value;
                const kelompok = document.getElementById('kelompok').value;
                const persetujuan = document.getElementById('persetujuan').checked;

                if (!periode || !kelompok) {
                    showUploadStatus('Harap isi semua field yang wajib diisi!', 'error');
                    return;
                }

                if (!persetujuan) {
                    showUploadStatus('Harap centang persetujuan!', 'error');
                    return;
                }

                if (!uploadAreas.laporanUtama.file) {
                    showUploadStatus('Harap upload dokumen laporan utama!', 'error');
                    return;
                }

                // Create form data
                const formData = new FormData();
                formData.append('periode', periode);
                formData.append('kelompok', kelompok);
                formData.append('informasiTambahan', document.getElementById('informasiTambahan').value);
                formData.append('laporanUtama', uploadAreas.laporanUtama.file);

                if (uploadAreas.presentasi.file) {
                    formData.append('presentasi', uploadAreas.presentasi.file);
                }

                uploadAreas.lampiran.files.forEach((file, index) => {
                    formData.append(`lampiran_${index}`, file);
                });

                // Simulate form submission with loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengunggah...';
                submitBtn.disabled = true;

                // Simulate API call
                setTimeout(function() {
                    // Show success message
                    showUploadStatus('Laporan akhir berhasil diunggah! Tim akan meninjau laporan Anda dalam 3-5 hari kerja.', 'success');

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Redirect after 3 seconds
                    setTimeout(function() {
                        window.location.href = 'dashboard.html';
                    }, 3000);
                }, 3000);
            });
        });
    </script>
</body>
</html>
