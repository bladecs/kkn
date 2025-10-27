<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Harian KKN - Sistem Informasi KKN</title>
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
            max-width: 800px;
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
            padding: 40px 20px;
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
            font-size: 3rem;
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
            padding: 10px 25px;
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
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
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
                    <a href="laporan-harian.html" data-bs-toggle="tooltip" data-bs-placement="right" title="Pelaporan">
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
                                <h1 class="card-title"><i class="fas fa-file-upload me-2"></i> Form Laporan Harian KKN</h1>
                                <p class="card-text mb-0">Unggah dokumen laporan harian KKN Anda di sini</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-header">
                                    <i class="fas fa-upload section-icon"></i>
                                    <h5 class="section-title">Upload Laporan Harian</h5>
                                </div>

                                <div class="form-container">
                                    <form id="laporanForm">
                                        <!-- Informasi Dasar -->
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal" class="form-label">Tanggal Laporan <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="tanggal" required>
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

                                        <!-- Upload Dokumen -->
                                        <div class="mb-4">
                                            <label class="form-label">Upload Dokumen Laporan <span class="text-danger">*</span></label>
                                            <div class="file-upload-area" id="fileUploadArea">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <h5>Seret file laporan ke sini atau klik untuk mengunggah</h5>
                                                <p>Format yang didukung: PDF, DOC, DOCX (Maks. 10MB per file)</p>
                                                <input type="file" id="fileInput" style="display: none;" accept=".pdf,.doc,.docx">
                                            </div>
                                            <div class="file-list" id="fileList">
                                                <!-- File list akan ditampilkan di sini -->
                                            </div>
                                            <div class="upload-status" id="uploadStatus"></div>
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="mb-4">
                                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                            <textarea class="form-control" id="keterangan" rows="3" placeholder="Tambahkan keterangan tambahan jika diperlukan"></textarea>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="d-flex justify-content-between mt-5">
                                            <a href="dashboard.html" class="btn btn-outline-primary">
                                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                                            </a>
                                            <div>
                                                <button type="button" class="btn btn-outline-primary me-2" id="resetBtn">
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
                                <h5 class="card-title"><i class="fas fa-info-circle me-2"></i> Panduan Upload Laporan</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Ketentuan Laporan Harian</h6>
                                        <ul>
                                            <li>Laporan harus diunggah setiap hari selama periode KKN</li>
                                            <li>Format laporan harus sesuai dengan template yang telah disediakan</li>
                                            <li>Pastikan laporan sudah mencakup kegiatan, hasil, kendala, dan rencana</li>
                                            <li>Laporan harus dikirim sebelum pukul 23:59 WIB</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Format Dokumen</h6>
                                        <ul>
                                            <li>Dokumen: PDF, DOC, DOCX</li>
                                            <li>Maksimal ukuran file: 10MB</li>
                                            <li>Nama file: Laporan_[Tanggal]_[NamaKelompok]</li>
                                            <li>Contoh: Laporan_2023-06-15_Kelompok1.pdf</li>
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
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('fileList');
            const uploadStatus = document.getElementById('uploadStatus');
            let uploadedFile = null;

            fileUploadArea.addEventListener('click', function() {
                fileInput.click();
            });

            // Drag and drop functionality
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadArea.classList.add('dragover');
            });

            fileUploadArea.addEventListener('dragleave', function() {
                fileUploadArea.classList.remove('dragover');
            });

            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');

                if (e.dataTransfer.files.length > 0) {
                    handleFile(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    handleFile(this.files[0]);
                }
            });

            function handleFile(file) {
                // Clear previous file
                uploadedFile = null;
                fileList.innerHTML = '';
                hideUploadStatus();

                // Check file size (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showUploadStatus(`File ${file.name} terlalu besar. Maksimal ukuran file adalah 10MB.`, 'error');
                    return;
                }

                // Check file type
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                if (!allowedTypes.includes(file.type)) {
                    showUploadStatus(`File ${file.name} tidak didukung. Hanya file PDF, DOC, dan DOCX yang diperbolehkan.`, 'error');
                    return;
                }

                // Add to uploaded files
                uploadedFile = file;

                // Add to file list
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';

                // Determine icon based on file type
                let fileIcon = 'fa-file';
                if (file.type === 'application/pdf') {
                    fileIcon = 'fa-file-pdf';
                } else if (file.type.includes('word')) {
                    fileIcon = 'fa-file-word';
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

                fileList.appendChild(fileItem);

                // Add event listener to remove button
                fileItem.querySelector('.file-remove').addEventListener('click', function() {
                    uploadedFile = null;
                    fileList.innerHTML = '';
                    hideUploadStatus();
                });

                // Show success message
                showUploadStatus(`File "${file.name}" berhasil dipilih. Silakan klik "Kirim Laporan" untuk mengunggah.`, 'success');
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
                document.getElementById('laporanForm').reset();
                uploadedFile = null;
                fileList.innerHTML = '';
                hideUploadStatus();
            });

            // Form submission
            document.getElementById('laporanForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                const tanggal = document.getElementById('tanggal').value;
                const kelompok = document.getElementById('kelompok').value;

                if (!tanggal || !kelompok) {
                    showUploadStatus('Harap isi semua field yang wajib diisi!', 'error');
                    return;
                }

                if (!uploadedFile) {
                    showUploadStatus('Harap pilih file laporan untuk diunggah!', 'error');
                    return;
                }

                // Create form data
                const formData = new FormData();
                formData.append('tanggal', tanggal);
                formData.append('kelompok', kelompok);
                formData.append('keterangan', document.getElementById('keterangan').value);
                formData.append('laporan', uploadedFile);

                // Simulate form submission with loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengunggah...';
                submitBtn.disabled = true;

                // Simulate API call
                setTimeout(function() {
                    // Show success message
                    showUploadStatus('Laporan harian berhasil diunggah!', 'success');

                    // Reset form
                    document.getElementById('laporanForm').reset();
                    uploadedFile = null;
                    fileList.innerHTML = '';

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = 'dashboard.html';
                    }, 2000);
                }, 2000);
            });

            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = today;
        });
    </script>
</body>
</html>
