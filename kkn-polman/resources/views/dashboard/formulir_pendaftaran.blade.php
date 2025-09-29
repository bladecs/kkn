<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran KKN</title>
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

        /* Registration Container */
        .registration-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .registration-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .registration-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .registration-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .registration-progress {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            background-color: var(--primary-color);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .progress-label span.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .registration-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
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
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.25);
        }

        .input-group-text {
            background: white;
            border-radius: 10px 0 0 10px;
            border: 2px solid #e2e8f0;
            border-right: none;
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

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .registration-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .file-upload {
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .uploaded-file {
            background: var(--light-color);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .uploaded-file i {
            color: var(--primary-color);
            cursor: pointer;
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

            .registration-actions {
                flex-direction: column;
                gap: 15px;
            }

            .registration-actions .btn {
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
            <div class="registration-container">
                <!-- Header -->
                <div class="registration-header">
                    <h1><i class="fas fa-file-alt me-2"></i> Formulir Pendaftaran KKN</h1>
                    <p>Isi formulir berikut dengan data yang benar dan lengkap</p>
                </div>

                <!-- Progress -->
                <div class="registration-progress">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress-label">
                        <span class="active">Data Pribadi</span>
                        <span>Berkas Persyaratan</span>
                        <span>Konfirmasi</span>
                    </div>
                </div>

                <!-- Form -->
                <form class="registration-form">
                    <!-- Data Pribadi -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-user"></i> Data Pribadi</h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label required-field">Nama Lengkap</label>
                                <input type="text" class="form-control" id="fullname" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label required-field">NIM</label>
                                <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required-field">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" placeholder="email@example.com" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label required-field">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control" id="phone" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="faculty" class="form-label required-field">Fakultas</label>
                                <select class="form-select" id="faculty" required>
                                    <option value="">Pilih Fakultas</option>
                                    <option value="teknik">Fakultas Teknik</option>
                                    <option value="ekonomi">Fakultas Ekonomi dan Bisnis</option>
                                    <option value="hukum">Fakultas Hukum</option>
                                    <option value="kedokteran">Fakultas Kedokteran</option>
                                    <option value="pertanian">Fakultas Pertanian</option>
                                    <option value="ilmu-komputer">Fakultas Ilmu Komputer</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="study-program" class="form-label required-field">Program Studi</label>
                                <input type="text" class="form-control" id="study-program" placeholder="Masukkan program studi" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth-place" class="form-label required-field">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth-place" placeholder="Masukkan tempat lahir" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth-date" class="form-label required-field">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth-date" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label required-field">Alamat Lengkap</label>
                                <textarea class="form-control" id="address" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Data Akademik -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Data Akademik</h3>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ipk" class="form-label required-field">IPK Terakhir</label>
                                <input type="number" class="form-control" id="ipk" step="0.01" min="0" max="4" placeholder="Contoh: 3.75" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sks" class="form-label required-field">Jumlah SKS</label>
                                <input type="number" class="form-control" id="sks" min="0" placeholder="Masukkan jumlah SKS" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="semester" class="form-label required-field">Semester</label>
                                <input type="number" class="form-control" id="semester" min="1" max="14" placeholder="Masukkan semester" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label required-field">Status Mahasiswa</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-regular" value="regular" checked>
                                        <label class="form-check-label" for="status-regular">
                                            Reguler
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-transfer" value="transfer">
                                        <label class="form-check-label" for="status-transfer">
                                            Transfer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-other" value="other">
                                        <label class="form-check-label" for="status-other">
                                            Lainnya
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferensi Lokasi KKN -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Preferensi Lokasi KKN</h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label required-field">Provinsi</label>
                                <select class="form-select" id="province" required>
                                    <option value="">Pilih Provinsi</option>
                                    <option value="jawa-barat">Jawa Barat</option>
                                    <option value="jawa-tengah">Jawa Tengah</option>
                                    <option value="jawa-timur">Jawa Timur</option>
                                    <option value="banten">Banten</option>
                                    <option value="yogyakarta">DI Yogyakarta</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="regency" class="form-label required-field">Kabupaten/Kota</label>
                                <select class="form-select" id="regency" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    <option value="bandung">Bandung</option>
                                    <option value="garut">Garut</option>
                                    <option value="tasikmalaya">Tasikmalaya</option>
                                    <option value="ciamis">Ciamis</option>
                                    <option value="sumedang">Sumedang</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="location-preference" class="form-label">Preferensi Khusus Lokasi (opsional)</label>
                                <textarea class="form-control" id="location-preference" rows="2" placeholder="Misal: dekat dengan tempat tinggal, daerah pertanian, etc."></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label required-field">Apakah Anda memiliki pengalaman sebelumnya dalam kegiatan serupa?</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="experience" id="experience-yes" value="yes">
                                        <label class="form-check-label" for="experience-yes">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="experience" id="experience-no" value="no" checked>
                                        <label class="form-check-label" for="experience-no">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Berkas -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-file-upload"></i> Upload Berkas</h3>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Foto Formal</label>
                                <div class="file-upload" id="photo-upload">
                                    <i class="fas fa-camera"></i>
                                    <p>Klik untuk upload foto formal<br><small>Maks. 2MB (JPG/PNG)</small></p>
                                    <input type="file" accept="image/*" hidden>
                                </div>
                                <div class="uploaded-file" style="display: none;">
                                    <span>foto_formal.jpg</span>
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">KTM (Kartu Tanda Mahasiswa)</label>
                                <div class="file-upload" id="ktm-upload">
                                    <i class="fas fa-id-card"></i>
                                    <p>Klik untuk upload scan KTM<br><small>Maks. 2MB (JPG/PNG/PDF)</small></p>
                                    <input type="file" accept="image/*,.pdf" hidden>
                                </div>
                                <div class="uploaded-file" style="display: none;">
                                    <span>ktm_scan.pdf</span>
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Transkrip Nilai</label>
                                <div class="file-upload" id="transcript-upload">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Klik untuk upload transkrip nilai<br><small>Maks. 5MB (PDF)</small></p>
                                    <input type="file" accept=".pdf" hidden>
                                </div>
                                <div class="uploaded-file" style="display: none;">
                                    <span>transkrip.pdf</span>
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sertifikat Pendukung (opsional)</label>
                                <div class="file-upload" id="certificate-upload">
                                    <i class="fas fa-award"></i>
                                    <p>Klik untuk upload sertifikat<br><small>Maks. 5MB (PDF)</small></p>
                                    <input type="file" accept=".pdf" hidden>
                                </div>
                                <div class="uploaded-file" style="display: none;">
                                    <span>sertifikat.pdf</span>
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pernyataan -->
                    <div class="form-section">
                        <h3 class="section-title"><i class="fas fa-check-circle"></i> Pernyataan</h3>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="statement" required>
                            <label class="form-check-label" for="statement">
                                Saya menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan. Saya bersedia mengikuti seluruh kegiatan KKN sesuai dengan ketentuan yang berlaku.
                            </label>
                            <div class="invalid-feedback">
                                Anda harus menyetujui pernyataan sebelum melanjutkan.
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Actions -->
                <div class="registration-actions">
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </button>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-save me-2"></i> Simpan Draft
                        </button>
                        <button type="submit" class="btn btn-primary" id="submit-form">
                            <i class="fas fa-paper-plane me-2"></i> Submit Pendaftaran
                        </button>
                    </div>
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

            // File upload functionality
            $('.file-upload').click(function() {
                $(this).find('input[type="file"]').click();
            });

            $('.file-upload input[type="file"]').change(function() {
                const fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $(this).closest('.file-upload').next('.uploaded-file').find('span').text(fileName);
                    $(this).closest('.file-upload').next('.uploaded-file').show();
                }
            });

            $('.uploaded-file i').click(function(e) {
                e.stopPropagation();
                $(this).closest('.uploaded-file').hide();
                $(this).closest('.uploaded-file').prev('.file-upload').find('input[type="file"]').val('');
            });

            // Form submission
            $('#submit-form').click(function() {
                let isValid = true;

                // Validate required fields
                $('input[required], select[required], textarea[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Validate statement
                if (!$('#statement').is(':checked')) {
                    isValid = false;
                    $('#statement').addClass('is-invalid');
                } else {
                    $('#statement').removeClass('is-invalid');
                }

                if (!isValid) {
                    alert('Harap lengkapi semua field yang wajib diisi!');
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                    return;
                }

                // Simulate form submission
                alert('Formulir pendaftaran berhasil dikirim! Data Anda sedang diproses.');
                // In real implementation, you would submit the form to a server here
            });

            // Remove validation styles on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
</body>
</html>
