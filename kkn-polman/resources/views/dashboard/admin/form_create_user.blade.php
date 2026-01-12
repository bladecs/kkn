@extends('dashboard.admin.layouts.app')

@section('title', 'Dashboard Form Create User')

@section('style')
    <style>
        :root {
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 25px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px 30px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .form-section {
            margin-bottom: 30px;
            padding: 25px;
            border-radius: 10px;
            background-color: white;
            border: 1px solid #eaeaea;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        }

        .form-section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eaeaea;
        }

        .role-selector {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .role-option {
            width: 220px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #eaeaea;
            border-radius: 12px;
            transition: all 0.3s ease;
            background-color: white;
        }

        .role-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .role-option.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, #e8f0fe 0%, #f0f7ff 100%);
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(30, 79, 190, 0.15);
        }

        .role-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            height: 80px;
            width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            color: white;
        }

        .role-mahasiswa {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .role-dosen {
            background: linear-gradient(135deg, var(--success-color) 0%, #34ce57 100%);
        }

        .role-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .role-desc {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.4;
        }

        .tab-content {
            transition: all 0.3s ease;
        }

        .form-tab {
            display: none;
        }

        .form-tab.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .required:after {
            content: " *";
            color: var(--danger-color);
            font-weight: bold;
        }

        .submit-btn {
            padding: 15px 40px;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: all 0.3s;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 79, 190, 0.3);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.15);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
        }

        .container-fluid {
            max-width: 1400px;
            padding: 0 40px;
        }

        @media (max-width: 1200px) {
            .container-fluid {
                padding: 0 30px;
            }
        }

        @media (max-width: 992px) {
            .container-fluid {
                padding: 0 20px;
            }

            .role-selector {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .role-option {
                width: 100%;
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 15px;
            }

            .form-section {
                padding: 20px;
            }

            .card-header {
                padding: 15px 20px;
                font-size: 1.1rem;
            }

            .submit-btn {
                width: 100%;
                padding: 15px;
            }
        }

        .info-badge {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #e8f4ff;
            border-radius: 10px;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .info-badge i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .password-strength {
            height: 5px;
            background-color: #e0e0e0;
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: all 0.3s;
        }

        .strength-weak {
            background-color: #dc3545;
            width: 33%;
        }

        .strength-medium {
            background-color: #ffc107;
            width: 66%;
        }

        .strength-strong {
            background-color: #28a745;
            width: 100%;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-grid-item {
            display: flex;
            flex-direction: column;
        }

        .form-grid-full {
            grid-column: 1 / -1;
        }

        /* Dosen Role Selector */
        .dosen-role-selector {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .dosen-role-btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: white;
        }

        .dosen-role-btn:hover {
            border-color: var(--warning-color);
            transform: translateY(-3px);
        }

        .dosen-role-btn.active {
            border-color: var(--warning-color);
            background-color: rgba(255, 193, 7, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.1);
        }

        .dosen-role-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--warning-color);
        }

        .dosen-role-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .dosen-role-desc {
            font-size: 0.8rem;
            color: #666;
        }

        /* Badge styling */
        .role-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .badge-koordinator {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 193, 7, 0.1) 100%);
            color: #b8860b;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .badge-dosen-biasa {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.2) 0%, rgba(23, 162, 184, 0.1) 100%);
            color: #138496;
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        .hidden {
            display: none !important;
        }

        /* Back button styling */
        .back-btn {
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background-color: #f0f7ff;
            transform: translateY(-2px);
        }

        /* Koordinator specific styles */
        .koordinator-info {
            background-color: #fff8e1;
            border-left: 4px solid var(--warning-color);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .koordinator-info h6 {
            color: #b8860b;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .koordinator-info ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .koordinator-info li {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 fw-bold text-primary mb-2">
                        <i class="fas fa-user-plus me-3"></i>Buat Akun Baru
                    </h1>
                    <p class="lead text-muted mb-0">Tambahkan pengguna baru ke dalam sistem KKN</p>
                </div>
                <a href="dashboard.html" class="btn btn-outline-primary back-btn">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
            <div class="info-badge mt-4">
                <i class="fas fa-info-circle"></i>
                <span>Form ini akan menyesuaikan dengan lebar layar Anda. Semakin lebar layar, semakin banyak kolom yang
                    ditampilkan.</span>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-3"></i>Form Registrasi Pengguna</h5>
                </div>
                <div class="card-body p-5">
                    <!-- Role Selection -->
                    <div class="role-selector">
                        <div class="role-option" data-role="mahasiswa" id="roleMahasiswa">
                            <div class="role-icon role-mahasiswa">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="role-title">Mahasiswa</div>
                            <div class="role-desc">Peserta KKN dengan NIM sebagai ID</div>
                        </div>

                        <div class="role-option" data-role="dosen" id="roleDosen">
                            <div class="role-icon role-dosen">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="role-title">Dosen</div>
                            <div class="role-desc">Pembimbing KKN dengan NIP sebagai ID</div>
                        </div>
                    </div>

                    <!-- Hidden inputs -->
                    <input type="hidden" id="userRole" name="role" value="mahasiswa">
                    <input type="hidden" id="dosenRoleType" name="dosen_role_type" value="dosen_biasa">

                    <!-- Form Content -->
                    <form id="createUserForm" action="#" method="POST">
                        @csrf

                        <!-- Tab for Mahasiswa -->
                        <div class="form-tab active" id="mahasiswaTab">
                            <!-- Data Akun Umum -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-user me-2"></i>Data Akun Mahasiswa
                                </h6>
                                <div class="form-grid">
                                    <div class="form-grid-item">
                                        <label for="m_nim" class="form-label required">NIM</label>
                                        <input type="text" class="form-control" id="m_nim" name="nim" required
                                            placeholder="Masukkan NIM (contoh: 20210120001)">
                                        <div class="form-text">NIM akan digunakan sebagai ID login</div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_email" class="form-label required">Email</label>
                                        <input type="email" class="form-control" id="m_email" name="email" required
                                            placeholder="email@mhs.polman-bandung.ac.id">
                                        <div class="form-text">Email akan digunakan untuk verifikasi</div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_password" class="form-label required">Password</label>
                                        <input type="password" class="form-control" id="m_password" name="password" required
                                            placeholder="Minimal 8 karakter">
                                        <div class="password-strength">
                                            <div class="password-strength-bar" id="m_password_strength"></div>
                                        </div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_password_confirmation" class="form-label required">Konfirmasi
                                            Password</label>
                                        <input type="password" class="form-control" id="m_password_confirmation"
                                            name="password_confirmation" required placeholder="Ulangi password">
                                    </div>
                                </div>
                            </div>

                            <!-- Data Mahasiswa -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-graduation-cap me-2"></i>Data Pribadi Mahasiswa
                                </h6>
                                <div class="form-grid">
                                    <div class="form-grid-item form-grid-full">
                                        <label for="m_name" class="form-label required">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="m_name" name="name" required
                                            placeholder="Masukkan nama lengkap sesuai ijazah">
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_semester" class="form-label required">Semester</label>
                                        <select class="form-select" id="m_semester" name="semester" required>
                                            <option value="" selected disabled>Pilih Semester</option>
                                            <option value="1">Semester 1</option>
                                            <option value="2">Semester 2</option>
                                            <option value="3">Semester 3</option>
                                            <option value="4">Semester 4</option>
                                            <option value="5">Semester 5</option>
                                            <option value="6">Semester 6</option>
                                            <option value="7">Semester 7</option>
                                            <option value="8">Semester 8</option>
                                        </select>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_prodi_id" class="form-label required">Program Studi</label>
                                        <select class="form-select" id="m_prodi_id" name="prodi_id" required>
                                            <option value="" selected disabled>Pilih Program Studi</option>
                                            @foreach ($jurusan as $j)
                                                @foreach ($j->prodi as $p)
                                                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="m_jurusan_id" class="form-label required">Jurusan</label>
                                        <select class="form-select" id="m_jurusan_id" name="jurusan_id" required>
                                            <option value="" selected disabled>Pilih Jurusan</option>
                                            @foreach ($jurusan as $j)
                                                <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab for Dosen -->
                        <div class="form-tab" id="dosenTab">
                            <!-- Dosen Role Type Selection -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-user-tag me-2"></i>Tipe Dosen
                                </h6>
                                <div class="dosen-role-selector">
                                    <div class="dosen-role-btn active" data-dosen-role="dosen_biasa" id="dosenBiasaBtn">
                                        <div class="dosen-role-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div class="dosen-role-label">Dosen Biasa</div>
                                        <div class="dosen-role-desc">Pembimbing biasa tanpa wewenang khusus</div>
                                    </div>

                                    <div class="dosen-role-btn" data-dosen-role="koordinator" id="koordinatorBtn">
                                        <div class="dosen-role-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div class="dosen-role-label">Koordinator</div>
                                        <div class="dosen-role-desc">Memiliki wewenang khusus dan akses admin</div>
                                    </div>
                                </div>

                                <!-- Koordinator Information -->
                                <div class="koordinator-info hidden" id="koordinatorInfo">
                                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Koordinator</h6>
                                    <ul>
                                        <li>Koordinator memiliki akses ke semua data KKN</li>
                                        <li>Dapat mengelola kelompok, jadwal, dan lokasi KKN</li>
                                        <li>Memiliki wewenang untuk pendaftaran mahasiswa</li>
                                        <li>Memiliki wewenang untuk pendaftran project</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Data Akun Dosen -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-user me-2"></i>Data Akun Dosen
                                </h6>
                                <div class="form-grid">
                                    <div class="form-grid-item">
                                        <label for="d_nip" class="form-label required">NIP</label>
                                        <input type="text" class="form-control" id="d_nip" name="nip"
                                            required placeholder="Masukkan NIP (contoh: 198003122005011001)">
                                        <div class="form-text">NIP akan digunakan sebagai ID login</div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="d_email" class="form-label required">Email</label>
                                        <input type="email" class="form-control" id="d_email" name="email"
                                            required placeholder="email@dosen.polman-bandung.ac.id">
                                        <div class="form-text">Email akan digunakan untuk verifikasi</div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="d_password" class="form-label required">Password</label>
                                        <input type="password" class="form-control" id="d_password" name="password"
                                            required placeholder="Minimal 8 karakter">
                                        <div class="password-strength">
                                            <div class="password-strength-bar" id="d_password_strength"></div>
                                        </div>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="d_password_confirmation" class="form-label required">Konfirmasi
                                            Password</label>
                                        <input type="password" class="form-control" id="d_password_confirmation"
                                            name="password_confirmation" required placeholder="Ulangi password">
                                    </div>
                                </div>
                            </div>

                            <!-- Data Dosen -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Data Pribadi Dosen
                                </h6>
                                <div class="form-grid">
                                    <div class="form-grid-item form-grid-full">
                                        <label for="d_name" class="form-label required">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="d_name" name="name"
                                            required placeholder="Masukkan nama lengkap dengan gelar">
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="d_prodi_id" class="form-label required">Program Studi</label>
                                        <select class="form-select" id="d_prodi_id" name="prodi_id" required>
                                            <option value="" selected disabled>Pilih Program Studi</option>
                                            @foreach ($jurusan as $j)
                                                @foreach ($j->prodi as $index)
                                                    <option value="{{ $index->id_prodi }}">{{ $index->nama_prodi }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-grid-item">
                                        <label for="d_jurusan_id" class="form-label required">Jurusan</label>
                                        <select class="form-select" id="d_jurusan_id" name="jurusan_id" required>
                                            <option value="" selected disabled>Pilih Jurusan</option>
                                            @foreach ($jurusan as $j)
                                                <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary submit-btn px-5">
                                <i class="fas fa-save me-2"></i>Simpan Akun Baru
                                <span id="roleBadge" class="role-badge badge-dosen-biasa hidden">Dosen Biasa</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary px-5 ms-3" id="resetForm">
                                <i class="fas fa-redo me-2"></i>Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Card -->
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3"><i class="fas fa-info-circle text-primary me-2"></i>Informasi
                                Penting</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li>Akun yang dibuat akan langsung aktif dalam sistem</li>
                                        <li>Password akan dienkripsi dan tidak dapat dilihat oleh admin</li>
                                        <li>Email akan digunakan untuk verifikasi dan reset password</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li><strong>Koordinator</strong> memiliki akses admin penuh</li>
                                        <li><strong>Dosen Biasa</strong> hanya dapat mengelola kelompok bimbingannya</li>
                                        <li>Semua field bertanda * wajib diisi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3"><i class="fas fa-users text-primary me-2"></i>Statistik Dosen</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Dosen:</span>
                                <span class="fw-bold text-success">78</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Koordinator:</span>
                                <span class="fw-bold text-warning">12</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Dosen Biasa:</span>
                                <span class="fw-bold text-info">66</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const roleMahasiswa = document.getElementById('roleMahasiswa');
            const roleDosen = document.getElementById('roleDosen');
            const mahasiswaTab = document.getElementById('mahasiswaTab');
            const dosenTab = document.getElementById('dosenTab');
            const userRoleInput = document.getElementById('userRole');
            const dosenRoleTypeInput = document.getElementById('dosenRoleType');
            const createUserForm = document.getElementById('createUserForm');
            const resetFormBtn = document.getElementById('resetForm');

            // Dosen role elements
            const dosenBiasaBtn = document.getElementById('dosenBiasaBtn');
            const koordinatorBtn = document.getElementById('koordinatorBtn');
            const koordinatorInfo = document.getElementById('koordinatorInfo');
            const koordinatorFields = document.getElementById('koordinatorFields');
            const roleBadge = document.getElementById('roleBadge');

            // Set default role
            let selectedRole = 'mahasiswa';
            let dosenRoleType = 'dosen_biasa';

            // Role selection handler
            function selectRole(role) {
                selectedRole = role;
                userRoleInput.value = role;

                if (role === 'mahasiswa') {
                    roleMahasiswa.classList.add('active');
                    roleDosen.classList.remove('active');

                    mahasiswaTab.classList.add('active');
                    dosenTab.classList.remove('active');

                    toggleFormState('mahasiswaTab', true);
                    toggleFormState('dosenTab', false);

                    roleBadge.classList.add('hidden');
                } else {
                    roleDosen.classList.add('active');
                    roleMahasiswa.classList.remove('active');

                    dosenTab.classList.add('active');
                    mahasiswaTab.classList.remove('active');

                    toggleFormState('dosenTab', true);
                    toggleFormState('mahasiswaTab', false);

                    roleBadge.classList.remove('hidden');
                    updateRoleBadge();
                }

                resetFormForRole(role);
            }


            function toggleFormState(tabId, isActive) {
                const inputs = document.querySelectorAll(`#${tabId} input, #${tabId} select`);

                inputs.forEach(input => {
                    if (isActive) {
                        input.disabled = false;
                        input.setAttribute('required', 'required');
                    } else {
                        input.disabled = true;
                        input.removeAttribute('required');
                    }
                });
            }


            // Dosen role type selection handler
            function selectDosenRoleType(roleType) {
                dosenRoleType = roleType;
                dosenRoleTypeInput.value = roleType;

                // Update button styling
                if (roleType === 'dosen_biasa') {
                    dosenBiasaBtn.classList.add('active');
                    koordinatorBtn.classList.remove('active');
                    koordinatorInfo.classList.add('hidden');
                } else {
                    koordinatorBtn.classList.add('active');
                    dosenBiasaBtn.classList.remove('active');
                    koordinatorInfo.classList.remove('hidden');
                }

                updateRoleBadge();
            }

            // Update role badge text and style
            function updateRoleBadge() {
                if (selectedRole === 'dosen') {
                    if (dosenRoleType === 'dosen_biasa') {
                        roleBadge.textContent = 'Dosen Biasa';
                        roleBadge.className = 'role-badge badge-dosen-biasa';
                    } else {
                        roleBadge.textContent = 'Koordinator';
                        roleBadge.className = 'role-badge badge-koordinator';
                    }
                }
            }

            // Reset form when switching roles
            function resetFormForRole(role) {
                if (role === 'mahasiswa') {
                    // Clear dosen form fields
                    document.getElementById('d_nip').value = '';
                    document.getElementById('d_email').value = '';
                    document.getElementById('d_name').value = '';
                    document.getElementById('d_prodi_id').selectedIndex = 0;
                    document.getElementById('d_jurusan_id').selectedIndex = 0;
                    document.getElementById('d_password').value = '';
                    document.getElementById('d_password_confirmation').value = '';
                    document.getElementById('d_password_strength').className = 'password-strength-bar';

                    // Reset dosen role to default
                    selectDosenRoleType('dosen_biasa');
                } else {
                    // Clear mahasiswa form fields
                    document.getElementById('m_nim').value = '';
                    document.getElementById('m_email').value = '';
                    document.getElementById('m_name').value = '';
                    document.getElementById('m_semester').selectedIndex = 0;
                    document.getElementById('m_prodi_id').selectedIndex = 0;
                    document.getElementById('m_jurusan_id').selectedIndex = 0;
                    document.getElementById('m_password').value = '';
                    document.getElementById('m_password_confirmation').value = '';
                    document.getElementById('m_password_strength').className = 'password-strength-bar';
                }
            }

            // Event listeners for role selection
            roleMahasiswa.addEventListener('click', () => selectRole('mahasiswa'));
            roleDosen.addEventListener('click', () => selectRole('dosen'));

            // Event listeners for dosen role selection
            dosenBiasaBtn.addEventListener('click', () => selectDosenRoleType('dosen_biasa'));
            koordinatorBtn.addEventListener('click', () => selectDosenRoleType('koordinator'));

            // Password strength checker
            function checkPasswordStrength(password, strengthBarId) {
                const strengthBar = document.getElementById(strengthBarId);
                let strength = 0;

                // Reset
                strengthBar.className = 'password-strength-bar';

                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                // Update strength bar
                if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                } else if (strength <= 4) {
                    strengthBar.classList.add('strength-medium');
                } else {
                    strengthBar.classList.add('strength-strong');
                }
            }

            // Setup password strength checking
            function setupPasswordStrength() {
                const mPassword = document.getElementById('m_password');
                const dPassword = document.getElementById('d_password');

                mPassword.addEventListener('input', function() {
                    checkPasswordStrength(this.value, 'm_password_strength');
                });

                dPassword.addEventListener('input', function() {
                    checkPasswordStrength(this.value, 'd_password_strength');
                });
            }

            // Form submission handler
            createUserForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Collect form data based on selected role
                let formData = new FormData();

                // Common fields
                formData.append('role', selectedRole);
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                if (selectedRole === 'mahasiswa') {
                    // Mahasiswa specific fields
                    formData.append('id', document.getElementById('m_nim').value);
                    formData.append('nim', document.getElementById('m_nim').value);
                    formData.append('email', document.getElementById('m_email').value);
                    formData.append('password', document.getElementById('m_password').value);
                    formData.append('password_confirmation', document.getElementById(
                        'm_password_confirmation').value);
                    formData.append('name', document.getElementById('m_name').value);
                    formData.append('semester', document.getElementById('m_semester').value);
                    formData.append('prodi_id', document.getElementById('m_prodi_id').value);
                    formData.append('jurusan_id', document.getElementById('m_jurusan_id').value);
                } else {
                    // Dosen specific fields
                    formData.append('id', document.getElementById('d_nip').value);
                    formData.append('nip', document.getElementById('d_nip').value);
                    formData.append('email', document.getElementById('d_email').value);
                    formData.append('password', document.getElementById('d_password').value);
                    formData.append('password_confirmation', document.getElementById(
                        'd_password_confirmation').value);
                    formData.append('name', document.getElementById('d_name').value);
                    formData.append('prodi_id', document.getElementById('d_prodi_id').value);
                    formData.append('jurusan_id', document.getElementById('d_jurusan_id').value);

                    // Dosen role type
                    formData.append('dosen_role_type', dosenRoleType);
                }

                // Validate passwords match
                const password = selectedRole === 'mahasiswa' ?
                    document.getElementById('m_password').value :
                    document.getElementById('d_password').value;

                const passwordConfirmation = selectedRole === 'mahasiswa' ?
                    document.getElementById('m_password_confirmation').value :
                    document.getElementById('d_password_confirmation').value;

                if (password !== passwordConfirmation) {
                    alert('Password dan konfirmasi password tidak cocok!');
                    return;
                }

                // Validate password strength
                if (password.length < 8) {
                    alert('Password minimal harus 8 karakter!');
                    return;
                }

                // Validate NIM/NIP format
                const id = selectedRole === 'mahasiswa' ?
                    document.getElementById('m_nim').value :
                    document.getElementById('d_nip').value;

                if (id.length < 5) {
                    alert(selectedRole === 'mahasiswa' ? 'NIM terlalu pendek!' : 'NIP terlalu pendek!');
                    return;
                }

                // Show loading state
                const submitBtn = createUserForm.querySelector('.submit-btn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                try {
                    // Send data to server using fetch
                    const response = await fetch('/api/users/create', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    // Check if request was successful
                    if (response.ok && data.success) {
                        // Show success message
                        const userName = selectedRole === 'mahasiswa' ?
                            document.getElementById('m_name').value :
                            document.getElementById('d_name').value;

                        const roleText = selectedRole === 'mahasiswa' ?
                            'Mahasiswa' :
                            (dosenRoleType === 'koordinator' ? 'Dosen Koordinator' : 'Dosen Biasa');

                        // Create success modal
                        const successModal = document.createElement('div');
                        successModal.className = 'modal fade show d-block';
                        successModal.innerHTML = `
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Berhasil!</h5>
                                        <button type="button" class="btn-close btn-close-white" onclick="this.closest('.modal').remove()"></button>
                                    </div>
                                    <div class="modal-body text-center py-4">
                                        <i class="fas fa-user-check text-success mb-3" style="font-size: 4rem;"></i>
                                        <h4 class="mb-3">Akun Berhasil Dibuat</h4>
                                        <p>Akun <strong>${roleText}</strong> untuk <strong>${userName}</strong> berhasil dibuat.</p>
                                        <p class="text-muted">ID Login: ${id}</p>
                                        ${selectedRole === 'dosen' && dosenRoleType === 'koordinator' 
                                            ? '<p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Koordinator memiliki akses admin penuh</p>' 
                                            : ''}
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-success px-4" onclick="this.closest('.modal').remove(); resetForm();">Buat Akun Lain</button>
                                        <a href="dashboard.html" class="btn btn-outline-success px-4">Kembali ke Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(successModal);
                    } else {
                        // Show error message from server
                        const errorMessage = data.message || 'Terjadi kesalahan saat membuat akun.';
                        alert(`Error: ${errorMessage}`);

                        // If there are validation errors, show them
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                            // You can implement more specific error handling here
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                } finally {
                    // Restore button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
            // Reset form handler
            resetFormBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin mengosongkan semua data pada form?')) {
                    resetFormForRole(selectedRole);
                    // Reset role to default
                    selectRole('mahasiswa');
                }
            });

            // Initialize with mahasiswa selected
            selectRole('mahasiswa');
            selectDosenRoleType('dosen_biasa');
            setupPasswordStrength();

            // Auto-generate email based on NIM/NIP
            function setupAutoEmailGeneration() {
                // For mahasiswa
                const nimInput = document.getElementById('m_nim');
                const mEmailInput = document.getElementById('m_email');

                nimInput.addEventListener('blur', function() {
                    if (nimInput.value && !mEmailInput.value) {
                        mEmailInput.value = nimInput.value + '@mhs.polman-bandung.ac.id';
                    }
                });

                // For dosen
                const nipInput = document.getElementById('d_nip');
                const dEmailInput = document.getElementById('d_email');

                nipInput.addEventListener('blur', function() {
                    if (nipInput.value && !dEmailInput.value) {
                        dEmailInput.value = nipInput.value + '@dosen.polman-bandung.ac.id';
                    }
                });
            }

            setupAutoEmailGeneration();

            // Make reset function globally accessible
            window.resetForm = function() {
                resetFormForRole(selectedRole);
            };

            // Responsive layout adjustments
            function adjustLayout() {
                const screenWidth = window.innerWidth;
                const roleSelector = document.querySelector('.role-selector');
                const dosenRoleSelector = document.querySelector('.dosen-role-selector');

                if (screenWidth < 992) {
                    roleSelector.style.flexDirection = 'column';
                    roleSelector.style.alignItems = 'center';
                    dosenRoleSelector.style.flexDirection = 'column';
                } else {
                    roleSelector.style.flexDirection = 'row';
                    roleSelector.style.justifyContent = 'center';
                    dosenRoleSelector.style.flexDirection = 'row';
                }
            }

            // Adjust layout on resize
            window.addEventListener('resize', adjustLayout);
            adjustLayout(); // Initial call
        });
    </script>
@endsection
