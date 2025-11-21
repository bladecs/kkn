@extends('dashboard.dosen.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
        /* Card Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 25px;
            transition: transform 0.3s;
            height: 100%;
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

        /* Report Card Styles */
        .report-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .report-card:hover {
            border-left-color: var(--secondary-color);
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-reviewed {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #b8e0e6;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-late {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f1b0b7;
        }

        .score-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            flex: 1;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
        }

        /* Filter Section */
        .filter-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px 25px;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid #eaeaea;
            border-radius: 0 0 15px 15px;
        }

        .document-preview {
            border: 1px solid #eaeaea;
            border-radius: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 400px;
            margin-bottom: 20px;
        }

        .document-info {
            background: linear-gradient(135deg, #e8f0fe, #f0f4ff);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        /* Evaluation Form Styles */
        .evaluation-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }

        .evaluation-section h5 {
            color: var(--dark-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eaeaea;
            font-weight: 600;
        }

        .criteria-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .criteria-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .criteria-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .criteria-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .criteria-weight {
            font-size: 0.8rem;
            color: #6c757d;
            background-color: #f8f9fa;
            padding: 3px 8px;
            border-radius: 12px;
        }

        .criteria-description {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .score-slider {
            width: 100%;
            margin: 10px 0;
        }

        .score-input {
            width: 80px;
            text-align: center;
            font-weight: 600;
        }

        .score-display {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .total-score {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .total-score-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .total-score-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .comment-box {
            border-radius: 10px;
            border: 1px solid #eaeaea;
            padding: 15px;
            background-color: #f8f9fa;
            min-height: 120px;
            resize: vertical;
        }

        .comment-box:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .nav-tabs {
            border-bottom: 2px solid #eaeaea;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
        }

        .nav-tabs .nav-link.active {
            background-color: transparent;
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        /* Search and Filter */
        .search-box {
            position: relative;
        }

        .search-box .form-control {
            padding-left: 40px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        /* Report Card Content */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .student-main-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            margin-bottom: 2px;
            font-size: 0.95rem;
        }

        .student-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .report-meta {
            text-align: right;
        }

        .report-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        /* Results Indicator */
        .results-indicator {
            background-color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
        }

        .results-count {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.1rem;
        }

        .results-text {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            .report-header {
                flex-direction: column;
                gap: 10px;
            }

            .report-meta {
                text-align: left;
                width: 100%;
            }

            .card {
                margin-bottom: 20px;
            }
            
            .modal-dialog {
                margin: 10px;
            }
            
            .student-main-info {
                flex-direction: column;
                align-items: flex-start;
            }
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
    <div class="container-fluid p-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body py-4">
                        <h1 class="card-title"><i class="fas fa-clipboard-list me-2"></i> Daftar Laporan Harian
                            Mahasiswa</h1>
                        <p class="card-text mb-0">Kelola dan nilai laporan harian kegiatan KKN mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="filter-section">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control"
                                    placeholder="Cari nama mahasiswa atau kelompok...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Penilaian</option>
                                <option value="reviewed">Sudah Dinilai</option>
                                <option value="completed">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option value="">Semua Kelompok</option>
                                <option value="1">Kelompok 1</option>
                                <option value="2">Kelompok 2</option>
                                <option value="3">Kelompok 3</option>
                                <option value="4">Kelompok 4</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <h3 class="card-title">12</h3>
                        <p class="card-text">Menunggu Penilaian</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-success mb-2">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <h3 class="card-title">28</h3>
                        <p class="card-text">Sudah Dinilai</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <h3 class="card-title">5</h3>
                        <p class="card-text">Perlu Revisi</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="text-danger mb-2">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <h3 class="card-title">3</h3>
                        <p class="card-text">Terlambat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Indicator -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="results-indicator">
                    <span class="results-count">8 Laporan Ditemukan</span>
                    <span class="results-text"> - Menampilkan semua laporan harian mahasiswa</span>
                </div>
            </div>
        </div>

        <!-- Reports List - 4 cards per row on large screens, 3 on medium -->
        <div class="row" id="reportsList">
            <!-- Report Card 1 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Muhammad Rizki</div>
                                    <div class="student-meta">1234567890</div>
                                    <div class="student-meta">Kelompok 1</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">15 Juni 2023</div>
                                <span class="status-badge status-pending">Menunggu</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 2 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Sarah Nurhaliza</div>
                                    <div class="student-meta">1234567891</div>
                                    <div class="student-meta">Kelompok 2</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">15 Juni 2023</div>
                                <span class="score-badge">85/100</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-redo me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 3 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Ahmad Fauzi</div>
                                    <div class="student-meta">1234567892</div>
                                    <div class="student-meta">Kelompok 1</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">14 Juni 2023</div>
                                <span class="status-badge status-late">Terlambat</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 4 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Lisa Handayani</div>
                                    <div class="student-meta">1234567893</div>
                                    <div class="student-meta">Kelompok 3</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">15 Juni 2023</div>
                                <span class="status-badge status-reviewed">Dinilai</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-redo me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 5 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Budi Santoso</div>
                                    <div class="student-meta">1234567894</div>
                                    <div class="student-meta">Kelompok 2</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">14 Juni 2023</div>
                                <span class="score-badge">92/100</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-redo me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 6 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Dewi Anggraini</div>
                                    <div class="student-meta">1234567895</div>
                                    <div class="student-meta">Kelompok 4</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">15 Juni 2023</div>
                                <span class="status-badge status-pending">Menunggu</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 7 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Rizki Pratama</div>
                                    <div class="student-meta">1234567896</div>
                                    <div class="student-meta">Kelompok 1</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">15 Juni 2023</div>
                                <span class="status-badge status-completed">Selesai</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-redo me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Card 8 -->
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card report-card">
                    <div class="card-body">
                        <div class="report-header">
                            <div class="student-main-info">
                                <img src="https://via.placeholder.com/50" alt="Student" class="student-avatar">
                                <div class="student-details">
                                    <div class="student-name">Siti Rahma</div>
                                    <div class="student-meta">1234567897</div>
                                    <div class="student-meta">Kelompok 3</div>
                                </div>
                            </div>
                            <div class="report-meta">
                                <div class="report-date">14 Juni 2023</div>
                                <span class="score-badge">78/100</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye me-1"></i> Preview
                            </button>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal">
                                <i class="fas fa-redo me-1"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="row mt-2">
            <div class="col-12 text-center">
                <button class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i> Muat Lebih Banyak
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="fas fa-file-alt me-2"></i> Preview Laporan Harian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Document Info -->
                    <div class="document-info">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama Mahasiswa:</strong> Muhammad Rizki</p>
                                <p class="mb-1"><strong>NIM:</strong> 1234567890</p>
                                <p class="mb-1"><strong>Kelompok:</strong> Kelompok 1 - Desa Sukamaju</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Laporan:</strong> 15 Juni 2023</p>
                                <p class="mb-1"><strong>Waktu Pengumpulan:</strong> 15.30 WIB</p>
                                <p class="mb-0"><strong>Status:</strong> <span
                                        class="status-badge status-pending">Menunggu Penilaian</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Preview -->
                    <div class="document-preview">
                        <div class="text-center py-5">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                            <h5>Laporan_Harian_15062023_Muhammad_Rizki.pdf</h5>
                            <p class="text-muted">Dokumen akan ditampilkan di sini</p>
                            <div class="mt-4">
                                <button class="btn btn-primary me-2">
                                    <i class="fas fa-download me-2"></i> Download PDF
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-print me-2"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#evaluationModal" data-bs-dismiss="modal">
                        <i class="fas fa-edit me-2"></i> Lanjut ke Penilaian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluationModalLabel">
                        <i class="fas fa-edit me-2"></i> Penilaian Laporan Harian
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Document Info -->
                    <div class="document-info">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nama Mahasiswa:</strong> Muhammad Rizki</p>
                                <p class="mb-1"><strong>NIM:</strong> 1234567890</p>
                                <p class="mb-1"><strong>Kelompok:</strong> Kelompok 1 - Desa Sukamaju</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Laporan:</strong> 15 Juni 2023</p>
                                <p class="mb-1"><strong>Waktu Pengumpulan:</strong> 15.30 WIB</p>
                                <p class="mb-0"><strong>Status:</strong> <span
                                        class="status-badge status-pending">Menunggu Penilaian</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="evaluationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="criteria-tab" data-bs-toggle="tab" data-bs-target="#criteria" type="button" role="tab" aria-controls="criteria" aria-selected="true">
                                <i class="fas fa-list-check me-2"></i> Kriteria Penilaian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview" type="button" role="tab" aria-controls="preview" aria-selected="false">
                                <i class="fas fa-file-alt me-2"></i> Preview Laporan
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="evaluationTabsContent">
                        <!-- Criteria Tab -->
                        <div class="tab-pane fade show active" id="criteria" role="tabpanel" aria-labelledby="criteria-tab">
                            <form id="evaluationForm">
                                <!-- Content Section -->
                                <div class="evaluation-section">
                                    <h5><i class="fas fa-align-left me-2"></i> Isi Laporan</h5>
                                    
                                    <div class="criteria-item">
                                        <div class="criteria-header">
                                            <span class="criteria-title">Kelengkapan Informasi</span>
                                            <span class="criteria-weight">Bobot: 25%</span>
                                        </div>
                                        <div class="criteria-description">
                                            Kelengkapan informasi yang disajikan dalam laporan harian
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range score-slider" min="0" max="25" step="0.5" value="0" id="contentCompleteness">
                                            <input type="number" class="form-control score-input ms-3" min="0" max="25" step="0.5" value="0" id="contentCompletenessInput">
                                            <span class="ms-2">/ 25</span>
                                        </div>
                                    </div>
                                    
                                    <div class="criteria-item">
                                        <div class="criteria-header">
                                            <span class="criteria-title">Kesesuaian dengan Kegiatan</span>
                                            <span class="criteria-weight">Bobot: 20%</span>
                                        </div>
                                        <div class="criteria-description">
                                            Kesesuaian isi laporan dengan kegiatan yang dilaksanakan
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range score-slider" min="0" max="20" step="0.5" value="0" id="activityRelevance">
                                            <input type="number" class="form-control score-input ms-3" min="0" max="20" step="0.5" value="0" id="activityRelevanceInput">
                                            <span class="ms-2">/ 20</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Writing Quality Section -->
                                <div class="evaluation-section">
                                    <h5><i class="fas fa-pen me-2"></i> Kualitas Penulisan</h5>
                                    
                                    <div class="criteria-item">
                                        <div class="criteria-header">
                                            <span class="criteria-title">Struktur dan Keruntutan</span>
                                            <span class="criteria-weight">Bobot: 15%</span>
                                        </div>
                                        <div class="criteria-description">
                                            Keruntutan penyajian dan struktur penulisan laporan
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range score-slider" min="0" max="15" step="0.5" value="0" id="writingStructure">
                                            <input type="number" class="form-control score-input ms-3" min="0" max="15" step="0.5" value="0" id="writingStructureInput">
                                            <span class="ms-2">/ 15</span>
                                        </div>
                                    </div>
                                    
                                    <div class="criteria-item">
                                        <div class="criteria-header">
                                            <span class="criteria-title">Tata Bahasa dan Ejaan</span>
                                            <span class="criteria-weight">Bobot: 15%</span>
                                        </div>
                                        <div class="criteria-description">
                                            Penggunaan tata bahasa dan ejaan yang baik dan benar
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range score-slider" min="0" max="15" step="0.5" value="0" id="grammarSpelling">
                                            <input type="number" class="form-control score-input ms-3" min="0" max="15" step="0.5" value="0" id="grammarSpellingInput">
                                            <span class="ms-2">/ 15</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeliness Section -->
                                <div class="evaluation-section">
                                    <h5><i class="fas fa-clock me-2"></i> Ketepatan Waktu</h5>
                                    
                                    <div class="criteria-item">
                                        <div class="criteria-header">
                                            <span class="criteria-title">Ketepatan Pengumpulan</span>
                                            <span class="criteria-weight">Bobot: 25%</span>
                                        </div>
                                        <div class="criteria-description">
                                            Ketepatan waktu pengumpulan laporan harian
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range score-slider" min="0" max="25" step="0.5" value="0" id="timeliness">
                                            <input type="number" class="form-control score-input ms-3" min="0" max="25" step="0.5" value="0" id="timelinessInput">
                                            <span class="ms-2">/ 25</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Score -->
                                <div class="total-score">
                                    <div class="total-score-label">Total Nilai</div>
                                    <div class="total-score-value" id="totalScore">0</div>
                                    <div class="total-score-label">dari 100</div>
                                </div>

                                <!-- Comments -->
                                <div class="evaluation-section">
                                    <h5><i class="fas fa-comment me-2"></i> Komentar dan Saran</h5>
                                    <div class="mb-3">
                                        <label for="comments" class="form-label">Komentar untuk Mahasiswa</label>
                                        <textarea class="form-control comment-box" id="comments" rows="4" placeholder="Berikan komentar dan saran untuk perbaikan laporan..."></textarea>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="needsRevision">
                                        <label class="form-check-label" for="needsRevision">
                                            Laporan perlu revisi
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Preview Tab -->
                        <div class="tab-pane fade" id="preview" role="tabpanel" aria-labelledby="preview-tab">
                            <div class="document-preview">
                                <div class="text-center py-5">
                                    <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                                    <h5>Laporan_Harian_15062023_Muhammad_Rizki.pdf</h5>
                                    <p class="text-muted">Dokumen akan ditampilkan di sini</p>
                                    <div class="mt-4">
                                        <button class="btn btn-primary me-2">
                                            <i class="fas fa-download me-2"></i> Download PDF
                                        </button>
                                        <button class="btn btn-outline-primary">
                                            <i class="fas fa-print me-2"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEvaluation">
                        <i class="fas fa-save me-2"></i> Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.querySelector('.search-box input');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const reportCards = document.querySelectorAll('.report-card');
                let visibleCount = 0;

                reportCards.forEach(card => {
                    const studentName = card.querySelector('.student-name').textContent
                        .toLowerCase();
                    const studentNim = card.querySelector('.student-meta').textContent
                        .toLowerCase();

                    if (studentName.includes(searchTerm) || studentNim.includes(searchTerm)) {
                        card.parentElement.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.parentElement.style.display = 'none';
                    }
                });

                // Update results indicator
                document.querySelector('.results-count').textContent = `${visibleCount} Laporan Ditemukan`;
            });

            // Evaluation form functionality
            function updateTotalScore() {
                const contentCompleteness = parseFloat(document.getElementById('contentCompletenessInput').value) || 0;
                const activityRelevance = parseFloat(document.getElementById('activityRelevanceInput').value) || 0;
                const writingStructure = parseFloat(document.getElementById('writingStructureInput').value) || 0;
                const grammarSpelling = parseFloat(document.getElementById('grammarSpellingInput').value) || 0;
                const timeliness = parseFloat(document.getElementById('timelinessInput').value) || 0;
                
                const totalScore = contentCompleteness + activityRelevance + writingStructure + grammarSpelling + timeliness;
                document.getElementById('totalScore').textContent = totalScore.toFixed(1);
            }

            // Sync slider and input values
            const sliders = document.querySelectorAll('.score-slider');
            sliders.forEach(slider => {
                const inputId = slider.id + 'Input';
                const input = document.getElementById(inputId);
                
                slider.addEventListener('input', function() {
                    input.value = this.value;
                    updateTotalScore();
                });
                
                input.addEventListener('input', function() {
                    const max = parseFloat(slider.getAttribute('max'));
                    const value = parseFloat(this.value) || 0;
                    
                    if (value > max) {
                        this.value = max;
                    } else if (value < 0) {
                        this.value = 0;
                    }
                    
                    slider.value = this.value;
                    updateTotalScore();
                });
            });

            // Save evaluation
            document.getElementById('saveEvaluation').addEventListener('click', function() {
                const totalScore = parseFloat(document.getElementById('totalScore').textContent);
                const comments = document.getElementById('comments').value;
                const needsRevision = document.getElementById('needsRevision').checked;
                
                // Here you would typically send the data to the server
                console.log('Saving evaluation:', {
                    totalScore,
                    comments,
                    needsRevision
                });
                
                // Show success message and close modal
                alert('Penilaian berhasil disimpan!');
                const modal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
                modal.hide();
            });

            // Initialize total score
            updateTotalScore();
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