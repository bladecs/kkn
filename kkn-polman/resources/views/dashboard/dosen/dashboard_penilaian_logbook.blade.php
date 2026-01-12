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

        /* Table Styles */
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .table-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #eaeaea;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Tab Styles */
        .nav-tabs {
            border-bottom: 2px solid #eaeaea;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            color: #6c757d;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            transition: all 0.3s;
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: white;
            border-bottom: 3px solid var(--primary-color);
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            min-width: 100px;
            text-align: center;
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

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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

        /* Document Info */
        .document-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #eaeaea;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: var(--dark-color);
            min-width: 180px;
        }

        .info-value {
            color: #6c757d;
        }

        /* Action Buttons in Modal */
        .action-buttons-modal {
            display: flex;
            gap: 15px;
            margin: 25px 0;
        }

        .btn-action {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-verify {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .btn-verify:hover,
        .btn-verify.active {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .btn-revise {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .btn-revise:hover,
        .btn-revise.active {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
        }

        /* Rating Section */
        .rating-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #eaeaea;
        }

        .rating-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rating-title i {
            color: var(--primary-color);
        }

        .rating-input-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .rating-label {
            font-weight: 600;
            color: var(--dark-color);
            min-width: 120px;
        }

        .rating-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .rating-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .rating-value {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            min-width: 40px;
            text-align: center;
        }

        /* Comments Section */
        .comments-section {
            margin-top: 20px;
        }

        .comments-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .comments-textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            resize: vertical;
            min-height: 100px;
            transition: all 0.3s ease;
        }

        .comments-textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        /* Modal Table Styles */
        .modal-table {
            margin-top: 20px;
        }

        .modal-table .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .modal-table th {
            background-color: #f8f9fa;
            color: var(--dark-color);
            font-weight: 600;
            border: none;
            padding: 12px 15px;
        }

        .modal-table td {
            padding: 12px 15px;
            border-color: #eaeaea;
        }

        .kegiatan-time {
            font-weight: 600;
            color: var(--primary-color);
        }

        .kegiatan-desc {
            color: var(--dark-color);
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

        /* Responsive */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .action-buttons-modal {
                flex-direction: column;
            }
            
            .rating-input-group {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .rating-label {
                min-width: auto;
                margin-bottom: 5px;
            }
            
            .rating-input {
                width: 100%;
            }
            
            .info-row {
                flex-direction: column;
                margin-bottom: 15px;
            }
            
            .info-label {
                min-width: auto;
                margin-bottom: 5px;
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
                        <h1 class="card-title"><i class="fas fa-clipboard-list me-2"></i> Daftar Laporan Harian Mahasiswa</h1>
                        <p class="card-text mb-0">Kelola dan nilai laporan harian kegiatan KKN mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="row mb-4">
            <div class="col-12">
                <ul class="nav nav-tabs" id="statusTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" 
                                type="button" role="tab" aria-controls="pending" aria-selected="true">
                            <i class="fas fa-clock me-2"></i>Menunggu Penilaian
                            <span class="badge bg-warning ms-2">{{ $statusCounts['draft'] ?? 0 }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviewed-tab" data-bs-toggle="tab" data-bs-target="#reviewed" 
                                type="button" role="tab" aria-controls="reviewed" aria-selected="false">
                            <i class="fas fa-check-circle me-2"></i>Sudah Dinilai
                            <span class="badge bg-success ms-2">{{ $statusCounts['dinilai'] ?? 0 }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="revised-tab" data-bs-toggle="tab" data-bs-target="#revised" 
                                type="button" role="tab" aria-controls="revised" aria-selected="false">
                            <i class="fas fa-redo me-2"></i>Perlu Revisi
                            <span class="badge bg-danger ms-2">{{ $statusCounts['direvisi'] ?? 0 }}</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="statusTabContent">
            <!-- Tab 1: Menunggu Penilaian -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="table-container">
                    <div class="table-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2 text-warning"></i>Laporan Menunggu Penilaian</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Kelompok</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Waktu Pengumpulan</th>
                                    <th>Jumlah Kegiatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allLogbooks->where('status', 'draft') as $index => $logbook)
                                    @php
                                        $kelompokName = $kelompokKkn->detailKelompok->first()->nama_kelompok ?? 'Tidak Ada Kelompok';
                                        $kegiatanCount = $logbook->detailLogbooks->count() ?? 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $logbook->anggota->mahasiswa->foto ?? 'https://via.placeholder.com/40' }}" 
                                                     alt="Student" 
                                                     class="rounded-circle me-2"
                                                     width="40"
                                                     height="40"
                                                     style="object-fit: cover;">
                                                {{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}</td>
                                        <td>{{ $kelompokName }}</td>
                                        <td>{{ $logbook->created_at->format('d M Y') }}</td>
                                        <td>{{ $logbook->created_at->format('H:i') }} WIB</td>
                                        <td>
                                            <span class="badge bg-info">{{ $kegiatanCount }} Kegiatan</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-primary btn-sm pre-btn" 
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#previewModal" 
                                                        data-logbook-id="{{ $logbook->id_logbook }}"
                                                        data-mahasiswa-name="{{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}"
                                                        data-mahasiswa-nim="{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}"
                                                        data-kelompok-name="{{ $kelompokName }}"
                                                        data-kegiatan="{{ json_encode($logbook->detailLogbooks ?? []) }}"
                                                        data-status="{{ $logbook->status }}"
                                                        data-tanggal-laporan="{{ $logbook->created_at->format('d M Y') }}"
                                                        data-waktu-pengumpulan="{{ $logbook->created_at->format('H:i') }}">
                                                    <i class="fas fa-edit me-1"></i> Nilai
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-clock"></i>
                                                <h5>Tidak Ada Laporan</h5>
                                                <p class="mb-0">Belum ada laporan yang menunggu penilaian</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Sudah Dinilai -->
            <div class="tab-pane fade" id="reviewed" role="tabpanel" aria-labelledby="reviewed-tab">
                <div class="table-container">
                    <div class="table-header">
                        <h5 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Laporan Sudah Dinilai</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Kelompok</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                    <th>Tanggal Dinilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allLogbooks->where('status', 'dinilai') as $index => $logbook)
                                    @php
                                        $kelompokName = $kelompokKkn->detailKelompok->first()->nama_kelompok ?? 'Tidak Ada Kelompok';
                                        $penilaian = $logbook->penilaian ?? null;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $logbook->anggota->mahasiswa->foto ?? 'https://via.placeholder.com/40' }}" 
                                                     alt="Student" 
                                                     class="rounded-circle me-2"
                                                     width="40"
                                                     height="40"
                                                     style="object-fit: cover;">
                                                {{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}</td>
                                        <td>{{ $kelompokName }}</td>
                                        <td>{{ $logbook->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($logbook->nilai)
                                                <span class="badge bg-success" style="font-size: 0.9rem;">
                                                    {{ $logbook->nilai }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-reviewed">Sudah Dinilai</span>
                                        </td>
                                        <td>
                                            @if($penilaian)
                                                {{ $penilaian->created_at->format('d M Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-primary btn-sm pre-btn" 
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#previewModal" 
                                                        data-logbook-id="{{ $logbook->id_logbook }}"
                                                        data-mahasiswa-name="{{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}"
                                                        data-mahasiswa-nim="{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}"
                                                        data-kelompok-name="{{ $kelompokName }}"
                                                        data-kegiatan="{{ json_encode($logbook->detailLogbooks ?? []) }}"
                                                        data-status="{{ $logbook->status }}"
                                                        data-tanggal-laporan="{{ $logbook->created_at->format('d M Y') }}"
                                                        data-waktu-pengumpulan="{{ $logbook->created_at->format('H:i') }}">
                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-check-circle"></i>
                                                <h5>Tidak Ada Laporan</h5>
                                                <p class="mb-0">Belum ada laporan yang sudah dinilai</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Perlu Revisi -->
            <div class="tab-pane fade" id="revised" role="tabpanel" aria-labelledby="revised-tab">
                <div class="table-container">
                    <div class="table-header">
                        <h5 class="mb-0"><i class="fas fa-redo me-2 text-danger"></i>Laporan Perlu Revisi</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Kelompok</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Komentar</th>
                                    <th>Status</th>
                                    <th>Tanggal Revisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allLogbooks->where('status', 'direvisi') as $index => $logbook)
                                    @php
                                        $kelompokName = $kelompokKkn->detailKelompok->first()->nama_kelompok ?? 'Tidak Ada Kelompok';
                                        $penilaian = $logbook->penilaian ?? null;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $logbook->anggota->mahasiswa->foto ?? 'https://via.placeholder.com/40' }}" 
                                                     alt="Student" 
                                                     class="rounded-circle me-2"
                                                     width="40"
                                                     height="40"
                                                     style="object-fit: cover;">
                                                {{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}</td>
                                        <td>{{ $kelompokName }}</td>
                                        <td>{{ $logbook->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($penilaian && $penilaian->komentar)
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                      title="{{ $penilaian->komentar }}">
                                                    {{ Str::limit($penilaian->komentar, 50) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Tidak ada komentar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-late">Perlu Revisi</span>
                                        </td>
                                        <td>
                                            @if($penilaian)
                                                {{ $penilaian->updated_at->format('d M Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-primary btn-sm pre-btn" 
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#previewModal" 
                                                        data-logbook-id="{{ $logbook->id_logbook }}"
                                                        data-mahasiswa-name="{{ $logbook->anggota->mahasiswa->name ?? 'N/A' }}"
                                                        data-mahasiswa-nim="{{ $logbook->anggota->mahasiswa->nim ?? 'N/A' }}"
                                                        data-kelompok-name="{{ $kelompokName }}"
                                                        data-kegiatan="{{ json_encode($logbook->detailLogbooks ?? []) }}"
                                                        data-status="{{ $logbook->status }}"
                                                        data-tanggal-laporan="{{ $logbook->created_at->format('d M Y') }}"
                                                        data-waktu-pengumpulan="{{ $logbook->created_at->format('H:i') }}">
                                                    <i class="fas fa-eye me-1"></i> Nilai
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-redo"></i>
                                                <h5>Tidak Ada Laporan</h5>
                                                <p class="mb-0">Belum ada laporan yang perlu revisi</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Preview -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="penilaianForm" method="POST" action="{{ route('nilai-logbook') }}">
                        @csrf
                        <input type="hidden" name="id_logbook" id="modalLogbookId">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">
                                <i class="fas fa-clipboard-check me-2"></i> Penilaian Laporan Harian
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Document Info -->
                            <div class="document-info">
                                <div class="info-row">
                                    <div class="info-label">Nama Mahasiswa:</div>
                                    <div class="info-value" id="modalMahasiswaName"></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">NIM:</div>
                                    <div class="info-value" id="modalMahasiswaNim"></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Kelompok:</div>
                                    <div class="info-value" id="modalKelompokName"></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tanggal Laporan:</div>
                                    <div class="info-value" id="modalTanggalLaporan"></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Waktu Pengumpulan:</div>
                                    <div class="info-value" id="modalWaktuPengumpulan"></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Status:</div>
                                    <div class="info-value">
                                        <span id="modalStatus" class="status-badge d-inline-block mt-1"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Table for Kegiatan -->
                            <div class="modal-table">
                                <h6 class="section-title mb-3">
                                    <i class="fas fa-tasks me-2"></i> Daftar Kegiatan Harian
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="kegiatanTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Waktu</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kegiatanTableBody">
                                            <!-- Kegiatan will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Buttons - Verify/Revisi -->
                            <div class="action-buttons-modal" id="actionButtonsSection">
                                <button type="button" class="btn-action btn-verify" id="btnVerify" data-action="dinilai">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Verifikasi Laporan</span>
                                </button>
                                <button type="button" class="btn-action btn-revise" id="btnRevisi" data-action="direvisi">
                                    <i class="fas fa-redo"></i>
                                    <span>Minta Revisi</span>
                                </button>
                            </div>
                            <input type="hidden" name="action" id="hiddenAction" value="">

                            <!-- Rating Section -->
                            <div class="rating-section" id="ratingSection">
                                <div class="rating-title">
                                    <i class="fas fa-star"></i>
                                    Penilaian Laporan
                                </div>
                                
                                <div class="rating-input-group">
                                    <label class="rating-label">Nilai (0-100):</label>
                                    <input type="number" 
                                           class="rating-input" 
                                           id="ratingValue" 
                                           name="nilai"
                                           min="0" 
                                           max="100" 
                                           step="1"
                                           placeholder="Masukkan nilai (0-100)"
                                           required>
                                    <span class="rating-value" id="ratingDisplay">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitRating">
                                <i class="fas fa-paper-plane me-2"></i>Simpan Penilaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabEls.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (event) {
                    // Handle tab switch if needed
                });
            });

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
        });

        $(document).ready(function() {
            // Button click untuk preview
            $(document).on('click', '.pre-btn', function() {
                const logbookId = $(this).data('logbook-id');
                const mahasiswaName = $(this).data('mahasiswa-name');
                const mahasiswaNim = $(this).data('mahasiswa-nim');
                const kelompokName = $(this).data('kelompok-name');
                const kegiatanData = $(this).data('kegiatan');
                const status = $(this).data('status');
                const tanggalLaporan = $(this).data('tanggal-laporan');
                const waktuPengumpulan = $(this).data('waktu-pengumpulan');

                // Set modal data
                $('#previewModal .modal-title').html(`<i class="fas fa-clipboard-check me-2"></i>Penilaian Laporan - ${mahasiswaName}`);
                $('#modalMahasiswaName').text(mahasiswaName);
                $('#modalMahasiswaNim').text(mahasiswaNim);
                $('#modalKelompokName').text(kelompokName);
                $('#modalTanggalLaporan').text(tanggalLaporan);
                $('#modalWaktuPengumpulan').text(waktuPengumpulan);
                $('#modalLogbookId').val(logbookId);
                
                // Set status badge
                const statusBadge = $('#modalStatus');
                statusBadge.text(status.charAt(0).toUpperCase() + status.slice(1));
                statusBadge.removeClass('status-pending status-reviewed status-late');
                
                if (status === 'dinilai' || status === 'verified') {
                    statusBadge.addClass('status-reviewed');
                } else if (status === 'draft' || status === 'pending') {
                    statusBadge.addClass('status-pending');
                } else if (status === 'direvisi' || status === 'rejected') {
                    statusBadge.addClass('status-late');
                }

                // Show/hide action buttons and rating section based on status
                if (status === 'dinilai') {
                    $('#actionButtonsSection').hide();
                    $('#ratingSection').hide();
                } else {
                    $('#actionButtonsSection').show();
                    $('#ratingSection').show();
                    
                    // Reset buttons
                    $('#btnVerify').removeClass('active');
                    $('#btnRevisi').removeClass('active');
                    $('#hiddenAction').val('');
                    
                    // Set initial button state based on status
                    if (status === 'dinilai' || status === 'verified') {
                        $('#btnVerify').addClass('active');
                        $('#hiddenAction').val('dinilai');
                    } else if (status === 'direvisi') {
                        $('#btnRevisi').addClass('active');
                        $('#hiddenAction').val('direvisi');
                    }
                }

                // Reset form
                $('#ratingValue').val('');
                $('#ratingDisplay').text('-');
                $('#comments').val('');

                // Handle kegiatan data in table
                const kegiatanTableBody = $('#kegiatanTableBody');
                kegiatanTableBody.empty();
                
                if (kegiatanData && Array.isArray(kegiatanData) && kegiatanData.length > 0) {
                    $.each(kegiatanData, function(index, item) {
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    <div class="kegiatan-time">
                                        <i class="fas fa-briefcase me-1"></i>${item.nama_kegiatan || '-'}
                                    </div>
                                </td>
                                <td>
                                    <div class="kegiatan-time">
                                        <i class="far fa-clock me-1"></i>${item.jumlah_waktu || '-'}
                                    </div>
                                </td>
                                <td>
                                    <div class="kegiatan-desc">
                                        ${item.deskripsi_kegiatan || '-'}
                                    </div>
                                </td>
                            </tr>
                        `;
                        kegiatanTableBody.append(row);
                    });
                } else {
                    kegiatanTableBody.html(`
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Tidak ada data kegiatan</p>
                            </td>
                        </tr>
                    `);
                }
            });

            // Tombol Nilai langsung
            $(document).on('click', '.nilai-btn', function() {
                const logbookId = $(this).data('logbook-id');
                
                // Cari data dari row table
                const row = $(this).closest('tr');
                const mahasiswaName = row.find('td:nth-child(2)').text().trim();
                const mahasiswaNim = row.find('td:nth-child(3)').text().trim();
                const kelompokName = row.find('td:nth-child(4)').text().trim();
                const tanggalLaporan = row.find('td:nth-child(5)').text().trim();
                
                // Set data untuk modal
                $('#modalMahasiswaName').text(mahasiswaName);
                $('#modalMahasiswaNim').text(mahasiswaNim);
                $('#modalKelompokName').text(kelompokName);
                $('#modalTanggalLaporan').text(tanggalLaporan);
                $('#modalWaktuPengumpulan').text('-');
                $('#modalStatus').text('Menunggu Penilaian').addClass('status-pending');
                $('#modalLogbookId').val(logbookId);
                
                // Show action buttons and rating section
                $('#actionButtonsSection').show();
                $('#ratingSection').show();
                
                // Reset form
                $('#btnVerify').removeClass('active');
                $('#btnRevisi').removeClass('active');
                $('#hiddenAction').val('');
                $('#ratingValue').val('');
                $('#ratingDisplay').text('-');
                $('#comments').val('');
                
                // Load kegiatan data via AJAX
                loadKegiatanData(logbookId);
                
                // Tampilkan modal
                $('#previewModal').modal('show');
            });

            function loadKegiatanData(logbookId) {
                $.ajax({
                    url: '/dosen/logbook/' + logbookId + '/kegiatan',
                    method: 'GET',
                    beforeSend: function() {
                        $('#kegiatanTableBody').html(`
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2">Memuat data kegiatan...</p>
                                </td>
                            </tr>
                        `);
                    },
                    success: function(response) {
                        const kegiatanTableBody = $('#kegiatanTableBody');
                        kegiatanTableBody.empty();
                        
                        if (response.data && response.data.length > 0) {
                            $.each(response.data, function(index, item) {
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>
                                            <div class="kegiatan-time">
                                                <i class="fas fa-briefcase me-1"></i>${item.nama_kegiatan || '-'}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="kegiatan-time">
                                                <i class="far fa-clock me-1"></i>${item.jumlah_waktu || '-'}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="kegiatan-desc">
                                                ${item.deskripsi_kegiatan || '-'}
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                kegiatanTableBody.append(row);
                            });
                        } else {
                            kegiatanTableBody.html(`
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada data kegiatan</p>
                                    </td>
                                </tr>
                            `);
                        }
                    },
                    error: function() {
                        $('#kegiatanTableBody').html(`
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                                    <p class="text-danger mb-0">Gagal memuat data kegiatan</p>
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            // Button Verify/Revisi functionality
            $('#btnVerify').click(function() {
                $(this).addClass('active');
                $('#btnRevisi').removeClass('active');
                $('#hiddenAction').val('dinilai');
            });

            $('#btnRevisi').click(function() {
                $(this).addClass('active');
                $('#btnVerify').removeClass('active');
                $('#hiddenAction').val('direvisi');
            });

            // Update rating display
            $('#ratingValue').on('input', function() {
                let value = $(this).val();
                
                // Validate range
                if (value > 100) {
                    value = 100;
                    $(this).val(100);
                } else if (value < 0) {
                    value = 0;
                    $(this).val(0);
                }
                
                $('#ratingDisplay').text(value || '-');
                
                // Color coding based on value
                const ratingDisplay = $('#ratingDisplay');
                ratingDisplay.removeClass('text-danger text-warning text-success');
                
                if (value >= 80) {
                    ratingDisplay.addClass('text-success');
                } else if (value >= 60) {
                    ratingDisplay.addClass('text-warning');
                } else if (value > 0) {
                    ratingDisplay.addClass('text-danger');
                }
            });

            // Form submission
            $('#penilaianForm').submit(function(e) {
                e.preventDefault();
                
                const action = $('#hiddenAction').val();
                const rating = $('#ratingValue').val();
                const comments = $('#comments').val();
                const logbookId = $('#modalLogbookId').val();

                if (!action) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilihan Belum Dipilih',
                        text: 'Silakan pilih Verifikasi atau Revisi terlebih dahulu',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                if (!rating || rating < 0 || rating > 100) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Nilai Tidak Valid',
                        text: 'Silakan masukkan nilai antara 0-100',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                // Show confirmation
                Swal.fire({
                    title: 'Konfirmasi Penilaian',
                    html: `
                        <div class="text-start">
                            <p>Apakah Anda yakin ingin menyimpan penilaian?</p>
                            <p><strong>Aksi:</strong> ${action === 'verify' ? 'Verifikasi' : 'Minta Revisi'}</p>
                            <p><strong>Nilai:</strong> ${rating}</p>
                            ${comments ? `<p><strong>Komentar:</strong> ${comments.substring(0, 100)}${comments.length > 100 ? '...' : ''}</p>` : ''}
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Sedang menyimpan penilaian',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // AJAX submission
                        $.ajax({
                            url: $(this).attr('action'),
                            method: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Penilaian berhasil disimpan',
                                    confirmButtonColor: '#3085d6',
                                }).then(() => {
                                    $('#previewModal').modal('hide');
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan',
                                    confirmButtonColor: '#3085d6',
                                });
                            }
                        });
                    }
                });
            });

            // Keyboard shortcuts
            $(document).keydown(function(e) {
                if ($('#previewModal').hasClass('show')) {
                    // Escape to close modal
                    if (e.key === 'Escape') {
                        $('#previewModal').modal('hide');
                    }
                    // Ctrl+Enter to submit
                    if (e.ctrlKey && e.key === 'Enter') {
                        $('#submitRating').click();
                    }
                    // 1 for verify, 2 for revise
                    if (e.key === '1') {
                        $('#btnVerify').click();
                    }
                    if (e.key === '2') {
                        $('#btnRevisi').click();
                    }
                }
            });
        });
    </script>
@endsection