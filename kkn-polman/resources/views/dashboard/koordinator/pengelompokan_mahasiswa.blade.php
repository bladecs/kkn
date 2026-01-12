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

        /* Styling untuk kloter cards */
        .kloter-container {
            margin-bottom: 30px;
        }

        .kloter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .kloter-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .kloter-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .kloter-card.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, var(--primary-light), #f8f9fa);
            box-shadow: 0 5px 15px rgba(30, 79, 190, 0.15);
        }

        .kloter-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-color);
        }

        .kloter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .kloter-title {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 1.2rem;
            margin: 0;
        }

        .kloter-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .kloter-dates {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--light-color);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .kloter-date-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .kloter-date-label {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin-bottom: 4px;
        }

        .kloter-date-value {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .kloter-separator {
            margin: 0 10px;
            color: var(--secondary-color);
            font-weight: bold;
        }

        .kloter-duration {
            text-align: center;
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .kloter-duration i {
            margin-right: 5px;
        }

        .date-range-container {
            background: var(--light-color);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
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

        /* Date info styling */
        .date-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }

        .date-info i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        /* Schema date warning */
        .schema-date-range {
            background: linear-gradient(135deg, #f0f9ff, #e6f7ff);
            border: 1px solid #b3e0ff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .schema-date-range i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .schema-date-content h5 {
            color: var(--dark-color);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .schema-date-content p {
            color: #4a5568;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        /* Tambahkan di bagian style CSS */
        .current-members-container {
            min-height: 60px;
        }

        .current-members-container .badge {
            font-size: 0.85rem;
            padding: 8px 12px;
            margin: 5px;
        }

        .current-members-container .btn-close {
            font-size: 0.7rem;
            opacity: 0.8;
        }

        .current-members-container .btn-close:hover {
            opacity: 1;
        }

        /* Loading state */
        .loading-state {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }

        .loading-state i {
            font-size: 2rem;
            margin-bottom: 10px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
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

            .filters-section {
                flex-direction: column;
                height: auto;
                gap: 15px;
            }

            .btn-wrapper {
                width: 100%;
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
                                <div class="group-location">{{ $group->project->lokasi->nama_lokasi }}</div>
                            </div>
                            <div class="group-body">
                                <div class="group-info">
                                    <div class="info-item">
                                        <span class="info-label">Dosen Pembimbing</span>
                                        <span class="info-value">{{ $group->project->pengajuDosen->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Jumlah Anggota</span>
                                        <span class="info-value">{{ $group->jumlah_anggota }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Periode</span>
                                        <span
                                            class="info-value">{{ \Carbon\Carbon::parse($group->tgl_mulai)->format('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($group->tgl_selesai)->format('d M Y') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Status</span>
                                        @if ($group->kelompok->status == 'pending')
                                            <span class="info-value" style="color: #a77b28;">Menunggu</span>
                                        @elseif ($group->kelompok->status == 'active')
                                            <span class="info-value" style="color: #28a745;">Aktif</span>
                                        @elseif ($group->kelompok->status == 'completed')
                                            <span class="info-value" style="color: #6c757d;">Selesai</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="members-list">
                                    <div class="members-title">Anggota Kelompok</div>
                                    @if ($group->kelompok->anggotaKelompok->count() > 0)
                                        @foreach ($group->kelompok->anggotaKelompok as $member)
                                            <div class="member-item">
                                                <img src="https://via.placeholder.com/40" class="member-avatar">

                                                <div class="member-details">
                                                    <div class="member-name">{{ $member->mahasiswa->name }}
                                                        {{ $member->is_ketua ? '(Ketua)' : '' }}</div>
                                                    <div class="member-faculty">{{ $member->mahasiswa->prodi->nama_prodi }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">Tidak ada anggota dalam kelompok ini.</p>
                                    @endif
                                </div>

                            </div>
                            <div class="group-actions">
                                <button class="btn btn-group edit-group-btn"
                                    data-group-id="{{ $group->kelompok->id_kelompok }}"
                                    data-detail-id="{{ $group->id_detail_kelompok }}"
                                    data-nama="{{ $group->nama_kelompok }}" data-nip="{{ $group->kelompok->pembimbing }}"
                                    data-project="{{ $group->project_id }}" data-tanggal-mulai="{{ $group->tgl_mulai }}"
                                    data-tanggal-selesai="{{ $group->tgl_selesai }}"
                                    data-status="{{ $group->kelompok->status }}">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="grid-center">Tidak ada data pengelompokan mahasiswa tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelompok -->
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
                        @if ($schema)
                            <!-- Schema Date Range Info -->
                            <div class="schema-date-range">
                                <i class="fas fa-calendar-check"></i>
                                <div class="schema-date-content">
                                    <h5>Periode Schema Aktif</h5>
                                    <p>
                                        <strong>{{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}</strong>
                                        sampai
                                        <strong>{{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}</strong>
                                    </p>
                                    <small class="text-muted">Tanggal kelompok harus berada dalam periode ini.</small>
                                </div>
                            </div>
                        @endif

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
                                            <option value="{{ $projectItem->id_project }}">{{ $projectItem->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Kloter yang Tersedia -->
                        @if ($schema)
                            <div class="kloter-container">
                                <p class="text-muted mb-3">Kloter yang sudah aktif saat ini:</p>
                                <div class="kloter-grid">
                                    <div class="kloter-card" data-schedule-id="{{ $schema->schedule_id }}"
                                        data-tgl-mulai="{{ $schema->tgl_mulai }}"
                                        data-tgl-selesai="{{ $schema->tgl_selesai }}"
                                        data-kloter="{{ $schema->kloter }}">
                                        <div class="kloter-header">
                                            <h4 class="kloter-title">Kloter {{ $schema->kloter }}</h4>
                                            <span class="kloter-badge">
                                                <i class="fas fa-clock me-1"></i>Aktif
                                            </span>
                                        </div>
                                        <div class="kloter-dates">
                                            <div class="kloter-date-item">
                                                <span class="kloter-date-label">Mulai</span>
                                                <span class="kloter-date-value">
                                                    {{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}
                                                </span>
                                            </div>
                                            <div class="kloter-separator">
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                            <div class="kloter-date-item">
                                                <span class="kloter-date-label">Selesai</span>
                                                <span class="kloter-date-value">
                                                    {{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="kloter-duration">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ \Carbon\Carbon::parse($schema->tgl_mulai)->startOfDay()->diffInDays(\Carbon\Carbon::parse($schema->tgl_selesai)->startOfDay()) + 1 }}
                                            hari
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning alert-custom">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                                    <div>
                                        <h5 class="mb-1">Tidak Ada Schema Pengelompokan</h5>
                                        <p class="mb-0">Silakan buat schema pengelompokan terlebih dahulu.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                        @if ($schema) min="{{ $schema->tgl_mulai }}"
                                        max="{{ $schema->tgl_selesai }}"
                                        data-schema-start="{{ $schema->tgl_mulai }}"
                                        data-schema-end="{{ $schema->tgl_selesai }}" @endif
                                        required>
                                    @if ($schema)
                                        <div class="date-info">
                                            <i class="fas fa-info-circle"></i>
                                            Tanggal mulai harus antara
                                            {{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}
                                            dan {{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}
                                        </div>
                                    @endif
                                    <div class="invalid-feedback" id="tanggal_mulai_error">Harap pilih tanggal mulai yang
                                        valid.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai" class="form-label">
                                        <i class="fas fa-calendar-check"></i> Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_selesai"
                                        name="tanggal_selesai"
                                        @if ($schema) min="{{ $schema->tgl_mulai }}"
                                        max="{{ $schema->tgl_selesai }}"
                                        data-schema-start="{{ $schema->tgl_mulai }}"
                                        data-schema-end="{{ $schema->tgl_selesai }}" @endif
                                        required>
                                    @if ($schema)
                                        <div class="date-info">
                                            <i class="fas fa-info-circle"></i>
                                            Tanggal selesai harus antara
                                            {{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}
                                            dan {{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}
                                        </div>
                                    @endif
                                    <div class="invalid-feedback" id="tanggal_selesai_error">Harap pilih tanggal selesai
                                        yang valid.</div>
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
                                            @foreach ($prodi as $prd)
                                                <option value="{{ $prd->id_prodi }}">{{ $prd->nama_prodi }}</option>
                                            @endforeach
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
                                                $availableStudents = $mahasiswa
                                                    ->filter(function ($m) {
                                                        $ak = $m->anggotaKelompok;
                                                        if (is_null($ak)) {
                                                            return true;
                                                        }
                                                        if ($ak instanceof \Illuminate\Support\Collection) {
                                                            return $ak
                                                                ->whereNotIn('kelompok_id', [null, '-'])
                                                                ->isEmpty();
                                                        }
                                                        return in_array($ak->kelompok_id ?? null, [null, '-']);
                                                    })
                                                    ->values();
                                            @endphp

                                            @if ($availableStudents->count() > 0)
                                                @foreach ($availableStudents as $mhs)
                                                    <tr class="member-row" data-prodi="{{ $mhs->prodi->id_prodi }}"
                                                        data-nim="{{ $mhs->nim }}" data-nama="{{ $mhs->name }}">
                                                        <td class="text-center">
                                                            <input type="checkbox" name="anggota[]"
                                                                value="{{ $mhs->nim }}"
                                                                class="form-check-input member-checkbox">
                                                        </td>
                                                        <td>{{ $mhs->nim }}</td>
                                                        <td>{{ $mhs->name }}</td>
                                                        <td>{{ $mhs->prodi->nama_prodi }}</td>
                                                        <td>
                                                            {{ $mhs->jurusan->nama_jurusan }}
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

    <!-- Modal Edit Kelompok -->
    <div class="modal fade modal-enhanced" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGroupModalLabel">
                        <i class="fas fa-edit"></i> Edit Kelompok KKN
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update-pengelompokan') }}" method="POST" id="editGroupForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_kelompok" name="id_kelompok">
                    <input type="hidden" id="edit_id_detail_kelompok" name="id_detail_kelompok">

                    <div class="modal-body">
                        @if ($schema)
                            <!-- Schema Date Range Info -->
                            <div class="schema-date-range">
                                <i class="fas fa-calendar-check"></i>
                                <div class="schema-date-content">
                                    <h5>Periode Schema Aktif</h5>
                                    <p>
                                        <strong>{{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}</strong>
                                        sampai
                                        <strong>{{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}</strong>
                                    </p>
                                    <small class="text-muted">Tanggal kelompok harus berada dalam periode ini.</small>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nama_kelompok" class="form-label">
                                        <i class="fas fa-tag"></i> Nama Kelompok
                                    </label>
                                    <input type="text" class="form-control" id="edit_nama_kelompok"
                                        name="nama_kelompok" placeholder="Masukkan nama kelompok" required>
                                    <div class="invalid-feedback">Harap masukkan nama kelompok.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_id_dosen" class="form-label">
                                        <i class="fas fa-user-tie"></i> Dosen Pembimbing
                                    </label>
                                    <select class="form-select" id="edit_id_dosen" name="nip" required>
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
                                    <label for="edit_id_project" class="form-label">
                                        <i class="fas fa-project-diagram"></i> Project KKN
                                    </label>
                                    <select class="form-select" id="edit_id_project" name="id_project">
                                        <option value="" disabled selected>Pilih Project (Opsional)</option>
                                        @foreach ($project as $projectItem)
                                            <option value="{{ $projectItem->id_project }}">{{ $projectItem->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_status" class="form-label">
                                        <i class="fas fa-info-circle"></i> Status Kelompok
                                    </label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="pending">Menunggu</option>
                                        <option value="active">Aktif</option>
                                        <option value="completed">Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_tanggal_mulai" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control" id="edit_tanggal_mulai"
                                        name="tanggal_mulai"
                                        @if ($schema) min="{{ $schema->tgl_mulai }}" max="{{ $schema->tgl_selesai }}" @endif
                                        required>
                                    @if ($schema)
                                        <div class="date-info">
                                            <i class="fas fa-info-circle"></i>
                                            Tanggal mulai harus antara
                                            {{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}
                                            dan {{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}
                                        </div>
                                    @endif
                                    <div class="invalid-feedback" id="edit_tanggal_mulai_error">Harap pilih tanggal mulai
                                        yang valid.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_tanggal_selesai" class="form-label">
                                        <i class="fas fa-calendar-check"></i> Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control" id="edit_tanggal_selesai"
                                        name="tanggal_selesai"
                                        @if ($schema) min="{{ $schema->tgl_mulai }}"
                                    max="{{ $schema->tgl_selesai }}" @endif
                                        required>
                                    @if ($schema)
                                        <div class="date-info">
                                            <i class="fas fa-info-circle"></i>
                                            Tanggal selesai harus antara
                                            {{ \Carbon\Carbon::parse($schema->tgl_mulai)->format('d M Y') }}
                                            dan {{ \Carbon\Carbon::parse($schema->tgl_selesai)->format('d M Y') }}
                                        </div>
                                    @endif
                                    <div class="invalid-feedback" id="edit_tanggal_selesai_error">Harap pilih tanggal
                                        selesai yang valid.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Members Section -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-users"></i> Anggota Saat Ini
                            </label>
                            <div class="current-members-container p-3 bg-light rounded">
                                <div id="currentMembersList" class="d-flex flex-wrap gap-2">
                                    <!-- Current members will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <!-- Member Selection Section -->
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">
                                    <i class="fas fa-user-plus"></i> Tambah/Edit Anggota Kelompok
                                </label>
                                <div class="selected-counter">
                                    <i class="fas fa-users"></i>
                                    <span id="editSelectedCount">0</span> Mahasiswa Terpilih
                                </div>
                            </div>

                            <!-- Member Filters -->
                            <div class="member-filters">
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="editFilterProdi">Program Studi</label>
                                        <select class="form-select" id="editFilterProdi">
                                            <option value="">Semua Program Studi</option>
                                            @foreach ($prodi as $prd)
                                                <option value="{{ $prd->id_prodi }}">{{ $prd->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="editSearchNim">Cari NIM atau Nama</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="editSearchNim"
                                                placeholder="Masukkan NIM atau nama...">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="filter-actions">
                                        <button type="button" class="btn btn-outline-secondary btn-filter"
                                            id="editApplyFilters">
                                            <i class="fas fa-filter me-1"></i> Filter
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-filter"
                                            id="editResetFilters">
                                            <i class="fas fa-redo me-1"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Members Table -->
                            <div class="members-selection">
                                <div class="table-header">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editSelectAllMembers">
                                        <label class="form-check-label fw-bold" for="editSelectAllMembers">
                                            Pilih Mahasiswa
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
                                        <tbody id="editMembersTableBody">
                                            <!-- Members will be loaded dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Centang mahasiswa yang akan ditambahkan atau
                                    dipertahankan dalam kelompok.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deleteGroupBtn">
                            <i class="fas fa-trash me-1"></i> Hapus Kelompok
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="updateGroupBtn">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteConfirmationModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kelompok ini?</p>
                    <p class="text-danger"><strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan dan akan
                        menghapus semua data terkait.</p>
                    <input type="hidden" id="delete_kelompok_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Data schema dari PHP untuk validasi di JavaScript
        const SCHEMA_DATES = {
            start: '{{ $schema->tgl_mulai ?? null }}',
            end: '{{ $schema->tgl_selesai ?? null }}'
        };
    </script>

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

            // Format date to YYYY-MM-DD for comparison
            function formatDate(dateStr) {
                if (!dateStr) return null;
                const date = new Date(dateStr);
                return date.toISOString().split('T')[0];
            }

            // Validation for date range based on schema
            function validateDateRange(startDate, endDate) {
                // If schema dates are not available, skip validation
                if (!SCHEMA_DATES.start || !SCHEMA_DATES.end) {
                    return true;
                }

                const schemaStart = formatDate(SCHEMA_DATES.start);
                const schemaEnd = formatDate(SCHEMA_DATES.end);

                // Convert input dates to Date objects for comparison
                const inputStart = new Date(startDate);
                const inputEnd = new Date(endDate);
                const schemaStartDate = new Date(schemaStart);
                const schemaEndDate = new Date(schemaEnd);

                // Reset validation states
                $('#tanggal_mulai').removeClass('is-invalid');
                $('#tanggal_mulai_error').text('Harap pilih tanggal mulai yang valid.');
                $('#tanggal_selesai').removeClass('is-invalid');
                $('#tanggal_selesai_error').text('Harap pilih tanggal selesai yang valid.');

                let isValid = true;

                // Validate start date against schema
                if (inputStart < schemaStartDate) {
                    $('#tanggal_mulai').addClass('is-invalid');
                    $('#tanggal_mulai_error').text(
                        `Tanggal mulai tidak boleh kurang dari ${new Date(schemaStart).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`
                    );
                    isValid = false;
                }

                if (inputStart > schemaEndDate) {
                    $('#tanggal_mulai').addClass('is-invalid');
                    $('#tanggal_mulai_error').text(
                        `Tanggal mulai tidak boleh lebih dari ${new Date(schemaEnd).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`
                    );
                    isValid = false;
                }

                // Validate end date against schema
                if (inputEnd < schemaStartDate) {
                    $('#tanggal_selesai').addClass('is-invalid');
                    $('#tanggal_selesai_error').text(
                        `Tanggal selesai tidak boleh kurang dari ${new Date(schemaStart).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`
                    );
                    isValid = false;
                }

                if (inputEnd > schemaEndDate) {
                    $('#tanggal_selesai').addClass('is-invalid');
                    $('#tanggal_selesai_error').text(
                        `Tanggal selesai tidak boleh lebih dari ${new Date(schemaEnd).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`
                    );
                    isValid = false;
                }

                // Validate that end date is not before start date
                if (inputStart > inputEnd) {
                    $('#tanggal_selesai').addClass('is-invalid');
                    $('#tanggal_selesai_error').text(
                        'Tanggal selesai harus setelah tanggal mulai'
                    );
                    isValid = false;
                }

                return isValid;
            }

            // Real-time validation for date inputs
            $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
                const startDate = $('#tanggal_mulai').val();
                const endDate = $('#tanggal_selesai').val();

                if (startDate && endDate) {
                    validateDateRange(startDate, endDate);
                }
            });

            // Set min and max date for date inputs based on schema
            function setDateLimits() {
                if (SCHEMA_DATES.start && SCHEMA_DATES.end) {
                    const schemaStart = new Date(SCHEMA_DATES.start);
                    const schemaEnd = new Date(SCHEMA_DATES.end);

                    // Format dates to YYYY-MM-DD for input min/max attributes
                    const minDate = schemaStart.toISOString().split('T')[0];
                    const maxDate = schemaEnd.toISOString().split('T')[0];

                    $('#tanggal_mulai').attr({
                        'min': minDate,
                        'max': maxDate
                    });

                    $('#tanggal_selesai').attr({
                        'min': minDate,
                        'max': maxDate
                    });

                    // Set initial values to schema dates
                    $('#tanggal_mulai').val(minDate);
                    $('#tanggal_selesai').val(maxDate);
                }
            }

            // Initialize date limits
            setDateLimits();

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

                // Validate date range against schema
                const startDate = $('#tanggal_mulai').val();
                const endDate = $('#tanggal_selesai').val();

                if (startDate && endDate) {
                    if (!validateDateRange(startDate, endDate)) {
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('.is-invalid').first().focus();
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
                setDateLimits(); // Reset date limits
                updateSelectedCounter();
            });

            // Show modal event
            $('#addGroupModal').on('show.bs.modal', function() {
                setDateLimits();
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

    <script>
        $(document).on('click', '.edit-group-btn', function() {
            const groupId = $(this).data('group-id');
            const detailId = $(this).data('detail-id');
            const nama = $(this).data('nama');
            const nip = $(this).data('nip');
            const project = $(this).data('project');
            const tanggalMulai = $(this).data('tanggal-mulai');
            const tanggalSelesai = $(this).data('tanggal-selesai');
            const status = $(this).data('status');

            console.log('Editing group:', {
                groupId,
                detailId,
                nama,
                nip,
                project,
                tanggalMulai,
                tanggalSelesai,
                status
            });

            // Set form values
            $('#edit_id_kelompok').val(groupId);
            $('#edit_id_detail_kelompok').val(detailId);
            $('#edit_nama_kelompok').val(nama);
            $('#edit_id_dosen').val(nip);
            $('#edit_id_project').val(project);
            $('#edit_tanggal_mulai').val(formatDateForInput(tanggalMulai));
            $('#edit_tanggal_selesai').val(formatDateForInput(tanggalSelesai));
            $('#edit_status').val(status);

            // Load current members
            loadCurrentMembers(groupId);

            // Load available students
            loadAvailableStudents(groupId);

            // Show modal
            $('#editGroupModal').modal('show');
        });

        function formatDateForInput(dateValue) {
            if (!dateValue) return '';

            // Jika sudah string dengan format YYYY-MM-DD, langsung return
            if (typeof dateValue === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(dateValue)) {
                return dateValue;
            }

            // Coba konversi ke Date object
            const date = new Date(dateValue);

            // Cek apakah valid
            if (isNaN(date.getTime())) {
                console.error('Invalid date:', dateValue);
                return '';
            }

            // Format ke YYYY-MM-DD
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        // Load current members
        function loadCurrentMembers(groupId) {
            $.ajax({
                url: `/get-kelompok/${groupId}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const anggota = response.data.anggota;
                        const currentMembersHtml = anggota.map(member => `
                    <span class="badge bg-primary d-flex align-items-center gap-2">
                        ${member.name} (${member.nim})
                        <button type="button" class="btn-close btn-close-white" data-nim="${member.nim}"></button>
                    </span>
                `).join('');

                        $('#currentMembersList').html(currentMembersHtml);
                    }
                },
                error: function() {
                    $('#currentMembersList').html('<div class="text-danger">Gagal memuat data anggota</div>');
                }
            });
        }

        // Load available students for edit modal
        function loadAvailableStudents(excludeGroupId) {
            $.ajax({
                url: '/api/available-students',
                type: 'GET',
                data: {
                    exclude_group: excludeGroupId
                },
                success: function(response) {
                    const tableBody = $('#editMembersTableBody');
                    tableBody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(student => {
                            const row = `
                        <tr class="member-row" data-prodi="${student.prodi_id}" 
                            data-nim="${student.nim}" data-nama="${student.name}">
                            <td class="text-center">
                                <input type="checkbox" name="anggota[]" value="${student.nim}"
                                    class="form-check-input edit-member-checkbox">
                            </td>
                            <td>${student.nim}</td>
                            <td>${student.name}</td>
                            <td>${student.prodi?.nama_prodi || '-'}</td>
                            <td>${student.jurusan?.nama_jurusan || '-'}</td>
                            <td>
                                <span class="badge bg-success">Tersedia</span>
                            </td>
                        </tr>
                    `;
                            tableBody.append(row);
                        });
                    } else {
                        tableBody.html(`
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <p>Tidak ada mahasiswa yang tersedia</p>
                            </div>
                        </td>
                    </tr>
                `);
                    }

                    // Initialize filter for edit modal
                    initEditFilters();
                },
                error: function() {
                    $('#editMembersTableBody').html(`
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        Gagal memuat data mahasiswa
                    </td>
                </tr>
            `);
                }
            });
        }

        // Initialize filters for edit modal
        function initEditFilters() {
            // Filter functionality for edit modal
            $('#editFilterProdi').on('change', function() {
                filterEditMembers();
            });

            $('#editSearchNim').on('input', function() {
                filterEditMembers();
            });

            $('#editApplyFilters').on('click', function() {
                filterEditMembers();
            });

            $('#editResetFilters').on('click', function() {
                $('#editFilterProdi').val('');
                $('#editSearchNim').val('');
                filterEditMembers();
            });

            // Select all for edit modal
            $('#editSelectAllMembers').on('change', function() {
                $('.edit-member-checkbox:visible').prop('checked', $(this).prop('checked'));
                updateEditSelectedCounter();
            });

            // Individual checkbox for edit modal
            $(document).on('change', '.edit-member-checkbox', function() {
                updateEditSelectedCounter();
            });

            updateEditSelectedCounter();
        }

        // Filter members for edit modal
        function filterEditMembers() {
            const selectedProdi = $('#editFilterProdi').val() || '';
            const searchTerm = $('#editSearchNim').val() || '';

            $('.member-row').each(function() {
                const $row = $(this);
                const prodi = ($row.data('prodi') || '').toString();
                const nim = ($row.data('nim') || '').toString().toLowerCase();
                const nama = ($row.data('nama') || '').toString().toLowerCase();

                const prodiMatch = !selectedProdi || prodi === selectedProdi;
                const searchMatch = !searchTerm ||
                    nim.includes(searchTerm.toLowerCase()) ||
                    nama.includes(searchTerm.toLowerCase());

                if (prodiMatch && searchMatch) {
                    $row.show();
                } else {
                    $row.hide();
                }
            });

            updateEditSelectedCounter();
        }

        // Update selected counter for edit modal
        function updateEditSelectedCounter() {
            const selectedCount = $('.edit-member-checkbox:checked').length;
            $('#editSelectedCount').text(selectedCount);
        }

        // Delete group functionality
        $(document).on('click', '#deleteGroupBtn', function() {
            const kelompokId = $('#edit_id_kelompok').val();
            $('#delete_kelompok_id').val(kelompokId);
            $('#deleteConfirmationModal').modal('show');
        });

        $(document).on('click', '#confirmDeleteBtn', function() {
            const kelompokId = $('#delete_kelompok_id').val();

            $.ajax({
                url: '/delete-pengelompokan',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_kelompok: kelompokId
                },
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    $('#editGroupModal').modal('hide');

                    // Show success message and reload page
                    showAlert('success', response.success || 'Kelompok berhasil dihapus');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.error || 'Terjadi kesalahan';
                    showAlert('danger', error);
                }
            });
        });

        // Utility function to show alerts
        function showAlert(type, message) {
            const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

            // Prepend alert to the page
            $('.grouping-container').prepend(alertHtml);

            // Auto remove alert after 5 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }

        // Remove current member
        $(document).on('click', '.current-members-container .btn-close', function(e) {
            e.preventDefault();
            const nim = $(this).data('nim');
            $(this).closest('.badge').remove();

            // Uncheck the corresponding checkbox
            $(`.edit-member-checkbox[value="${nim}"]`).prop('checked', false);
            updateEditSelectedCounter();
        });

        // Validate edit form
        $('#editGroupForm').on('submit', function(e) {
            let isValid = true;

            // Validate required fields
            $('#editGroupForm [required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validate date range
            const startDate = $('#edit_tanggal_mulai').val();
            const endDate = $('#edit_tanggal_selesai').val();

            if (startDate && endDate && !validateDateRange(startDate, endDate)) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                $('.is-invalid').first().focus();
            }
        });

        // Reset edit modal when closed
        $('#editGroupModal').on('hidden.bs.modal', function() {
            $('#editGroupForm')[0].reset();
            $('#editGroupForm .is-invalid').removeClass('is-invalid');
            $('#currentMembersList').empty();
            $('#editMembersTableBody').empty();
            $('#editFilterProdi').val('');
            $('#editSearchNim').val('');
        });
    </script>
@endsection
