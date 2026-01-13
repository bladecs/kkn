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

        .badge-mahasiswa {
            background-color: #007bff !important;
        }

        .badge-dosen {
            background-color: #28a745 !important;
        }

        .badge-koordinator {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .status-active {
            color: var(--success-color);
            font-weight: 600;
        }

        .status-inactive {
            color: var(--danger-color);
            font-weight: 600;
        }

        /* Action buttons */
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 0.85rem;
            margin-right: 5px;
        }

        /* Table tabs */
        .table-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .table-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .table-tabs .nav-link:hover {
            color: #007bff;
            background-color: rgba(0, 123, 255, 0.05);
        }

        .table-tabs .nav-link.active {
            color: #007bff;
            background-color: transparent;
            border-bottom: 3px solid #007bff;
        }

        /* Tab content */
        .tab-content {
            margin-top: 20px;
        }

        /* Select styling */
        .form-select {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-select:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-icon {
                font-size: 2rem;
            }

            .table-tabs .nav-link {
                padding: 8px 12px;
                font-size: 0.9rem;
            }

            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .action-buttons .btn {
                margin-right: 0;
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
                    <div class="stat-label">Mahasiswa Aktif</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon text-success">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-number" id="dosenCount">{{ $dosen }}</div>
                    <div class="stat-label">Dosen Aktif</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="stat-icon text-warning">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-number" id="koordinatorCount">{{ $koordinator }}</div>
                    <div class="stat-label">Koordinator Aktif</div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengguna -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-header">
                            <i class="fas fa-users section-icon"></i>
                            <h5 class="section-title">Manajemen Pengguna</h5>
                        </div>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs table-tabs" id="userTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="mahasiswa-tab" data-bs-toggle="tab"
                                    data-bs-target="#mahasiswa" type="button" role="tab" aria-controls="mahasiswa"
                                    aria-selected="true">
                                    <i class="fas fa-user-graduate me-2"></i>Mahasiswa ({{ $mahasiswa }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="dosen-tab" data-bs-toggle="tab" data-bs-target="#dosen"
                                    type="button" role="tab" aria-controls="dosen" aria-selected="false">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Dosen ({{ $dosen }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="koordinator-tab" data-bs-toggle="tab"
                                    data-bs-target="#koordinator" type="button" role="tab" aria-controls="koordinator"
                                    aria-selected="false">
                                    <i class="fas fa-user-tie me-2"></i>Koordinator ({{ $koordinator }})
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="userTabsContent">
                            <!-- Tab Mahasiswa -->
                            <div class="tab-pane fade show active" id="mahasiswa" role="tabpanel"
                                aria-labelledby="mahasiswa-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Email</th>
                                                <th>Prodi</th>
                                                <th>Jurusan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mahasiswa_list as $user)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://placehold.co/400' }}"
                                                            alt="User" class="user-table-img">
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->nim ?? '-' }}</td>
                                                    <td>{{ $user->user->email }}</td>
                                                    <td>{{ $user->prodi->nama_prodi ?? '-' }}</td>
                                                    <td>{{ $user->jurusan->nama_jurusan ?? '-' }}</td>
                                                    <td class="action-buttons">
                                                        <!-- Tombol Edit dengan data attributes -->
                                                        <button class="btn btn-sm btn-outline-primary edit-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                            data-user-id="{{ $user->user->id }}" data-role="mahasiswa"
                                                            data-name="{{ $user->name }}"
                                                            data-email="{{ $user->user->email }}"
                                                            data-status="{{ $user->user->status }}"
                                                            data-nim="{{ $user->nim ?? '' }}"
                                                            data-jurusan-id="{{ $user->jurusan_id ?? '' }}"
                                                            data-prodi-id="{{ $user->prodi_id ?? '' }}"
                                                            data-angkatan="{{ $user->angkatan ?? '' }}"
                                                            data-kelas="{{ $user->kelas ?? '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Tombol Delete dengan data attributes -->
                                                        <button class="btn btn-sm btn-outline-danger delete-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                            data-user-id="{{ $user->user->id }}" data-role="mahasiswa"
                                                            data-name="{{ $user->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Dosen -->
                            <div class="tab-pane fade" id="dosen" role="tabpanel" aria-labelledby="dosen-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Email</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dosen_list as $user)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://placehold.co/400' }}"
                                                            alt="User" class="user-table-img">
                                                    </td>
                                                    <td>{{ $user->dosen->name }}</td>
                                                    <td>{{ $user->dosen->nip ?? '-' }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->dosen->jurusan->nama_jurusan ?? '-' }}</td>
                                                    <td>{{ $user->dosen->prodi->nama_prodi ?? '-' }}</td>
                                                    <td class="action-buttons">
                                                        <!-- Tombol Edit -->
                                                        <button class="btn btn-sm btn-outline-primary edit-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                            data-user-id="{{ $user->id }}" data-role="dosen"
                                                            data-name="{{ $user->dosen->name }}"
                                                            data-email="{{ $user->email }}"
                                                            data-status="{{ $user->status }}"
                                                            data-nip="{{ $user->dosen->nip ?? '' }}"
                                                            data-nidn="{{ $user->dosen->nidn ?? '' }}"
                                                            data-jurusan-id="{{ $user->dosen->jurusan_id ?? '' }}"
                                                            data-prodi-id="{{ $user->dosen->prodi_id ?? '' }}"
                                                            data-bidang="{{ $user->dosen->bidang_keahlian ?? '' }}"
                                                            data-golongan="{{ $user->dosen->golongan ?? '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Tombol Delete -->
                                                        <button class="btn btn-sm btn-outline-danger delete-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                            data-user-id="{{ $user->id }}" data-role="dosen"
                                                            data-name="{{ $user->dosen->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Tab Koordinator -->
                            <div class="tab-pane fade" id="koordinator" role="tabpanel"
                                aria-labelledby="koordinator-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Email</th>
                                                <th>Jurusan</th>
                                                <th>Prodi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($koordinator_list as $user)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://placehold.co/400' }}"
                                                            alt="User" class="user-table-img">
                                                    </td>
                                                    <td>{{ $user->dosen->name }}</td>
                                                    <td>{{ $user->dosen->nip ?? '-' }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->dosen->jurusan->nama_jurusan ?? '-' }}</td>
                                                    <td>{{ $user->dosen->prodi->nama_prodi ?? '-' }}</td>
                                                    <td class="action-buttons">
                                                        <!-- Tombol Edit -->
                                                        <button class="btn btn-sm btn-outline-primary edit-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                            data-user-id="{{ $user->id }}" data-role="koordinator"
                                                            data-name="{{ $user->dosen->name }}"
                                                            data-email="{{ $user->email }}"
                                                            data-status="{{ $user->status }}"
                                                            data-nip="{{ $user->dosen->nip ?? '' }}"
                                                            data-jurusan-id="{{ $user->dosen->jurusan_id ?? '' }}"
                                                            data-prodi-id="{{ $user->dosen->prodi_id ?? '' }}"
                                                            data-unit-kerja="{{ $user->dosen->unit_kerja ?? '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Tombol Delete -->
                                                        <button class="btn btn-sm btn-outline-danger delete-user-btn"
                                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                            data-user-id="{{ $user->id }}" data-role="koordinator"
                                                            data-name="{{ $user->dosen->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel"><i class="fas fa-user-edit me-2"></i> Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        <input type="hidden" id="editUserId" name="id">
                        <input type="hidden" id="editUserRole" name="role">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editUserName" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="editUserName" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editUserEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="editUserEmail" name="email" required>
                            </div>
                        </div>

                        <!-- Mahasiswa Fields -->
                        <div id="mahasiswaFields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserNIM" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="editUserNIM" name="nim" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editUserProdiMahasiswa" class="form-label">Program Studi</label>
                                    <select class="form-select" id="editUserProdiMahasiswa" name="prodi_id">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserJurusanMahasiswa" class="form-label">Jurusan</label>
                                    <select class="form-select" id="editUserJurusanMahasiswa" name="jurusan_id">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Dosen Fields -->
                        <div id="dosenFields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserNIP" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="editUserNIP" name="nip" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserJurusanDosen" class="form-label">Jurusan</label>
                                    <select class="form-select" id="editUserJurusanDosen" name="jurusan_id">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editUserProdiDosen" class="form-label">Program Studi</label>
                                    <select class="form-select" id="editUserProdiDosen" name="prodi_id">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Koordinator Fields -->
                        <div id="koordinatorFields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserNIPKoordinator" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="editUserNIPKoordinator"
                                        name="nip" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editUserJurusanKoordinator" class="form-label">Jurusan</label>
                                    <select class="form-select" id="editUserJurusanKoordinator" name="jurusan_id">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editUserProdiKoordinator" class="form-label">Program Studi</label>
                                    <select class="form-select" id="editUserProdiKoordinator" name="prodi_id">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editUserPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="editUserPassword" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete User -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><i class="fas fa-trash me-2"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteUserId">
                    <input type="hidden" id="deleteUserRole">
                    <p id="deleteUserMessage">Apakah Anda yakin ingin menghapus user ini?</p>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus User</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk modal edit
            const editUserModalElement = document.getElementById('editUserModal');
            editUserModalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const role = button.getAttribute('data-role');
                const name = button.getAttribute('data-name');
                const email = button.getAttribute('data-email');

                // Update modal title
                const modalTitle = editUserModalElement.querySelector('.modal-title');
                const roleName = role === 'mahasiswa' ? 'Mahasiswa' :
                    role === 'dosen' ? 'Dosen' : 'Koordinator';
                modalTitle.innerHTML = `<i class="fas fa-user-edit me-2"></i> Edit ${roleName}`;

                // Set nilai form dasar
                document.getElementById('editUserId').value = userId;
                document.getElementById('editUserRole').value = role;
                document.getElementById('editUserName').value = name;
                document.getElementById('editUserEmail').value = email;
                document.getElementById('editUserPassword').value = '';

                // Sembunyikan semua fields spesifik role
                document.getElementById('mahasiswaFields').style.display = 'none';
                document.getElementById('dosenFields').style.display = 'none';
                document.getElementById('koordinatorFields').style.display = 'none';

                // Tampilkan fields untuk role yang sesuai
                if (role === 'mahasiswa') {
                    document.getElementById('mahasiswaFields').style.display = 'block';
                    document.getElementById('editUserNIM').value = button.getAttribute('data-nim') || '';

                    // Set jurusan dan prodi (otomatis terpilih karena options sudah ada di HTML)
                    document.getElementById('editUserJurusanMahasiswa').value = button.getAttribute(
                        'data-jurusan-id') || '';
                    document.getElementById('editUserProdiMahasiswa').value = button.getAttribute(
                        'data-prodi-id') || '';

                } else if (role === 'dosen') {
                    document.getElementById('dosenFields').style.display = 'block';
                    document.getElementById('editUserNIP').value = button.getAttribute('data-nip') || '';

                    // Set jurusan dan prodi
                    document.getElementById('editUserJurusanDosen').value = button.getAttribute(
                        'data-jurusan-id') || '';
                    document.getElementById('editUserProdiDosen').value = button.getAttribute(
                        'data-prodi-id') || '';

                } else if (role === 'koordinator') {
                    document.getElementById('koordinatorFields').style.display = 'block';
                    document.getElementById('editUserNIPKoordinator').value = button.getAttribute(
                        'data-nip') || '';

                    // Set jurusan dan prodi
                    document.getElementById('editUserJurusanKoordinator').value = button.getAttribute(
                        'data-jurusan-id') || '';
                    document.getElementById('editUserProdiKoordinator').value = button.getAttribute(
                        'data-prodi-id') || '';
                }
            });

            // Event listener untuk modal delete
            const deleteUserModalElement = document.getElementById('deleteUserModal');
            deleteUserModalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const role = button.getAttribute('data-role');
                const name = button.getAttribute('data-name');

                // Set nilai hidden inputs
                document.getElementById('deleteUserId').value = userId;
                document.getElementById('deleteUserRole').value = role;

                // Update pesan konfirmasi
                const deleteMessage = document.getElementById('deleteUserMessage');
                const roleName = role === 'mahasiswa' ? 'Mahasiswa' :
                    role === 'dosen' ? 'Dosen' : 'Koordinator';
                deleteMessage.innerHTML =
                    `Apakah Anda yakin ingin menghapus ${roleName} <strong>"${name}"</strong>?`;
            });

            // Event listener untuk tombol save edit
            document.getElementById('saveEditBtn').addEventListener('click', updateUser);

            // Event listener untuk tombol confirm delete
            document.getElementById('confirmDeleteBtn').addEventListener('click', deleteUser);
        });

        // Fungsi update user
        function updateUser() {
            const form = document.getElementById('editUserForm');
            const formData = new FormData(form);

            // Tambahkan _method untuk Laravel (PUT)
            formData.append('_method', 'POST');

            // Tampilkan loading state
            const saveBtn = document.getElementById('saveEditBtn');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            saveBtn.disabled = true;

            // Kirim request AJAX
            fetch('/api/users/' + formData.get('id') + '/update', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan notifikasi sukses
                        showToast('success', data.message);

                        // Tutup modal
                        const editModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                        editModal.hide();

                        // Refresh halaman setelah 1 detik
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        // Tampilkan error
                        showToast('error', data.message || 'Terjadi kesalahan saat menyimpan data.');

                        // Reset tombol
                        saveBtn.innerHTML = originalText;
                        saveBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');

                    // Reset tombol
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                });
        }

        // Fungsi delete user
        function deleteUser() {
            const userId = document.getElementById('deleteUserId').value;
            const role = document.getElementById('deleteUserRole').value;

            // Tampilkan loading state
            const deleteBtn = document.getElementById('confirmDeleteBtn');
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
            deleteBtn.disabled = true;

            // Kirim request AJAX
            fetch('/api/users/' + userId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        id: userId,
                        role: role,
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan notifikasi sukses
                        showToast('success', data.message);

                        // Tutup modal
                        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteUserModal'));
                        deleteModal.hide();

                        // Refresh halaman setelah 1 detik
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        // Tampilkan error
                        showToast('error', data.message || 'Terjadi kesalahan saat menghapus data.');

                        // Reset tombol
                        deleteBtn.innerHTML = originalText;
                        deleteBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');

                    // Reset tombol
                    deleteBtn.innerHTML = originalText;
                    deleteBtn.disabled = false;
                });
        }

        // Fungsi untuk menampilkan toast notification
        function showToast(type, message) {
            // Hapus toast yang sudah ada
            const existingToast = document.querySelector('.toast-container');
            if (existingToast) {
                existingToast.remove();
            }

            // Buat container toast
            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';

            // Buat toast
            const toast = document.createElement('div');
            toast.className =
            `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            // Toast content
            toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

            toastContainer.appendChild(toast);
            document.body.appendChild(toastContainer);

            // Inisialisasi dan tampilkan toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            // Hapus toast setelah 5 detik
            setTimeout(() => {
                if (toastContainer.parentNode) {
                    toastContainer.remove();
                }
            }, 5000);
        }
    </script>
@endsection
