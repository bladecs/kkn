@extends('dashboard.admin.layouts.app')

@section('title', 'Dashboard Admin Sistem Informasi KKN')

@section('style')
    <style>
        :root {
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --danger-color: #dc3545;
            --purple-color: #6f42c1;
            --teal-color: #20c997;
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
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
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

        .quick-access-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 25px 15px;
            height: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .quick-access-card:hover {
            background-color: #f8f9fa;
        }

        .quick-access-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
        }

        .quick-access-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .quick-access-desc {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* User table styles */
        .user-table-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
        }

        .status-active {
            color: var(--success-color);
            font-weight: 600;
        }

        .status-inactive {
            color: var(--danger-color);
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
@endsection

@section('content')
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body py-4">
                        <h1 class="card-title"><i class="fas fa-user-shield me-2"></i> Dashboard Admin Sistem Informasi KKN
                        </h1>
                        <p class="card-text mb-0">Kuliah Kerja Nyata - Universitas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pengguna -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon text-primary">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-number" id="mahasiswaCount">{{ $mahasiswa }}</div>
                    <div class="stat-label">Mahasiswa Terdaftar</div>
                    <div class="mt-2">
                        <span class="badge bg-primary">Aktif: {{ $mahasiswa }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon text-success">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-number" id="dosenCount">{{ $dosen }}</div>
                    <div class="stat-label">Dosen Pembimbing</div>
                    <div class="mt-2">
                        <span class="badge bg-success">Aktif: {{ $dosen }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon text-warning">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number" id="koordinatorCount">{{ $koordinator }}</div>
                    <div class="stat-label">Koordinator KKN</div>
                    <div class="mt-2">
                        <span class="badge bg-warning">Aktif: {{ $koordinator }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access untuk Manajemen Akun & Role -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-header">
                            <i class="fas fa-bolt section-icon"></i>
                            <h5 class="section-title">Quick Access - Manajemen Akun & Role</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card quick-access-card" onclick="openCreateAccountModal()">
                                    <div class="quick-access-icon" style="background-color: var(--primary-color);">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h6 class="quick-access-title">Buat Akun Baru</h6>
                                    <p class="quick-access-desc">Tambahkan pengguna baru (mahasiswa, dosen, koordinator)</p>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card quick-access-card" onclick="location.href='#'">
                                    <div class="quick-access-icon" style="background-color: var(--warning-color);">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <h6 class="quick-access-title">Manajemen Akun</h6>
                                    <p class="quick-access-desc">Kelola semua akun pengguna dalam sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengguna Terbaru -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-header">
                            <i class="fas fa-users section-icon"></i>
                            <h5 class="section-title">Pengguna Terbaru</h5>
                            <a href="#" class="btn btn-primary btn-sm ms-auto">Lihat Semua</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($new_users as $user)
                                        <tr>
                                            <td><img src="https://via.placeholder.com/40" alt="User"
                                                    class="user-table-img">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><span class="badge bg-primary role-badge">{{ $user->role }}</span></td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td><span class="status-active">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i
                                                        class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Sistem -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Ringkasan Sistem</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Pengguna:</span>
                            <span class="fw-bold">1,338</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Kelompok KKN:</span>
                            <span class="fw-bold">45</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Lokasi KKN:</span>
                            <span class="fw-bold">12 Desa</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Laporan Masuk:</span>
                            <span class="fw-bold">230</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Role dalam Sistem:</span>
                            <span class="fw-bold">5</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Aktivitas Terbaru</h5>
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Akun baru dibuat</h6>
                                    <small>5 menit lalu</small>
                                </div>
                                <p class="mb-1">Dr. Ahmad Fauzi berhasil ditambahkan sebagai dosen pembimbing.</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Role diperbarui</h6>
                                    <small>1 jam lalu</small>
                                </div>
                                <p class="mb-1">Permission untuk role "Koordinator" telah diperbarui.</p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Akun dinonaktifkan</h6>
                                    <small>2 jam lalu</small>
                                </div>
                                <p class="mb-1">Akun mahasiswa dengan NIM 19012345 telah dinonaktifkan.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Buat Akun Baru -->
    <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAccountModalLabel"><i class="fas fa-user-plus me-2"></i> Buat
                        Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createAccountForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="accountName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="accountName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="accountEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="accountEmail" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="accountRole" class="form-label">Role</label>
                                <select class="form-select" id="accountRole" required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="koordinator">Koordinator</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="accountStatus" class="form-label">Status</label>
                                <select class="form-select" id="accountStatus" required>
                                    <option value="active" selected>Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="accountPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="accountPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="accountConfirmPassword" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="accountConfirmPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitAccountForm()">Buat Akun</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Buat Role Baru -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel"><i class="fas fa-user-tag me-2"></i> Buat Role
                        Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createRoleForm">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Nama Role</label>
                            <input type="text" class="form-control" id="roleName" required>
                        </div>
                        <div class="mb-3">
                            <label for="roleDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="roleDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permDashboard">
                                <label class="form-check-label" for="permDashboard">Akses Dashboard</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permManageUsers">
                                <label class="form-check-label" for="permManageUsers">Manajemen Pengguna</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permManageReports">
                                <label class="form-check-label" for="permManageReports">Manajemen Laporan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permManageLocations">
                                <label class="form-check-label" for="permManageLocations">Manajemen Lokasi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permManageSettings">
                                <label class="form-check-label" for="permManageSettings">Pengaturan Sistem</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="submitRoleForm()">Buat Role</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        // Initialize modals
        const createAccountModal = new bootstrap.Modal(document.getElementById('createAccountModal'));
        const createRoleModal = new bootstrap.Modal(document.getElementById('createRoleModal'));

        // Make modal functions globally accessible
        window.openCreateAccountModal = function() {
            createAccountModal.show();
        };

        window.openCreateRoleModal = function() {
            createRoleModal.show();
        };

        // Form submission functions
        window.submitAccountForm = function() {
            // In a real application, you would submit the form data to the server
            const name = document.getElementById('accountName').value;
            const role = document.getElementById('accountRole').value;

            alert(`Akun ${name} berhasil dibuat sebagai ${role}!`);
            createAccountModal.hide();

            // Reset form
            document.getElementById('createAccountForm').reset();
        };

        window.submitRoleForm = function() {
            // In a real application, you would submit the form data to the server
            const roleName = document.getElementById('roleName').value;

            alert(`Role "${roleName}" berhasil dibuat!`);
            createRoleModal.hide();

            // Reset form
            document.getElementById('createRoleForm').reset();
        };
    </script>
@endsection
