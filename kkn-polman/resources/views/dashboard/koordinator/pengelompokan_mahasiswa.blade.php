@extends('dashboard.koordinator.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
        /* Grouping Container */
        .grouping-container {
            width: 100vw;
            margin: 0 30px;
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

        .grouping-card {
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 30px;
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
            display: flex;
            flex-direction: row;
            gap: 20px;
            justify-content: space-between;
            align-items: end;
            height: 120px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-group {
            flex: 2;
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
            width: 100%;
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

        .grid-center {
            grid-column: 1 / -1;
            text-align: center;
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
            grid-template-columns: repeat(4, 1fr);
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

        .btn-wrapper {
            flex: 1;
            display: flex;
            align-items: stretch;
        }

        .btn-wrapper button {
            width: 100%;
            height: 100%;
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

        /* Enhanced Modal Styles */
        .modal-enhanced {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .modal-enhanced .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modal-enhanced .modal-header {
            background: linear-gradient(135deg, var(--primary-color), #2c5aa0);
            color: white;
            border-bottom: none;
            padding: 25px 30px;
            position: relative;
        }

        .modal-enhanced .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
        }

        .modal-enhanced .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .modal-enhanced .modal-title i {
            margin-right: 10px;
            font-size: 1.8rem;
        }

        .modal-enhanced .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-enhanced .modal-body {
            padding: 30px;
            background: #f8fafc;
        }

        .modal-enhanced .form-group {
            margin-bottom: 5px;
        }

        .modal-enhanced .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .modal-enhanced .form-label i {
            margin-right: 8px;
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }

        .modal-enhanced .form-control,
        .modal-enhanced .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .modal-enhanced .form-control:focus,
        .modal-enhanced .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }

        .modal-enhanced .input-group {
            border-radius: 12px;
            overflow: hidden;
        }

        .modal-enhanced .input-group-text {
            background: #edf2f7;
            border: 2px solid #e2e8f0;
            border-right: none;
            color: #4a5568;
        }

        .modal-enhanced .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            background: white;
        }

        .modal-enhanced .btn {
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .modal-enhanced .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #2c5aa0);
            border: none;
            box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
        }

        .modal-enhanced .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 153, 225, 0.4);
        }

        .modal-enhanced .btn-secondary {
            background: #718096;
            border: none;
        }

        .modal-enhanced .btn-secondary:hover {
            background: #4a5568;
        }

        /* Member Filter Section */
        .member-filters {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            margin-bottom: 0;
        }

        .filter-group label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn-filter {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            color: #4a5568;
        }

        .btn-outline-secondary:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }

        /* Members Table */
        .members-selection {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .table-header {
            background: #f7fafc;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .members-table {
            width: 100%;
            margin-bottom: 0;
        }

        .members-table thead th {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            color: #4a5568;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .members-table tbody tr {
            transition: background-color 0.2s;
        }

        .members-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .members-table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .members-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Checkbox styling */
        .member-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #cbd5e0;
            cursor: pointer;
        }

        .member-checkbox:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Badge styles */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .bg-success {
            background-color: #48bb78 !important;
        }

        .bg-warning {
            background-color: #ed8936 !important;
        }

        .bg-secondary {
            background-color: #a0aec0 !important;
        }

        /* Selected members counter */
        .selected-counter {
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .selected-counter i {
            font-size: 1rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #a0aec0;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filter-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .filter-actions {
                justify-content: stretch;
            }

            .filter-actions .btn {
                flex: 1;
            }

            .members-table thead th:nth-child(3),
            .members-table td:nth-child(3) {
                display: none;
            }
        }

        /* Form validation styles */
        .modal-enhanced .is-valid {
            border-color: #38a169;
        }

        .modal-enhanced .is-invalid {
            border-color: #e53e3e;
        }

        .modal-enhanced .valid-feedback,
        .modal-enhanced .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="grouping-container">
            <!-- Header -->
            <div class="grouping-header">
                <h1><i class="fas fa-users me-2"></i> Pengelompokan Mahasiswa KKN</h1>
                <p>Informasi kelompok dan anggota KKN periode 2023</p>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filter-group">
                    <label class="filter-label">Jurusan</label>
                    <select class="filter-select">
                        <option value="">Semua Jurusan</option>
                        <option value="ae">Automation Engineering</option>
                        <option value="me">Manufacture Engineering</option>
                        <option value="de">Desain Engineering</option>
                        <option value="fe">Foundry Engineering</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="pending">Menunggu</option>
                        <option value="complete">Selesai</option>
                    </select>
                </div>

                <div class="btn-wrapper">
                    <button class="btn btn-primary py-3" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                        <i class="fas fa-plus me-2"></i> Tambah Kelompok Baru
                    </button>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">{{ count($pengelompokan) }}</div>
                        <div class="stat-label">Total Kelompok</div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-number">{{ count($mahasiswa) }}</div>
                        <div class="stat-label">Total Mahasiswa</div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-number">{{ count($lokasi) }}</div>
                        <div class="stat-label">Lokasi KKN</div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-number">{{ count($dosen) }}</div>
                        <div class="stat-label">Dosen Pembimbing</div>
                    </div>
                </div>
            </div>

            <!-- Groups Grid -->
            <div class="groups-grid">
                @if (isset($pengelompokan) && count($pengelompokan) > 0)
                    @foreach ($pengelompokan as $index => $group)
                        <div class="group-card">
                            <div class="group-header">
                                <div class="group-name">{{ $group->nama_kelompok }}</div>
                                <div class="group-location">{{ $group->lokasi->nama_lokasi }}</div>
                            </div>
                            <div class="group-body">
                                <div class="group-info">
                                    <div class="info-item">
                                        <span class="info-label">Dosen Pembimbing</span>
                                        <span class="info-value">{{ $group->dosen->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Anggota</span>
                                        <span class="info-value">{{ $group->jumlah_anggota }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Periode</span>
                                        <span class="info-value">{{ $group->tanggal_mulai }} -
                                            {{ $group->tanggal_selesai }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Status</span>
                                        @if ($group->status == 'pending')
                                            <span class="info-value" style="color: #a77b28;">Menunggu</span>
                                        @elseif ($group->status == 'active')
                                            <span class="info-value" style="color: #28a745;">Aktif</span>
                                        @elseif ($group->status == 'completed')
                                            <span class="info-value" style="color: #6c757d;">Selesai</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="members-list">
                                    <div class="members-title">Anggota Kelompok</div>

                                    @php
                                        $anggota = $mahasiswa->where('id_pengelompokan', $group->id);
                                    @endphp

                                    @if ($anggota->count() > 0)
                                        @foreach ($anggota as $member)
                                            <div class="member-item">
                                                <img src="https://via.placeholder.com/40" class="member-avatar">

                                                <div class="member-details">
                                                    <div class="member-name">{{ $member->name }}
                                                        {{ $member->is_ketua ? '(Ketua)' : '' }}</div>
                                                    <div class="member-faculty">{{ $member->study_program }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">Tidak ada anggota dalam kelompok ini.</p>
                                    @endif
                                </div>

                            </div>
                            <div class="group-actions">
                                <a href="#" class="btn-group">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="grid-center">Tidak ada data pengelompokan mahasiswa tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Modal Tambah Kelompok -->
    <div class="modal fade modal-enhanced" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGroupModalLabel">
                        <i class="fas fa-users"></i> Buat Kelompok KKN Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('buat-pengelompokan') }}" method="POST" id="addGroupForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_kelompok" class="form-label">
                                        <i class="fas fa-tag"></i> Nama Kelompok
                                    </label>
                                    <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok"
                                        placeholder="Masukkan nama kelompok" required>
                                    <div class="invalid-feedback">Harap masukkan nama kelompok.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_dosen" class="form-label">
                                        <i class="fas fa-user-tie"></i> Dosen Pembimbing
                                    </label>
                                    <select class="form-select" id="id_dosen" name="nip" required>
                                        <option value="" selected disabled>Pilih Dosen Pembimbing</option>
                                        @foreach ($dosen as $dosenItem)
                                            <option value="{{ $dosenItem->nip }}">{{ $dosenItem->name }} -
                                                {{ $dosenItem->nip }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Harap pilih dosen pembimbing.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_project" class="form-label">
                                        <i class="fas fa-project-diagram"></i> Project KKN
                                    </label>
                                    <select class="form-select" id="id_project" name="id_project">
                                        <option value="" disabled selected>Pilih Project (Opsional)</option>
                                        @foreach ($project as $projectItem)
                                            <option value="{{ $projectItem->id }}">{{ $projectItem->judul_project }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                        required>
                                    <div class="invalid-feedback">Harap pilih tanggal mulai.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai" class="form-label">
                                        <i class="fas fa-calendar-check"></i> Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_selesai"
                                        name="tanggal_selesai" required>
                                    <div class="invalid-feedback">Harap pilih tanggal selesai.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Member Selection Section -->
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">
                                    <i class="fas fa-user-graduate"></i> Pilih Anggota Kelompok
                                </label>
                                <div class="selected-counter">
                                    <i class="fas fa-users"></i>
                                    <span id="selectedCount">0</span> Mahasiswa Terpilih
                                </div>
                            </div>

                            <!-- Member Filters -->
                            <div class="member-filters">
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="filterProdi">Program Studi</label>
                                        <select class="form-select" id="filterProdi">
                                            <option value="">Semua Program Studi</option>
                                            <option value="ae">Automation Engineering</option>
                                            <option value="me">Manufacture Engineering</option>
                                            <option value="de">Desain Engineering</option>
                                            <option value="fe">Foundry Engineering</option>
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="searchNim">Cari NIM atau Nama</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="searchNim"
                                                placeholder="Masukkan NIM atau nama...">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="filter-actions">
                                        <button type="button" class="btn btn-outline-secondary btn-filter"
                                            id="applyFilters">
                                            <i class="fas fa-filter me-1"></i> Filter
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-filter"
                                            id="resetFilters">
                                            <i class="fas fa-redo me-1"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Members Table -->
                            <div class="members-selection">
                                <div class="table-header">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllMembers">
                                        <label class="form-check-label fw-bold" for="selectAllMembers">
                                            Pilih Semua Mahasiswa yang Tersedia
                                        </label>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table members-table">
                                        <thead>
                                            <tr>
                                                <th width="5%">Pilih</th>
                                                <th width="15%">NIM</th>
                                                <th width="23%">Nama</th>
                                                <th width="21%">Program Studi</th>
                                                <th width="21%">Jurusan</th>
                                                <th width="15%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="membersTableBody">
                                            @php
                                                $availableStudents = $mahasiswa->whereIn('id_pengelompokan', [
                                                    null,
                                                    '-',
                                                ]);
                                            @endphp

                                            @if ($availableStudents->count() > 0)
                                                @foreach ($availableStudents as $mhs)
                                                    <tr class="member-row" data-prodi="{{ $mhs->jurusan }}"
                                                        data-nim="{{ $mhs->nim }}" data-nama="{{ $mhs->name }}">
                                                        <td class="text-center">
                                                            <input type="checkbox" name="anggota[]"
                                                                value="{{ $mhs->nim }}"
                                                                class="form-check-input member-checkbox">
                                                        </td>
                                                        <td>{{ $mhs->nim }}</td>
                                                        <td>{{ $mhs->name }}</td>
                                                        <td>{{ $mhs->study_program }}</td>
                                                        <td>
                                                            @if ($mhs->jurusan == 'ae')
                                                                Automation Engineering
                                                            @elseif ($mhs->jurusan == 'me')
                                                                Manufacture Engineering
                                                            @elseif ($mhs->jurusan == 'de')
                                                                Desain Engineering
                                                            @elseif ($mhs->jurusan == 'fe')
                                                                Foundry Engineering
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success">Tersedia</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="empty-state">
                                                            <i class="fas fa-users-slash"></i>
                                                            <p>Tidak ada mahasiswa yang tersedia untuk kelompok baru.</p>
                                                            <small class="text-muted">Semua mahasiswa sudah memiliki
                                                                kelompok KKN.</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Pilih mahasiswa yang akan dimasukkan ke dalam
                                    kelompok ini. Hanya mahasiswa yang belum memiliki kelompok yang ditampilkan.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitGroupBtn">
                            <i class="fas fa-save me-1"></i> Simpan Kelompok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Filter functionality
            $('.filter-select').on('change', function() {
                const location = $('#location-filter').val();
                const faculty = $('#faculty-filter').val();
                const group = $('#group-filter').val();
                console.log('Filtering by:', {
                    location,
                    faculty,
                    group
                });
            });

            // Update selected members counter
            function updateSelectedCounter() {
                const selectedCount = $('.member-checkbox:checked').length;
                $('#selectedCount').text(selectedCount);
            }

            // Select all members functionality
            $('#selectAllMembers').on('change', function() {
                $('.member-checkbox:visible').prop('checked', $(this).prop('checked'));
                updateSelectedCounter();
            });

            // Individual checkbox change
            $(document).on('change', '.member-checkbox', function() {
                updateSelectedCounter();

                // Update select all checkbox state
                const visibleCheckboxes = $('.member-checkbox:visible');
                const checkedVisible = $('.member-checkbox:visible:checked');

                if (checkedVisible.length === 0) {
                    $('#selectAllMembers').prop('checked', false);
                } else if (checkedVisible.length === visibleCheckboxes.length) {
                    $('#selectAllMembers').prop('checked', true);
                } else {
                    $('#selectAllMembers').prop('checked', false);
                }
            });

            // Function to filter members
            function filterMembers() {
                const selectedProdi = $('#filterProdi').val() || '';
                const searchTerm = $('#searchNim').val() || '';

                const selectedProdiLower = selectedProdi.toLowerCase();
                const searchTermLower = searchTerm.toLowerCase();

                $('.member-row').each(function() {
                    const $row = $(this);

                    // Get data with fallback to empty string if undefined
                    const prodi = ($row.data('prodi') || '').toString().toLowerCase();
                    const nim = ($row.data('nim') || '').toString().toLowerCase();
                    const nama = ($row.data('nama') || '').toString().toLowerCase();

                    // Check if row matches filters
                    const prodiMatch = !selectedProdiLower || prodi.includes(selectedProdiLower);
                    const searchMatch = !searchTermLower ||
                        nim.includes(searchTermLower) ||
                        nama.includes(searchTermLower);

                    // Show/hide row based on filter matches
                    if (prodiMatch && searchMatch) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });

                updateSelectedCounter();
            }

            // Filter members by program study and search in real-time
            $('#filterProdi').on('change', function() {
                filterMembers();
            });

            $('#searchNim').on('input', function() {
                filterMembers();
            });

            // Reset filters
            $('#resetFilters').on('click', function() {
                $('#filterProdi').val('');
                $('#searchNim').val('');
                filterMembers();
            });

            // Form validation for modal
            $('#addGroupForm').on('submit', function(e) {
                let isValid = true;

                // Check required fields
                $('#addGroupForm [required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Check if at least one member is selected
                if ($('.member-checkbox:checked').length === 0) {
                    alert('Pilih setidaknya satu mahasiswa untuk kelompok ini.');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('.is-invalid').first().focus();
                }
            });

            // Date validation - end date should be after start date
            $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
                const startDate = new Date($('#tanggal_mulai').val());
                const endDate = new Date($('#tanggal_selesai').val());

                if (startDate && endDate && startDate > endDate) {
                    $('#tanggal_selesai').addClass('is-invalid');
                    $('#tanggal_selesai').next('.invalid-feedback').text(
                        'Tanggal selesai harus setelah tanggal mulai.');
                } else {
                    $('#tanggal_selesai').removeClass('is-invalid');
                }
            });

            // Reset form when modal is closed
            $('#addGroupModal').on('hidden.bs.modal', function() {
                $('#addGroupForm')[0].reset();
                $('#addGroupForm .is-invalid').removeClass('is-invalid');
                $('.member-checkbox').prop('checked', false);
                $('#selectAllMembers').prop('checked', false);
                $('#filterProdi').val('');
                $('#searchNim').val('');
                $('.member-row').show();
                updateSelectedCounter();
            });

            // Initialize selected counter
            updateSelectedCounter();
        });
    </script>
    <script>
        (function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(a => {
                setTimeout(() => {
                    try {
                        const bsAlert = bootstrap?.Alert?.getInstance(a) ?? new bootstrap.Alert(a);
                        bsAlert.close();
                    } catch (e) {
                        a.classList.remove('show');
                        a.style.display = 'none';
                    }
                }, 4000);
            });
        })();
    </script>
@endsection
