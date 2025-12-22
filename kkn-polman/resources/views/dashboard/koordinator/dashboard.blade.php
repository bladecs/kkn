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

        /* Recent Activity */
        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.3s ease;
        }

        .activity-item:hover {
            background-color: #f8f9fa;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .activity-icon.primary {
            background: rgba(30, 79, 190, 0.1);
            color: var(--primary-color);
        }

        .activity-icon.success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .activity-icon.warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .activity-icon.info {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .activity-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #adb5bd;
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
@endsection