@extends('dashboard.koordinator.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
        /* Main Styles */
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
            justify-content: space-between;
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

        /* Quick Actions Styles */
        .quick-actions {
            margin-top: 30px;
        }

        .action-card {
            text-align: center;
            padding: 25px 15px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #eaeaea;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-color);
        }

        .action-icon {
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .action-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .action-desc {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .btn-action {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            background: #1a3ea5;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(30, 79, 190, 0.3);
        }

        /* Status Indicators */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .status-inactive {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }

        /* Table Styles */
        .table-card {
            padding: 20px;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eaeaea;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 12px 15px;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(30, 79, 190, 0.05);
        }

        .schedule-row {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .schedule-row:hover {
            background-color: #f8f9fa !important;
        }

        .schedule-row.active {
            background-color: rgba(30, 79, 190, 0.1) !important;
            border-left: 3px solid var(--primary-color);
        }

        /* Improved Dropdown Styles */
        .schema-dropdown {
            display: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: #f8f9fa;
            border-top: none;
        }

        .schema-dropdown.open {
            display: block;
            max-height: 600px;
            border-top: 1px solid #eaeaea;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .schema-content {
            padding: 0;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .schema-dropdown.open .schema-content {
            opacity: 1;
            transform: translateY(0);
        }

        .schema-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }

        .schema-header-title {
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .schema-header-title i {
            font-size: 1.2rem;
        }

        .schema-count-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .schema-list {
            display: flex;
            flex-direction: row;
            gap: 15px;
            padding: 20px;
            max-height: 400px;
        }

        .schema-item {
            width: 20rem;
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 12px;
            border: 1px solid #eaeaea;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .schema-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .schema-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .schema-item-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1rem;
            flex: 1;
            margin-right: 10px;
        }

        .schema-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .schema-status i {
            font-size: 0.6rem;
            margin-right: 4px;
        }

        .status-aktif {
            background: linear-gradient(135deg, #34d399, #10b981);
            color: white;
        }

        .status-nonaktif {
            background: linear-gradient(135deg, #9ca3af, #6b7280);
            color: white;
        }

        .schema-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 12px;
        }

        .schema-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .schema-meta-item i {
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }

        .schema-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid var(--primary-color);
        }

        .schema-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            border-top: 1px solid #f1f1f1;
            padding-top: 12px;
            margin-top: 12px;
        }

        .btn-schema-action {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-schema-action:hover {
            transform: translateY(-1px);
        }

        .empty-schema-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-schema-state i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-schema-state h5 {
            margin-bottom: 10px;
            color: #495057;
            font-size: 1rem;
        }

        /* Enhanced Loading States */
        .schema-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: white;
            border-radius: 10px;
            margin: 10px;
        }

        .loading-spinner {
            position: relative;
            width: 50px;
            height: 50px;
            margin-bottom: 15px;
        }

        .loading-spinner::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-spinner::after {
            content: '';
            position: absolute;
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            border: 3px solid transparent;
            border-bottom: 3px solid var(--info-color);
            border-radius: 50%;
            animation: spinReverse 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spinReverse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        .loading-text {
            color: #6c757d;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Error State */
        .schema-error {
            text-align: center;
            padding: 30px 20px;
            background: #fff5f5;
            border-radius: 10px;
            margin: 10px;
            border: 1px solid #fed7d7;
        }

        .schema-error i {
            font-size: 2rem;
            color: #f56565;
            margin-bottom: 10px;
        }

        .schema-error p {
            color: #718096;
            margin-bottom: 15px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .empty-state h5 {
            margin-bottom: 10px;
            color: #495057;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-radius: 15px 15px 0 0;
            padding: 20px 30px;
        }

        .modal-body {
            padding: 25px 30px;
        }

        .modal-footer {
            border-radius: 0 0 15px 15px;
            padding: 15px 30px;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), #1a3ea5) !important;
        }

        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.25);
        }

        /* Detail Schema Item */
        .detail-schema-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #eaeaea;
            position: relative;
        }

        .detail-schema-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-schema-title {
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-schema-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .remove-detail-btn {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            padding: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-detail-btn:hover {
            color: #bd2130;
            transform: scale(1.1);
        }

        /* Toast Notification */
        .toast {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Kategori Badge */
        .kategori-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 1.5rem;
            }

            .stat-icon {
                font-size: 2rem;
            }

            .action-card {
                margin-bottom: 15px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .schema-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .schema-meta-grid {
                grid-template-columns: 1fr;
            }

            .schema-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .modal-dialog {
                margin: 10px;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 15px 20px;
            }

            .detail-schema-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="card-title mb-2"><i class="fas fa-graduation-cap me-2"></i> Sistem Informasi KKN</h1>
                            <p class="card-text mb-0">Dashboard Koordinator - Manajemen KKN Terpadu</p>
                        </div>
                        <div class="text-end">
                            <div class="fw-light">Selamat Datang</div>
                            <div class="h5 mb-0">{{ auth()->user()->name ?? 'Koordinator' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Pendaftaran Mahasiswa -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-user-graduate stat-icon" style="color: var(--primary-color);"></i>
                    <div class="stat-number">{{ $count_pendaftaran ?? 0 }}</div>
                    <div class="stat-label">Pendaftaran Mahasiswa</div>
                    <div class="mt-2">
                        <span class="status-indicator status-active">
                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                            Total
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendaftaran Project -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-project-diagram stat-icon" style="color: var(--info-color);"></i>
                    <div class="stat-number">{{ $project_belum_diperiksa ?? 0 }}</div>
                    <div class="stat-label">Pendaftaran Project</div>
                    <div class="mt-2">
                        <span class="status-indicator status-pending">
                            <i class="fas fa-clock me-1" style="font-size: 6px;"></i>
                            Perlu Verifikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendaftaran Proposal -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-file-alt stat-icon" style="color: var(--warning-color);"></i>
                    <div class="stat-number">{{ $count_not_verif ?? 0 }}</div>
                    <div class="stat-label">Pendaftaran Proposal</div>
                    <div class="mt-2">
                        <span class="status-indicator status-pending">
                            <i class="fas fa-clock me-1" style="font-size: 6px;"></i>
                            Menunggu Review
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Schedule -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-calendar-alt stat-icon" style="color: var(--success-color);"></i>
                    <div class="stat-number">{{ $jumlah_schedule ?? 0 }}</div>
                    <div class="stat-label">Jumlah Schedule</div>
                    <div class="mt-2">
                        <span class="status-indicator status-active">
                            <i class="fas fa-check-circle me-1" style="font-size: 6px;"></i>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Row -->
    <div class="row mb-4">
        <!-- Jumlah Schema -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-layer-group stat-icon" style="color: #6f42c1;"></i>
                    <div class="stat-number">{{ $jumlah_schema ?? 0 }}</div>
                    <div class="stat-label">Jumlah Schema</div>
                    <div class="mt-2">
                        <span class="status-indicator status-active">
                            <i class="fas fa-check-circle me-1" style="font-size: 6px;"></i>
                            Terkonfigurasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Terverifikasi -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-user-check stat-icon" style="color: #20c997;"></i>
                    <div class="stat-number">{{ $daily_pendaftaran ?? 0 }}</div>
                    <div class="stat-label">Mahasiswa Terverifikasi</div>
                    <div class="mt-2">
                        <span class="status-indicator status-active">
                            <i class="fas fa-check-circle me-1" style="font-size: 6px;"></i>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Selesai -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-check-double stat-icon" style="color: #28a745;"></i>
                    <div class="stat-number">{{ $project_selesai ?? 0 }}</div>
                    <div class="stat-label">Project Selesai</div>
                    <div class="mt-2">
                        <span class="status-indicator status-active">
                            <i class="fas fa-check-circle me-1" style="font-size: 6px;"></i>
                            Completed
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Table Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card table-card">
                <div class="section-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt section-icon"></i>
                        <h5 class="section-title">Daftar Schedule</h5>
                    </div>
                    <a href="{{ route('form_schedule') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Schedule
                    </a>
                </div>

                @if ($schedules && count($schedules) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Schedule</th>
                                    <th>Periode</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Jumlah Schema</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $index => $schedule)
                                    <tr class="schedule-row" data-schedule-id="{{ $schedule->id_schedule }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $schedule->deskripsi ?? 'N/A' }}</strong>
                                        </td>
                                        <td>{{ $schedule->kloter ?? 'N/A' }}</td>
                                        <td>{{ $schedule->tgl_mulai ? \Carbon\Carbon::parse($schedule->tgl_mulai)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td>{{ $schedule->tgl_selesai ? \Carbon\Carbon::parse($schedule->tgl_selesai)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($schedule->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($schedule->status == 'nonaktif')
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @else
                                                <span class="badge bg-warning">{{ $schedule->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $schedule->schemas_count ?? 0 }} Schema
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-primary toggle-schema-btn"
                                                    data-schedule-id="{{ $schedule->schedule_id }}"
                                                    data-expanded="false">
                                                    <i class="fas fa-chevron-down me-1"></i> Lihat Schema
                                                </button>
                                                <button class="btn btn-outline-warning edit-schedule-btn"
                                                    data-schedule-id="{{ $schedule->schedule_id }}"
                                                    data-schedule-data='@json($schedule)'>
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger delete-schedule-btn"
                                                    data-schedule-id="{{ $schedule->schedule_id }}"
                                                    data-schedule-name="{{ $schedule->deskripsi }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Dropdown row - empty initially -->
                                    <tr id="schema-dropdown-{{ $schedule->schedule_id }}" class="schema-dropdown">
                                        <td colspan="8">
                                            <!-- Content will be loaded via AJAX -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h5>Belum ada Schedule</h5>
                        <p>Mulai dengan membuat schedule baru untuk KKN.</p>
                        <a href="{{ route('form_schedule') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Buat Schedule Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-bolt section-icon"></i>
                        <h5 class="section-title">Aksi Cepat</h5>
                    </div>
                    <div class="row quick-actions">
                        <div class="col-md-3 col-sm-6">
                            <div class="action-card">
                                <i class="fas fa-plus-circle action-icon"></i>
                                <div class="action-title">Buat Schedule</div>
                                <p class="action-desc">Buat jadwal KKN baru untuk periode berikutnya</p>
                                <a href="{{ route('form_schedule') }}" class="btn btn-action">
                                    <i class="fas fa-plus me-1"></i> Buat
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="action-card">
                                <i class="fas fa-project-diagram action-icon"></i>
                                <div class="action-title">Kelola Schema</div>
                                <p class="action-desc">Atur schema dan kategori kegiatan KKN</p>
                                <a href="{{ route('form_schema') }}" class="btn btn-action">
                                    <i class="fas fa-cog me-1"></i> Kelola
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="action-card">
                                <i class="fas fa-users action-icon"></i>
                                <div class="action-title">Verifikasi Mahasiswa</div>
                                <p class="action-desc">Verifikasi pendaftaran mahasiswa KKN</p>
                                <a href="{{ route('pendaftaran-kkn') }}" class="btn btn-action">
                                    <i class="fas fa-check me-1"></i> Verifikasi
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="action-card">
                                <i class="fas fa-tasks action-icon"></i>
                                <div class="action-title">Review Project</div>
                                <p class="action-desc">Periksa dan review project mahasiswa</p>
                                <a href="{{ route('pendaftaran-project') }}" class="btn btn-action">
                                    <i class="fas fa-search me-1"></i> Review
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Schedule -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editScheduleModalLabel">
                        <i class="fas fa-edit me-2"></i> Edit Schedule
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editScheduleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_kloter" class="form-label">
                                        <i class="fas fa-tag me-1 text-primary"></i> Periode / Kloter
                                    </label>
                                    <input type="text" class="form-control" id="edit_kloter" name="kloter" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_tgl_mulai" class="form-label">
                                        <i class="fas fa-calendar-day me-1 text-primary"></i> Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control" id="edit_tgl_mulai" name="tgl_mulai"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_tgl_selesai" class="form-label">
                                        <i class="fas fa-calendar-check me-1 text-primary"></i> Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control" id="edit_tgl_selesai" name="tgl_selesai"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">
                                <i class="fas fa-heading me-1 text-primary"></i> Deskripsi Schedule
                            </label>
                            <textarea type="text" class="form-control" id="edit_deskripsi" name="deskripsi" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Schema -->
    <div class="modal fade" id="editSchemaModal" tabindex="-1" aria-labelledby="editSchemaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="editSchemaModalLabel">
                        <i class="fas fa-layer-group me-2"></i> Edit Schema
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editSchemaForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Header Info -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-lg me-3"></i>
                                <div>
                                    <h6 class="mb-1">Informasi Schema</h6>
                                    <p class="mb-0" id="schemaInfo">Schedule: <span id="scheduleName"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Schema Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-list-alt me-2 text-primary"></i> Detail Schema
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="detailSchemaContainer">
                                    <!-- Detail schema akan ditambahkan secara dinamis di sini -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirm Delete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5 class="mb-2">Apakah Anda yakin?</h5>
                        <p class="text-muted" id="deleteConfirmationText">Data yang dihapus tidak dapat dikembalikan.</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash-alt me-1"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
                }, 5000);
            });
        })();

        // Add animation to stat cards
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate__animated', 'animate__fadeInUp');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Object to store loaded schemas data
            const loadedSchemas = {};
            let isFetching = false;

            // Modal instances
            const editScheduleModal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
            const editSchemaModal = new bootstrap.Modal(document.getElementById('editSchemaModal'));
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

            let currentScheduleId = null;
            let currentSchemaId = null;
            let deleteType = null; // 'schedule' or 'schema'

            // Toggle schema dropdown
            document.querySelectorAll('.toggle-schema-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();

                    if (isFetching) return; // Prevent multiple clicks

                    const scheduleId = this.dataset.scheduleId;
                    const dropdown = document.getElementById(`schema-dropdown-${scheduleId}`);
                    const row = this.closest('.schedule-row');
                    const isExpanded = this.dataset.expanded === 'true';

                    // Toggle active class on row
                    row.classList.toggle('active');

                    if (!isExpanded) {
                        // Expand dropdown
                        this.dataset.expanded = 'true';
                        this.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Tutup Schema';
                        this.classList.add('btn-primary');
                        this.classList.remove('btn-outline-primary');

                        // Show dropdown with content
                        dropdown.classList.add('open');

                        // Check if schemas already loaded
                        if (loadedSchemas[scheduleId]) {
                            renderSchemas(loadedSchemas[scheduleId], dropdown, scheduleId);
                        } else {
                            // Show loading state
                            dropdown.innerHTML = createLoadingTemplate();

                            // Fetch schemas via AJAX
                            isFetching = true;
                            fetchSchemas(scheduleId, dropdown);
                        }
                    } else {
                        // Close dropdown
                        this.dataset.expanded = 'false';
                        this.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Lihat Schema';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-outline-primary');
                        dropdown.classList.remove('open');
                    }
                });
            });

            // Create loading template
            function createLoadingTemplate() {
                return `
                    <div class="schema-content">
                        <div class="schema-loading">
                            <div class="loading-spinner"></div>
                            <div class="loading-text">Memuat data schema...</div>
                        </div>
                    </div>
                `;
            }

            // Create empty state template
            function createEmptyTemplate(scheduleId) {
                return `
                    <div class="schema-content">
                        <div class="schema-header">
                            <div class="schema-header-title">
                                <i class="fas fa-layer-group"></i>
                                Daftar Schema
                                <span class="schema-count-badge">0 Schema</span>
                            </div>
                        </div>
                        <div class="empty-schema-state">
                            <i class="fas fa-inbox"></i>
                            <h5>Belum ada Schema</h5>
                            <p>Schedule ini belum memiliki schema.</p>
                            <a href="/dashboard/koordinator/schema/create?schedule=${scheduleId}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Schema
                            </a>
                        </div>
                    </div>
                `;
            }

            // Create error template
            function createErrorTemplate() {
                return `
                    <div class="schema-content">
                        <div class="schema-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h5>Gagal Memuat Data</h5>
                            <p>Terjadi kesalahan saat mengambil data schema.</p>
                            <button class="btn btn-sm btn-outline-danger retry-btn">
                                <i class="fas fa-redo me-1"></i> Coba Lagi
                            </button>
                        </div>
                    </div>
                `;
            }

            // Function to fetch schemas via AJAX
            function fetchSchemas(scheduleId, dropdownElement) {
                const urlTemplate = "{{ route('schedule.schemas', ['id' => 'REPLACE_ID']) }}";
                const url = urlTemplate.replace('REPLACE_ID', scheduleId);

                fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        cache: 'no-cache'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        isFetching = false;

                        if (data.success && data.schemas && data.schemas.length > 0) {
                            // Store loaded schemas
                            loadedSchemas[scheduleId] = data.schemas;
                            renderSchemas(data.schemas, dropdownElement, scheduleId);
                        } else {
                            dropdownElement.innerHTML = createEmptyTemplate(scheduleId);
                        }
                    })
                    .catch(error => {
                        isFetching = false;
                        console.error('Error fetching schemas:', error);
                        dropdownElement.innerHTML = createErrorTemplate();

                        // Add retry functionality
                        setTimeout(() => {
                            const retryBtn = dropdownElement.querySelector('.retry-btn');
                            if (retryBtn) {
                                retryBtn.addEventListener('click', function() {
                                    dropdownElement.innerHTML = createLoadingTemplate();
                                    fetchSchemas(scheduleId, dropdownElement);
                                });
                            }
                        }, 100);
                    });
            }

            // Function to render schemas
            function renderSchemas(schemas, dropdownElement, scheduleId) {
                // 1. Urutkan schemas berdasarkan id_kategori dari detail_schemas
                const sortedSchemas = [...schemas].sort((a, b) => {
                    // Ambil id_kategori dari detail pertama (asumsi setiap schema punya minimal 1 detail)
                    const kategoriA = a.detail_schemas && a.detail_schemas.length > 0 ?
                        a.detail_schemas[0].kategori_id :
                        'SCH_999'; // Default jika tidak ada
                    const kategoriB = b.detail_schemas && b.detail_schemas.length > 0 ?
                        b.detail_schemas[0].kategori_id :
                        'SCH_999';

                    // Urutkan berdasarkan angka di belakang SCH_
                    const numA = parseInt(kategoriA.split('_')[1]);
                    const numB = parseInt(kategoriB.split('_')[1]);

                    return numA - numB;
                });

                let html = `
                    <div class="schema-content">
                        <div class="schema-header">
                            <div class="schema-header-title">
                                <i class="fas fa-layer-group"></i>
                                Daftar Schema
                                <span class="schema-count-badge">${schemas.length} Schema</span>
                            </div>
                        </div>
                        <div class="schema-list">
                `;

                // 2. Tampilkan dalam urutan yang sudah di-sort
                sortedSchemas.forEach((schema, index) => {
                    // Ambil detail pertama jika ada
                    const detail = schema.detail_schemas && schema.detail_schemas.length > 0 ?
                        schema.detail_schemas[0] :
                        null;

                    const statusClass = schema.status === 'aktif' ? 'status-aktif' : 'status-nonaktif';
                    const statusText = schema.status === 'aktif' ? 'Aktif' : 'Nonaktif';
                    const statusIcon = schema.status === 'aktif' ? 'fa-circle-check' : 'fa-circle-pause';

                    // Format dates
                    const startDate = detail && detail.tgl_mulai ?
                        new Date(detail.tgl_mulai).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        }) : 'Tidak ditentukan';

                    const endDate = detail && detail.tgl_selesai ?
                        new Date(detail.tgl_selesai).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        }) : 'Tidak ditentukan';

                    const kategoriDeskripsi = detail && detail.kategori ?
                        detail.kategori.deskripsi :
                        'Schema Tanpa Nama';

                    const kategoriId = detail ? detail.kategori_id : 'Umum';
                    const kuota = detail ? detail.kuota : 0;

                    // 3. Tambahkan badge untuk urutan kategori
                    const kategoriBadge = `<span class="kategori-badge">${kategoriId}</span>`;

                    html += `
                        <div class="schema-item">
                            <div class="schema-item-header">
                                <div class="schema-item-title">
                                    ${index + 1 + '. '}
                                    ${kategoriBadge}
                                    ${kategoriDeskripsi}
                                </div>
                            </div>
                            
                            <div class="schema-meta-grid">
                                <div class="schema-meta-item">
                                    <i class="fas fa-hashtag"></i>
                                    <span><strong>Kategori:</strong> ${kategoriId}</span>
                                </div>
                                <div class="schema-meta-item">
                                    <i class="fas fa-calendar-day"></i>
                                    <span><strong>Mulai:</strong> ${startDate}</span>
                                </div>
                                <div class="schema-meta-item">
                                    <i class="fas fa-calendar-check"></i>
                                    <span><strong>Selesai:</strong> ${endDate}</span>
                                </div>
                                <div class="schema-meta-item">
                                    <i class="fas fa-users"></i>
                                    <span><strong>Kapasitas:</strong> ${kuota} Peserta</span>
                                </div>
                            </div>
                            
                            ${schema.deskripsi ? `
                                            <div class="schema-description">
                                                <i class="fas fa-file-alt me-2"></i>
                                                ${schema.deskripsi}
                                            </div>
                                        ` : ''}
                            
                            <div class="schema-actions">
                                <button type="button" class="btn btn-schema-action btn-warning text-white edit-schema-btn"
                                    data-schema-id="${schema.id_schema}"
                                    data-schedule-id="${scheduleId}"
                                    data-schema-data='${JSON.stringify(schema)}'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-schema-action btn-danger text-white delete-schema-btn"
                                    data-schema-id="${schema.id_schema}"
                                    data-schema-name="${kategoriDeskripsi}">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>
                    `;
                });

                html += `
                        </div>
                    </div>
                `;

                dropdownElement.innerHTML = html;

                // Add scroll to dropdown if content is too long
                setTimeout(() => {
                    const schemaList = dropdownElement.querySelector('.schema-content');
                    if (schemaList && schemaList.scrollHeight > 300) {
                        schemaList.style.maxHeight = 'fit-content';
                        schemaList.style.overflowY = 'auto';
                    }
                }, 100);
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.schedule-row') && !e.target.closest('.toggle-schema-btn')) {
                    document.querySelectorAll('.schema-dropdown.open').forEach(dropdown => {
                        dropdown.classList.remove('open');
                    });

                    document.querySelectorAll('.schedule-row.active').forEach(row => {
                        row.classList.remove('active');
                    });

                    document.querySelectorAll('.toggle-schema-btn[data-expanded="true"]').forEach(
                        button => {
                            button.dataset.expanded = 'false';
                            button.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Lihat Schema';
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-outline-primary');
                        });
                }
            });

            // Handle escape key to close dropdowns
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.schema-dropdown.open').forEach(dropdown => {
                        dropdown.classList.remove('open');
                    });

                    document.querySelectorAll('.schedule-row.active').forEach(row => {
                        row.classList.remove('active');
                    });

                    document.querySelectorAll('.toggle-schema-btn[data-expanded="true"]').forEach(
                        button => {
                            button.dataset.expanded = 'false';
                            button.innerHTML = '<i class="fas fa-chevron-down me-1"></i> Lihat Schema';
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-outline-primary');
                        });
                }
            });

            // Close all dropdowns when clicking on another schedule row
            document.querySelectorAll('.schedule-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    if (!e.target.closest('.toggle-schema-btn')) {
                        const currentScheduleId = this.dataset.scheduleId;

                        // Close all other dropdowns
                        document.querySelectorAll('.schema-dropdown.open').forEach(dropdown => {
                            const dropdownId = dropdown.id.replace('schema-dropdown-', '');
                            if (dropdownId !== currentScheduleId) {
                                dropdown.classList.remove('open');

                                // Reset button state
                                const button = document.querySelector(
                                    `.toggle-schema-btn[data-schedule-id="${dropdownId}"]`
                                );
                                if (button && button.dataset.expanded === 'true') {
                                    button.dataset.expanded = 'false';
                                    button.innerHTML =
                                        '<i class="fas fa-chevron-down me-1"></i> Lihat Schema';
                                    button.classList.remove('btn-primary');
                                    button.classList.add('btn-outline-primary');
                                }
                            }
                        });

                        // Remove active class from other rows
                        document.querySelectorAll('.schedule-row.active').forEach(otherRow => {
                            if (otherRow.dataset.scheduleId !== currentScheduleId) {
                                otherRow.classList.remove('active');
                            }
                        });
                    }
                });
            });

            // Edit Schedule Button Click
            document.querySelectorAll('.edit-schedule-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleData = JSON.parse(this.dataset.scheduleData);
                    const scheduleId = this.dataset.scheduleId;

                    // Fill form with schedule data
                    document.getElementById('edit_deskripsi').value = scheduleData.deskripsi || '';
                    document.getElementById('edit_kloter').value = scheduleData.kloter || '';
                    document.getElementById('edit_tgl_mulai').value = scheduleData.tgl_mulai ?
                        new Date(scheduleData.tgl_mulai).toISOString().split('T')[0] : '';
                    document.getElementById('edit_tgl_selesai').value = scheduleData.tgl_selesai ?
                        new Date(scheduleData.tgl_selesai).toISOString().split('T')[0] : '';


                    currentScheduleId = scheduleId;
                    editScheduleModal.show();
                });
            });

            // Edit Schema Button Click (dari schema dropdown) - MODAL VERSION
            document.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.edit-schema-btn');
                if (editBtn) {
                    e.preventDefault();
                    const schemaData = JSON.parse(editBtn.dataset.schemaData || '{}');
                    const scheduleId = editBtn.dataset.scheduleId;

                    // Tampilkan modal edit schema
                    showEditSchemaModal(schemaData, scheduleId);
                }
            });

            // Delete Schedule Button Click
            document.querySelectorAll('.delete-schedule-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleId = this.dataset.scheduleId;
                    const scheduleName = this.dataset.scheduleName;

                    document.getElementById('deleteConfirmationText').innerHTML =
                        `Anda akan menghapus schedule: <strong>"${scheduleName}"</strong>.<br>
                         Semua data terkait (schema, pendaftaran, dll) juga akan dihapus.`;

                    deleteType = 'schedule';
                    currentScheduleId = scheduleId;
                    confirmDeleteModal.show();
                });
            });

            // Delete Schema Button Click
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-schema-btn')) {
                    const btn = e.target.closest('.delete-schema-btn');
                    const schemaId = btn.dataset.schemaId;
                    const schemaName = btn.dataset.schemaName;

                    document.getElementById('deleteConfirmationText').innerHTML =
                        `Anda akan menghapus schema: <strong>"${schemaName}"</strong>.<br>
                         Data yang dihapus tidak dapat dikembalikan.`;

                    deleteType = 'schema';
                    currentSchemaId = schemaId;
                    confirmDeleteModal.show();
                }
            });

            // Confirm Delete Button Click
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteType === 'schedule' && currentScheduleId) {
                    deleteSchedule(currentScheduleId);
                } else if (deleteType === 'schema' && currentSchemaId) {
                    deleteSchema(currentSchemaId);
                }
            });

            // Function untuk menampilkan modal edit schema
            function showEditSchemaModal(schemaData, scheduleId) {
                if (!schemaData || !schemaData.id_schema) {
                    showToast('Data schema tidak valid', 'error');
                    return;
                }

                currentSchemaId = schemaData.id_schema;

                // Basic info
                document.getElementById('scheduleName').textContent = `${scheduleId}`;

                // Populate details jika ada dalam data schema
                const detailContainer = document.getElementById('detailSchemaContainer');
                detailContainer.innerHTML = '';

                if (schemaData.detail_schemas && schemaData.detail_schemas.length > 0) {
                    // Gunakan data yang sudah ada dari response AJAX
                    schemaData.detail_schemas.forEach((detail, index) => {
                        addDetailSchemaItem(detail, index + 1);
                    });
                } else {
                    // Jika tidak ada detail dalam data, tampilkan pesan
                    detailContainer.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Schema ini belum memiliki detail. Tambahkan detail untuk mengatur kategori dan kuota.
                        </div>
                    `;
                }

                editSchemaModal.show();
            }

            // Add Detail Schema Item
            function addDetailSchemaItem(detail = null, index = null) {
                const container = document.getElementById('detailSchemaContainer');
                const itemIndex = index || (container.children.length + 1);

                const detailId = detail ? detail.id_detail_schema : '';
                const kategoriId = detail ? detail.kategori_id : '';
                const deskripsi = detail ? (detail.deskripsi || detail.kategori?.deskripsi || '') : '';
                const kuota = detail ? detail.kuota : '';
                const tglMulai = detail && detail.tgl_mulai ?
                    new Date(detail.tgl_mulai).toISOString().split('T')[0] : '';
                const tglSelesai = detail && detail.tgl_selesai ?
                    new Date(detail.tgl_selesai).toISOString().split('T')[0] : '';

                const detailHtml = `
                    <div class="detail-schema-item" data-detail-id="${detailId}">
                        <div class="detail-schema-header">
                            <div class="detail-schema-title">
                                <span class="detail-schema-number">${itemIndex}</span>
                                Detail Schema ${itemIndex}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Kategori ID</label>
                                    <input type="text" class="form-control" name="details[${itemIndex}][kategori_id]" 
                                           value="${kategoriId}" placeholder="SCH_001" required readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi Kategori</label>
                                    <input type="text" class="form-control" name="details[${itemIndex}][deskripsi]" 
                                           value="${deskripsi}" placeholder="Deskripsi kategori" required readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kuota</label>
                                    <input type="number" class="form-control" name="details[${itemIndex}][kuota]" 
                                           value="${kuota}" placeholder="0" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="details[${itemIndex}][tgl_mulai]" 
                                           value="${tglMulai}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="details[${itemIndex}][tgl_selesai]" 
                                           value="${tglSelesai}">
                                </div>
                            </div>
                        </div>
                        ${detailId ? `<input type="hidden" name="details[${itemIndex}][id]" value="${detailId}">` : ''}
                    </div>
                `;

                container.innerHTML += detailHtml;
            }

            // Delete Schedule Function
            function deleteSchedule(scheduleId) {
                const urlTemplate = "{{ route('delete_schedule', ['id' => 'REPLACE_ID']) }}";
                const url = urlTemplate.replace('REPLACE_ID', scheduleId);
                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        confirmDeleteModal.hide();
                        if (data.success) {
                            showToast('Schedule berhasil dihapus', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Gagal menghapus schedule', 'error');
                        }
                    })
                    .catch(error => {
                        confirmDeleteModal.hide();
                        showToast('Terjadi kesalahan', 'error');
                        console.error('Error deleting schedule:', error);
                    });
            }

            // Delete Schema Function
            function deleteSchema(schemaId) {
                const urlTemplate = "{{ route('delete_schema', ['id' => 'REPLACE_ID']) }}";
                const url = urlTemplate.replace('REPLACE_ID', schemaId);

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        confirmDeleteModal.hide();
                        if (data.success) {
                            showToast('Schema berhasil dihapus', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Gagal menghapus schema', 'error');
                        }
                    })
                    .catch(error => {
                        confirmDeleteModal.hide();
                        showToast('Terjadi kesalahan', 'error');
                        console.error('Error deleting schema:', error);
                    });
            }

            // Show Toast Notification
            function showToast(message, type = 'success') {
                const toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';

                const toast = document.createElement('div');
                toast.className =
                    `toast align-items-center text-bg-${type === 'success' ? 'success' : 'danger'} border-0`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;

                toastContainer.appendChild(toast);
                document.body.appendChild(toastContainer);

                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                toast.addEventListener('hidden.bs.toast', function() {
                    toastContainer.remove();
                });
            }

            // Form Submission Handling
            document.getElementById('editScheduleForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this);
            });

            document.getElementById('editSchemaForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(this);
            });

            function submitForm(form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                console.log(form);

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;

                // Determine form URL based on form ID
                let formUrl = form.action;
                if (form.id === 'editSchemaForm' && currentSchemaId) {
                    formUrl = "{{ route('update-schema', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID',
                        currentSchemaId);
                } else if (form.id === 'editScheduleForm' && currentScheduleId) {
                    formUrl = "{{ route('update-schedule', ['id' => 'REPLACE_ID']) }}".replace('REPLACE_ID',
                        currentScheduleId);
                }

                fetch(formUrl, {
                        method: form.method,
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message || 'Data berhasil disimpan', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Gagal menyimpan data', 'error');
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        showToast('Terjadi kesalahan', 'error');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        console.error('Error submitting form:', error);
                    });
            }

            // Remove Detail Schema Item
            window.removeDetailSchemaItem = function(button) {
                const detailItem = button.closest('.detail-schema-item');
                const detailId = detailItem.dataset.detailId;

                if (detailId && confirm('Apakah Anda yakin ingin menghapus detail ini?')) {
                    // Jika ada ID, tampilkan konfirmasi untuk menghapus dari database
                    if (confirm('Detail ini akan dihapus dari database. Lanjutkan?')) {
                        fetch(`/dashboard/koordinator/schema/detail/${detailId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    detailItem.remove();
                                    renumberDetailSchemaItems();
                                    showToast('Detail berhasil dihapus', 'success');
                                } else {
                                    showToast('Gagal menghapus detail', 'error');
                                }
                            });
                    }
                } else {
                    // Jika belum disimpan, cukup hapus dari DOM
                    detailItem.remove();
                    renumberDetailSchemaItems();
                }
            }

            // Renumber Detail Schema Items
            function renumberDetailSchemaItems() {
                const detailItems = document.querySelectorAll('.detail-schema-item');
                detailItems.forEach((item, index) => {
                    const numberElement = item.querySelector('.detail-schema-number');
                    const indexNumber = index + 1;

                    if (numberElement) {
                        numberElement.textContent = indexNumber;
                    }

                    // Update input names
                    const inputs = item.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && name.includes('details[')) {
                            input.name = name.replace(/details\[\d+\]/, `details[${indexNumber}]`);
                        }
                    });
                });

                // Show warning if no details left
                if (detailItems.length === 0) {
                    const container = document.getElementById('detailSchemaContainer');
                    container.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Schema ini belum memiliki detail. Tambahkan detail untuk mengatur kategori dan kuota.
                        </div>
                    `;
                }
            }

            // Calculate duration when dates change
            document.getElementById('edit_tgl_mulai')?.addEventListener('change', calculateDuration);
            document.getElementById('edit_tgl_selesai')?.addEventListener('change', calculateDuration);

            function calculateDuration() {
                const start = document.getElementById('edit_tgl_mulai').value;
                const end = document.getElementById('edit_tgl_selesai').value;

                if (start && end) {
                    const startDate = new Date(start);
                    const endDate = new Date(end);
                    const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                    document.getElementById('edit_durasi_hari').value = duration >= 0 ? duration : 0;
                }
            }
        });
    </script>
@endsection
