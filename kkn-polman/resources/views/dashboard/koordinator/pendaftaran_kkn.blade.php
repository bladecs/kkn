@extends('dashboard.koordinator.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
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

        /* Status Indicator Styles */
        .status-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .status-item {
            flex: 1;
            text-align: center;
            padding: 20px 15px;
            border-radius: 10px;
            background: #f8f9fa;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .status-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-item:first-child {
            margin-left: 0;
        }

        .status-item:last-child {
            margin-right: 0;
        }

        .status-icon {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .status-count {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .status-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #e0a800;
        }

        .status-verified {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-rejected {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .status-completed {
            background-color: rgba(23, 162, 184, 0.15);
            color: #17a2b8;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.75rem;
        }

        .table-container {
            overflow-x: auto;
        }

        /* Activity Timeline */
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -33px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            z-index: 2;
        }

        .timeline-item.recent::before {
            background-color: var(--success-color);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }

        .timeline-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
        }

        .timeline-item.recent .timeline-content {
            border-left-color: var(--success-color);
        }

        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .timeline-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4d8aff 100%);
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
            max-height: 70vh;
            overflow-y: auto;
        }

        .student-info-section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark-color);
            font-weight: 500;
        }

        .file-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .file-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .file-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .file-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .file-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 10px;
            word-break: break-word;
        }

        .file-actions {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .btn-file {
            padding: 5px 12px;
            font-size: 0.75rem;
            border-radius: 20px;
        }

        .status-display {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        .student-photo {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            margin: 10px auto;
            display: block;
        }

        .photo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        /* File Preview Modal */
        .file-preview-modal .modal-dialog {
            max-width: 90%;
            max-height: 90vh;
            margin: 20px auto;
        }

        .file-preview-modal .modal-content {
            border-radius: 10px;
            height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .file-preview-modal .modal-header {
            background: #f8f9fa;
            color: var(--dark-color);
            border-bottom: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .file-preview-modal .modal-body {
            padding: 0;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            overflow: hidden;
        }

        .image-preview {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-error {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .preview-error i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dc3545;
        }

        .file-status {
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .file-available {
            color: #28a745;
        }

        .file-missing {
            color: #dc3545;
        }

        .pdf-only-download .file-actions {
            justify-content: center;
        }

        .pdf-only-download .view-file {
            display: none;
        }

        /* Verification Modal Styles */
        .verification-modal .student-info-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .verification-modal .student-photo-small {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }

        .verification-modal .status-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .verification-modal .status-option {
            text-align: center;
            padding: 20px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .verification-modal .status-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .verification-modal .status-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(0, 123, 255, 0.05);
        }

        .verification-modal .status-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .verification-modal .status-text {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .verification-modal .status-desc {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .verification-modal .notes-section {
            margin-top: 20px;
        }

        .verification-modal .notes-section textarea {
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
        }

        /* Sembunyikan checkbox asli */
        .info-item input[type="checkbox"] {
            display: none;
        }

        /* Style tombol */
        .btn-checkbox {
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            border: 2px solid #bfbfbf;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f2f2f2;
            transition: .25s;
        }

        /* Hover effect */
        .btn-checkbox:hover {
            background: #e8e8e8;
        }

        /* VERIFIED saat dicentang */
        #statusVerified:checked+.verified-btn {
            background: #28a745;
            border-color: #28a745;
            color: white;
        }

        /* REJECTED saat dicentang */
        #statusReject:checked+.rejected-btn {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .status-indicator {
                flex-wrap: wrap;
            }

            .status-item {
                flex: 0 0 calc(50% - 20px);
                margin-bottom: 15px;
            }

            .table-container {
                font-size: 0.85rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .file-grid {
                grid-template-columns: 1fr;
            }

            .modal-body {
                padding: 20px 15px;
            }

            .file-preview-modal .modal-dialog {
                max-width: 100%;
                margin: 10px;
            }

            .verification-modal .status-options {
                grid-template-columns: 1fr;
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

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body py-4">
                    <h1 class="card-title"><i class="fas fa-graduation-cap me-2"></i> Sistem Informasi KKN</h1>
                    <p class="card-text mb-0">Kuliah Kerja Nyata - Universitas</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Indicators -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-chart-pie section-icon"></i>
                        <h5 class="section-title">Status Pendaftaran Mahasiswa</h5>
                    </div>
                    <div class="status-indicator">
                        <div class="status-item" style="border-left: 4px solid #ffc107;">
                            <i class="fas fa-clock status-icon" style="color: #ffc107;"></i>
                            <div class="status-count">{{ $status_counts['pending'] ?? 0 }}</div>
                            <div class="status-label">Pending</div>
                        </div>
                        <div class="status-item" style="border-left: 4px solid #28a745;">
                            <i class="fas fa-check-circle status-icon" style="color: #28a745;"></i>
                            <div class="status-count">{{ $status_counts['verified'] ?? 0 }}</div>
                            <div class="status-label">Terverifikasi</div>
                        </div>
                        <div class="status-item" style="border-left: 4px solid #dc3545;">
                            <i class="fas fa-times-circle status-icon" style="color: #dc3545;"></i>
                            <div class="status-count">{{ $status_counts['rejected'] ?? 0 }}</div>
                            <div class="status-label">Ditolak</div>
                        </div>
                        <div class="status-item" style="border-left: 4px solid #17a2b8;">
                            <i class="fas fa-flag-checkered status-icon" style="color: #17a2b8;"></i>
                            <div class="status-count">{{ $status_counts['completed'] ?? 0 }}</div>
                            <div class="status-label">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Mahasiswa Pendaftar KKN -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-table section-icon"></i>
                        <h5 class="section-title">Data Mahasiswa Pendaftar KKN</h5>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data_pendaftaran) && count($data_pendaftaran) > 0)
                                    @foreach ($data_pendaftaran as $index => $mahasiswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $mahasiswa['name'] }}</td>
                                            <td>{{ $mahasiswa['nim'] }}</td>
                                            <td>{{ $mahasiswa['study_program'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($mahasiswa['created_at'])->format('d M Y H:i') }}
                                            </td>
                                            <td>
                                                @if ($mahasiswa['status'] == 'verifikasi')
                                                    <span class="status-badge status-pending">Pending</span>
                                                @elseif($mahasiswa['status'] == 'verified')
                                                    <span class="status-badge status-verified">Terverifikasi</span>
                                                @elseif($mahasiswa['status'] == 'rejected')
                                                    <span class="status-badge status-rejected">Ditolak</span>
                                                @elseif($mahasiswa['status'] == 'complete')
                                                    <span class="status-badge status-completed">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-sm btn-primary view-detail"
                                                        data-bs-toggle="modal" data-bs-target="#detailModal"
                                                        data-mahasiswa='@json($mahasiswa)'
                                                        title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <form action="{{ route('hapus-pendaftaran', $mahasiswa['nim']) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" type="submit"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted">Belum ada data mahasiswa pendaftar KKN</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coordinator Activity Timeline -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-history section-icon"></i>
                        <h5 class="section-title">Aktivitas Terbaru Koordinator</h5>
                    </div>
                    <div class="activity-timeline">
                        @if (isset($aktivitas_koordinator) && count($aktivitas_koordinator) > 0)
                            @foreach ($aktivitas_koordinator as $aktivitas)
                                <div class="timeline-item {{ $loop->first ? 'recent' : '' }}">
                                    <div class="timeline-date">{{ $aktivitas['tanggal'] }}</div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">{{ $aktivitas['judul'] }}</div>
                                        <p class="timeline-desc">{{ $aktivitas['deskripsi'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada aktivitas koordinator</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Mahasiswa -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-user-graduate me-2"></i>
                        Detail Data Mahasiswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('verifikasi-pendaftaran') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="text" name="nim" id="nim" hidden value="">
                        <!-- Student Photo -->
                        <div class="photo-container">
                            <img id="modalPhoto" src="" alt="Foto Mahasiswa" class="student-photo"
                                onerror="this.style.display='none'">
                            <div class="info-label mt-2">Foto Profil</div>
                        </div>

                        <!-- Personal Information -->
                        <div class="student-info-section">
                            <div class="section-title">
                                <i class="fas fa-id-card me-2"></i>
                                Informasi Pribadi
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Nama Lengkap</span>
                                    <span class="info-value" id="modalName">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">NIM</span>
                                    <span class="info-value" id="modalNim">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Program Studi</span>
                                    <span class="info-value" id="modalStudyProgram">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Email</span>
                                    <span class="info-value" id="modalEmail">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">No. Telepon</span>
                                    <span class="info-value" id="modalPhone">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Alamat</span>
                                    <span class="info-value" id="modalAddress">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Information -->
                        <div class="student-info-section">
                            <div class="section-title">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Informasi Pendaftaran
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Tanggal Pendaftaran</span>
                                    <span class="info-value" id="modalCreatedAt">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="status-display" id="modalStatus">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Lokasi KKN</span>
                                    <span class="info-value" id="modalLocation">-</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Kelompok KKN</span>
                                    <span class="info-value" id="modalGroup">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="student-info-section">
                            <div class="section-title">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Status Verifikasi
                            </div>
                            <div class="info-grid">
                                <!-- VERIFIED -->
                                <div class="info-item">
                                    <input type="checkbox" name="status" id="statusVerified" value="complete">
                                    <label for="statusVerified" class="btn-checkbox verified-btn">
                                        <i class="fas fa-check"></i> Verified
                                    </label>
                                </div>

                                <!-- REJECTED -->
                                <div class="info-item">
                                    <input type="checkbox" name="status" id="statusReject" value="rejected">
                                    <label for="statusReject" class="btn-checkbox rejected-btn">
                                        <i class="fas fa-times"></i> Rejected
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- File Attachments -->
                        <div class="student-info-section">
                            <div class="section-title">
                                <i class="fas fa-paperclip me-2"></i>
                                Dokumen Pendaftaran
                            </div>
                            <div class="file-section">
                                <div class="file-grid">
                                    <!-- KTM -->
                                    <div class="file-item" data-file-type="ktm" id="ktmFileItem">
                                        <i class="fas fa-id-card file-icon"></i>
                                        <div class="file-name" id="modalKtmName">Kartu Tanda Mahasiswa</div>
                                        <div class="file-status" id="modalKtmStatus"></div>
                                        <div class="file-actions">
                                            <button class="btn btn-primary btn-sm btn-file view-file"
                                                data-file-type="ktm">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </button>
                                            <button class="btn btn-success btn-sm btn-file download-file"
                                                data-file-type="ktm">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Proposal -->
                                    <div class="file-item pdf-only-download" data-file-type="proposal"
                                        id="proposalFileItem">
                                        <i class="fas fa-file-pdf file-icon"></i>
                                        <div class="file-name" id="modalProposalName">Proposal KKN</div>
                                        <div class="file-status" id="modalProposalStatus"></div>
                                        <div class="file-actions">
                                            <button class="btn btn-success btn-sm btn-file download-file"
                                                data-file-type="proposal">
                                                <i class="fas fa-download me-1"></i> Unduh PDF
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Photo -->
                                    <div class="file-item" data-file-type="photo" id="photoFileItem">
                                        <i class="fas fa-camera file-icon"></i>
                                        <div class="file-name" id="modalPhotoName">Foto Profil</div>
                                        <div class="file-status" id="modalPhotoStatus"></div>
                                        <div class="file-actions">
                                            <button class="btn btn-primary btn-sm btn-file view-file"
                                                data-file-type="photo">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </button>
                                            <button class="btn btn-success btn-sm btn-file download-file"
                                                data-file-type="photo">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-warning verify-from-detail" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#verifyModal">
                            <i class="fas fa-check-circle me-1"></i> Verifikasi Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview File -->
    <div class="modal fade file-preview-modal" id="filePreviewModal" tabindex="-1"
        aria-labelledby="filePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filePreviewModalLabel">
                        <i class="fas fa-file-image me-2"></i>
                        Preview Gambar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="filePreviewContent">
                        <!-- Content akan diisi secara dinamis -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-success" id="downloadFileBtn">
                        <i class="fas fa-download me-1"></i> Unduh
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            // Auto-dismiss alerts
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

            // Current student data for file preview
            let currentStudentData = null;
            let currentFileUrl = null;
            let currentFileName = null;
            let currentFileType = null;

            // Modal functionality
            const viewButtons = document.querySelectorAll('.view-detail');

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mahasiswaData = JSON.parse(this.getAttribute('data-mahasiswa'));
                    console.log('Mahasiswa Data:', mahasiswaData);
                    currentStudentData = mahasiswaData;
                    populateModal(mahasiswaData);
                });
            });

            function populateModal(data) {
                // Basic information
                document.getElementById('nim').value = data.nim || '';
                document.getElementById('modalName').textContent = data.name || '-';
                document.getElementById('modalNim').textContent = data.nim || '-';
                document.getElementById('modalStudyProgram').textContent = data.study_program || '-';
                document.getElementById('modalEmail').textContent = data.user.email || '-';
                document.getElementById('modalPhone').textContent = data.user.phone || '-';
                document.getElementById('modalAddress').textContent = data.user.alamat || '-';

                // Registration information
                document.getElementById('modalCreatedAt').textContent = data.created_at ?
                    new Date(data.created_at).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-';

                document.getElementById('modalLocation').textContent = data.kkn_location || '-';
                document.getElementById('modalGroup').textContent = data.kkn_group || '-';

                // Status
                const statusElement = document.getElementById('modalStatus');
                statusElement.textContent = getStatusText(data.status);
                statusElement.className = 'status-display ' + getStatusClass(data.status);

                // Photo
                const photoElement = document.getElementById('modalPhoto');
                if (data.photo_path) {
                    photoElement.src = generateStorageUrl(data.photo_path);
                    photoElement.style.display = 'block';
                } else {
                    photoElement.style.display = 'none';
                }

                // File names and status
                updateFileStatus('ktm', data.ktm_path);
                updateFileStatus('proposal', data.proposal_path);
                updateFileStatus('photo', data.photo_path);

                // Tentukan apakah file adalah PDF dan sesuaikan tampilan
                adjustFileDisplay(data);
            }

            function adjustFileDisplay(data) {
                // Untuk proposal (PDF), sembunyikan tombol view
                if (data.proposal_path && isPdfFile(data.proposal_path)) {
                    document.getElementById('proposalFileItem').classList.add('pdf-only-download');
                }

                // Untuk KTM, tampilkan tombol view hanya jika bukan PDF
                if (data.ktm_path && isPdfFile(data.ktm_path)) {
                    document.getElementById('ktmFileItem').classList.add('pdf-only-download');
                }
            }

            function updateFileStatus(fileType, filePath) {
                const nameElement = document.getElementById(`modal${capitalizeFirst(fileType)}Name`);
                const statusElement = document.getElementById(`modal${capitalizeFirst(fileType)}Status`);

                if (filePath) {
                    const fileName = getFileName(filePath);
                    nameElement.textContent = fileName || getFileTypeName(fileType);

                    // Check file availability
                    checkFileAvailability(filePath).then(isAvailable => {
                        if (isAvailable) {
                            statusElement.textContent = 'File tersedia';
                            statusElement.className = 'file-status file-available';
                        } else {
                            statusElement.textContent = 'File tidak ditemukan';
                            statusElement.className = 'file-status file-missing';
                        }
                    });
                } else {
                    nameElement.textContent = getFileTypeName(fileType);
                    statusElement.textContent = 'File tidak diunggah';
                    statusElement.className = 'file-status file-missing';
                }
            }

            function capitalizeFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            async function checkFileAvailability(filePath) {
                if (!filePath) return false;

                try {
                    const fileUrl = generateStorageUrl(filePath);
                    const response = await fetch(fileUrl, {
                        method: 'HEAD'
                    });
                    return response.ok;
                } catch (error) {
                    console.error('Error checking file availability:', error);
                    return false;
                }
            }

            function getStatusText(status) {
                const statusMap = {
                    'verifikasi': 'Pending',
                    'verified': 'Terverifikasi',
                    'rejected': 'Ditolak',
                    'completed': 'Selesai'
                };
                return statusMap[status] || 'Unknown';
            }

            function getStatusClass(status) {
                const classMap = {
                    'verifikasi': 'status-pending',
                    'verified': 'status-verified',
                    'rejected': 'status-rejected',
                    'completed': 'status-completed'
                };
                return classMap[status] || 'status-pending';
            }

            function getFileName(path) {
                if (!path) return null;
                return path.split('/').pop().split('\\').pop();
            }

            function generateStorageUrl(filePath) {
                if (!filePath) return '';

                // Jika path sudah berupa URL lengkap, return langsung
                if (filePath.startsWith('http')) {
                    return filePath;
                }

                // Jika path relatif, tambahkan base URL storage
                const baseUrl = '{{ url('/') }}';

                // Handle different path formats
                let cleanPath = filePath;
                if (cleanPath.startsWith('public/')) {
                    cleanPath = cleanPath.replace('public/', '');
                }
                if (cleanPath.startsWith('/')) {
                    cleanPath = cleanPath.substring(1);
                }

                return `${baseUrl}/storage/${cleanPath}`;
            }

            // File preview functionality hanya untuk gambar
            document.querySelectorAll('.view-file').forEach(button => {
                button.addEventListener('click', function() {
                    const fileType = this.getAttribute('data-file-type');
                    previewFile(fileType);
                });
            });

            // Download functionality
            document.querySelectorAll('.download-file').forEach(button => {
                button.addEventListener('click', function() {
                    const fileType = this.getAttribute('data-file-type');
                    downloadFileDirect(fileType);
                });
            });

            function previewFile(fileType) {
                if (!currentStudentData) {
                    showAlert('Data mahasiswa tidak tersedia', 'error');
                    return;
                }

                const filePath = currentStudentData[`${fileType}_path`];
                if (!filePath) {
                    showAlert('File tidak ditemukan dalam database', 'warning');
                    return;
                }

                // Cek apakah file adalah gambar
                const fileName = getFileName(filePath) || getFileTypeName(fileType);
                const fileExtension = fileName ? fileName.split('.').pop().toLowerCase() : '';

                if (!isImageFile(fileExtension)) {
                    showAlert('Preview hanya tersedia untuk file gambar', 'info');
                    return;
                }

                currentFileUrl = generateStorageUrl(filePath);
                currentFileName = fileName;
                currentFileType = fileType;

                // Check file availability first
                checkFileAvailability(filePath).then(isAvailable => {
                    if (!isAvailable) {
                        showAlert('File tidak dapat diakses. Silakan coba download file.', 'error');
                        return;
                    }

                    const previewModal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
                    const previewContent = document.getElementById('filePreviewContent');
                    const modalTitle = document.getElementById('filePreviewModalLabel');
                    const downloadBtn = document.getElementById('downloadFileBtn');

                    // Set modal title
                    modalTitle.innerHTML =
                        `<i class="fas fa-file-image me-2"></i>Preview ${getFileTypeName(fileType)} - ${currentFileName}`;

                    // Set download button
                    downloadBtn.onclick = () => downloadFileDirect(fileType);

                    // Clear previous content
                    previewContent.innerHTML = '';

                    // Show image preview
                    showImagePreview(currentFileUrl, currentFileName, previewContent);

                    previewModal.show();
                }).catch(error => {
                    console.error('Error checking file:', error);
                    showAlert('Terjadi kesalahan saat mengakses file', 'error');
                });
            }

            function showImagePreview(fileUrl, fileName, previewContent) {
                previewContent.innerHTML = `
                    <div style="text-align: center; padding: 20px; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                        <img src="${fileUrl}" alt="${fileName}" 
                             class="image-preview"
                             onerror="showPreviewError(this)">
                    </div>
                `;
            }

            function downloadFileDirect(fileType) {
                if (!currentStudentData) {
                    showAlert('Data mahasiswa tidak tersedia', 'error');
                    return;
                }

                const filePath = currentStudentData[`${fileType}_path`];
                if (!filePath) {
                    showAlert('File tidak ditemukan', 'warning');
                    return;
                }

                const fileUrl = generateStorageUrl(filePath);
                const fileName = getFileName(filePath) || `${fileType}_${currentStudentData.nim}`;

                triggerDownload(fileUrl, fileName);
            }

            function triggerDownload(fileUrl, fileName) {
                // Create a temporary anchor element to trigger download
                const link = document.createElement('a');
                link.href = fileUrl;
                link.download = fileName;
                link.target = '_blank';

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            function getFileTypeName(fileType) {
                const typeMap = {
                    'ktm': 'Kartu Tanda Mahasiswa',
                    'proposal': 'Proposal KKN',
                    'photo': 'Foto Profil'
                };
                return typeMap[fileType] || 'Dokumen';
            }

            function isImageFile(extension) {
                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                return imageExtensions.includes(extension);
            }

            function isPdfFile(filePath) {
                if (!filePath) return false;
                const fileName = getFileName(filePath);
                const extension = fileName ? fileName.split('.').pop().toLowerCase() : '';
                return extension === 'pdf';
            }

            function showAlert(message, type = 'info') {
                // Create a simple toast notification
                const toast = document.createElement('div');
                toast.className =
                    `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                toast.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times' : 'info'}-circle me-2"></i>
                        <div>${message}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                document.body.appendChild(toast);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 5000);
            }

            // Global functions untuk error handling
            window.showPreviewError = function(imgElement) {
                const container = imgElement.parentElement;
                container.innerHTML = `
                    <div class="preview-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h5>Gagal Memuat Gambar</h5>
                        <p>File gambar tidak dapat ditampilkan.</p>
                        <button class="btn btn-primary" onclick="downloadCurrentFile()">
                            <i class="fas fa-download me-1"></i> Download Gambar
                        </button>
                    </div>
                `;
            };

            window.downloadCurrentFile = function() {
                if (currentFileUrl && currentFileName) {
                    triggerDownload(currentFileUrl, currentFileName);
                }
            };

            // Verification Modal Functionality
            document.querySelectorAll('.verify-student').forEach(button => {
                button.addEventListener('click', function() {
                    const mahasiswaData = JSON.parse(this.getAttribute('data-mahasiswa'));
                    openVerificationModal(mahasiswaData);
                });
            });

            // Verification from detail modal
            document.querySelector('.verify-from-detail').addEventListener('click', function() {
                if (currentStudentData) {
                    openVerificationModal(currentStudentData);
                }
            });

            // Status selection
            document.querySelectorAll('.status-option').forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    document.querySelectorAll('.status-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Set selected status value
                    const status = this.getAttribute('data-status');
                    document.getElementById('selectedStatus').value = status;

                    // Enable submit button
                    document.getElementById('submitVerification').disabled = false;
                });
            });
        })();
    </script>
@endsection
