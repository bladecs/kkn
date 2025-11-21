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
            border-radius: 10px;
            border: none;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .document-preview {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 400px;
        }

        .document-info {
            background-color: #e8f0fe;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
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
                            <a href="form-penilaian.html" class="btn btn-success btn-sm">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-redo me-1"></i> Edit
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-success btn-sm">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-redo me-1"></i> Edit
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-redo me-1"></i> Edit
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-success btn-sm">
                                <i class="fas fa-edit me-1"></i> Nilai
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-redo me-1"></i> Edit
                            </a>
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
                            <a href="form-penilaian.html" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-redo me-1"></i> Edit
                            </a>
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
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="fas fa-file-alt me-2"></i> Preview Laporan Harian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
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
                    <a href="form-penilaian.html" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i> Lanjut ke Penilaian
                    </a>
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
