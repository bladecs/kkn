@extends('dashboard.dosen.layouts.app')

@section('title', 'Dashboard Dosen - Sistem Informasi KKN')

@section('style')
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            margin-bottom: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, #3a57e8 0%, #2a46d8 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-header h5 i {
            margin-right: 10px;
        }

        .stat-card {
            text-align: center;
            padding: 25px 15px;
            border-radius: 12px;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #6a11cb);
        }

        .stat-icon {
            font-size: 2.8rem;
            margin-bottom: 15px;
            color: var(--primary-color);
            opacity: 0.9;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-action-card {
            height: 100%;
            border-left: 4px solid var(--primary-color);
        }

        .quick-action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), #6a11cb);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: white;
            font-size: 1.3rem;
        }

        .quick-action-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .quick-action-desc {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .btn-action {
            background: linear-gradient(135deg, var(--primary-color), #2a46d8);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 87, 232, 0.3);
            color: white;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid #e9ecef;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-waiting {
            background-color: rgba(255, 193, 7, 0.15);
            color: #b58a00;
        }

        .badge-review {
            background-color: rgba(23, 162, 184, 0.15);
            color: #0c5460;
        }

        .badge-approved {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-color);
        }



        .badge-rejected {
            background-color: rgba(220, 53, 69, 0.15);
            color: var(--danger-color);
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary-color), #6a11cb);
            border-radius: 4px;
        }

        .notification-item {
            padding: 12px 15px;
            border-left: 3px solid transparent;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
            border-left-color: var(--primary-color);
        }

        .notification-item.unread {
            background-color: rgba(58, 87, 232, 0.05);
        }

        .notification-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #6a11cb);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 15px;
        }

        .recent-activity-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .recent-activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(58, 87, 232, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 2px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .filter-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .filter-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .filter-badge {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-badge:hover {
            transform: translateY(-2px);
        }

        .filter-badge.active {
            background: linear-gradient(135deg, var(--primary-color), #6a11cb);
            color: white;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #e9ecef;
            margin-bottom: 20px;
        }

        .empty-state-title {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .btn-view-all {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 6px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-view-all:hover {
            background-color: var(--primary-color);
            color: white;
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="card-title mb-2"><i class="fas fa-chalkboard-teacher me-2"></i> Dashboard Dosen
                                Pembimbing KKN</h1>
                            <p class="card-text mb-0">Selamat datang, {{ Auth::user()->name ?? 'Dosen' }}</p>
                        </div>
                        <div class="text-end">
                            <h4 class="mb-0">Periode KKN {{ date('Y') }}</h4>
                            <p class="mb-0">Semester Genap</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-project-diagram stat-icon"></i>
                <div class="stat-number">{{ $projects->count() }}</div>
                <div class="stat-label">Total Project</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-number">{{ $kelompokKkn ? $kelompokKkn->anggotaKelompok->count() : 0 }}</div>
                <div class="stat-label">Mahasiswa Bimbingan</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-book-open stat-icon"></i>
                <div class="stat-number">{{ $projects->sum(function ($project) {return $project->logbooks->count();}) }}
                </div>
                <div class="stat-label">Logbook Harian</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <i class="fas fa-file-signature stat-icon"></i>
                <div class="stat-number">
                    {{ $projects->sum(function ($project) {return $project->laporanAkhir->count();}) }}</div>
                <div class="stat-label">Laporan Menunggu</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-bolt me-2"></i> Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card quick-action-card h-100">
                                <div class="card-body">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-list-check"></i>
                                    </div>
                                    <h5 class="quick-action-title">Daftar Project</h5>
                                    <p class="quick-action-desc">Kelola daftar project KKN yang sedang berjalan dan selesai
                                    </p>
                                    <a href="{{ route('form-pengajuan-kkn-dosen') }}" class="btn btn-action">
                                        <i class="fas fa-arrow-right me-1"></i> Akses
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card quick-action-card h-100">
                                <div class="card-body">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h5 class="quick-action-title">Monitoring Logbook</h5>
                                    <p class="quick-action-desc">Pantau logbook harian mahasiswa bimbingan Anda</p>
                                    <a href="" class="btn btn-action">
                                        <i class="fas fa-arrow-right me-1"></i> Akses
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card quick-action-card h-100">
                                <div class="card-body">
                                    <div class="quick-action-icon">
                                        <i class="fas fa-circle-check"></i>
                                    </div>
                                    <h5 class="quick-action-title">Penilaian Laporan</h5>
                                    <p class="quick-action-desc">Berikan penilaian untuk laporan akhir mahasiswa</p>
                                    <a href="" class="btn btn-action">
                                        <i class="fas fa-arrow-right me-1"></i> Akses
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Project & Logbook Terbaru -->
    <div class="row mb-4">
        <!-- Daftar Project -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-project-diagram me-2"></i> Daftar Project Terbaru</h5>
                    <a href="" class="btn btn-view-all btn-sm">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if ($projects && count($projects) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Project</th>
                                        <th>Kelompok</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>
                                                <strong>{{ $project->judul }}</strong><br>
                                                <small
                                                    class="text-muted">{{ Str::limit($project->deskripsi, 40) }}</small>
                                            </td>
                                            <td>{{ $project->kelompok ?? '-'}}</td>
                                            <td>{{ $project->lokasi->nama_lokasi }}</td>
                                            <td>
                                                @if($project->status == 'complete')
                                                    <span class="badge badge-approved">Selesai</span>
                                                @else
                                                    <span class="badge badge-waiting">Perencanaan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-project-diagram empty-state-icon"></i>
                            <h5 class="empty-state-title">Belum ada project</h5>
                            <p>Belum ada project KKN yang ditugaskan kepada Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Logbook Terbaru -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-book-open me-2"></i> Logbook Terbaru</h5>
                    <a href="" class="btn btn-view-all btn-sm">
                        Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if ($allLogbooks && count($allLogbooks) > 0)
                        @foreach ($allLogbooks as $logbook)
                            <div class="recent-activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $logbook->mahasiswa->name ?? 'Mahasiswa' }}</div>
                                    <p class="mb-1" style="font-size: 0.9rem;">{{ Str::limit($logbook->kegiatan, 50) }}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <span class="activity-time">{{ $logbook->created_at->format('d M Y') }}</span>
                                        @if ($logbook->status == 'unread')
                                            <span class="badge badge-waiting">Baru</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-book-open empty-state-icon"></i>
                            <h5 class="empty-state-title">Belum ada logbook</h5>
                            <p>Belum ada logbook yang dikirim oleh mahasiswa.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Penilaian Menunggu & Notifikasi -->
    <div class="row mb-4">
        <!-- Laporan Menunggu Penilaian -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-file-circle-check me-2"></i> Laporan Menunggu Penilaian</h5>
                    <span class="badge badge-danger">{{ $laporanMenunggu->count() }} Baru</span>
                </div>
                <div class="card-body">
                    @if ($laporanMenunggu && count($laporanMenunggu) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mahasiswa</th>
                                        <th>Judul Laporan</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanMenunggu as $laporan)
                                        <tr>
                                            <td>{{ $laporan->mahasiswa->name ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($laporan->judul, 30) }}</td>
                                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($laporan->status == 'submitted')
                                                    <span class="badge badge-review">Menunggu</span>
                                                @elseif($laporan->status == 'reviewed')
                                                    <span class="badge badge-waiting">Ditinjau</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $laporan->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit me-1"></i> Nilai
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-check-circle empty-state-icon"></i>
                            <h5 class="empty-state-title">Semua laporan telah dinilai</h5>
                            <p>Tidak ada laporan yang menunggu penilaian.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Grafik Progress -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i> Statistik Progress Project</h5>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="filter-container">
                        <div class="filter-title">Filter berdasarkan status:</div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge filter-badge active" data-filter="all">Semua</span>
                            <span class="badge filter-badge" data-filter="active">Aktif</span>
                            <span class="badge filter-badge" data-filter="completed">Selesai</span>
                            <span class="badge filter-badge" data-filter="pending">Perencanaan</span>
                        </div>
                    </div>

                    <!-- Grafik -->
                    <div class="chart-container">
                        <canvas id="projectProgressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inisialisasi Chart
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk chart
            const ctx = document.getElementById('projectProgressChart').getContext('2d');

            const projectProgressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags'],
                    datasets: [{
                        label: 'Project Aktif',
                        data: [2, 4, 6, 8, 10, 12, 10, 8],
                        backgroundColor: 'rgba(58, 87, 232, 0.7)',
                        borderColor: 'rgba(58, 87, 232, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Project Selesai',
                        data: [0, 0, 1, 2, 4, 6, 8, 10],
                        backgroundColor: 'rgba(26, 160, 83, 0.7)',
                        borderColor: 'rgba(26, 160, 83, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Project'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });

            // Filter functionality
            document.querySelectorAll('.filter-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    // Remove active class from all badges
                    document.querySelectorAll('.filter-badge').forEach(b => {
                        b.classList.remove('active');
                    });

                    // Add active class to clicked badge
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.getAttribute('data-filter');

                    // Here you would normally filter the data
                    console.log('Filter by:', filter);

                    // For demo, we'll just show an alert
                    // In real implementation, you would filter the table/chart data
                    if (filter !== 'all') {
                        // Simulate filtering
                        showFilteredData(filter);
                    }
                });
            });

            function showFilteredData(filter) {
                // This is where you would implement actual filtering
                // For now, we'll just log to console
                console.log(`Filtering projects by: ${filter}`);

                // You would typically make an AJAX call here or filter client-side data
            }

            // Auto-dismiss alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(alert => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Sample data for the dashboard
        // In a real application, this data would come from the controller
        const sampleProjects = [{
                id: 1,
                nama: "Pengembangan Sistem Informasi Desa",
                deskripsi: "Membangun sistem informasi untuk administrasi desa",
                kelompok: "Kelompok 1",
                lokasi: "Desa Sukamaju",
                status: "active",
                progress: 65
            },
            {
                id: 2,
                nama: "Program Literasi Digital",
                deskripsi: "Pelatihan penggunaan teknologi untuk masyarakat",
                kelompok: "Kelompok 3",
                lokasi: "Desa Harapan Baru",
                status: "active",
                progress: 45
            },
            {
                id: 3,
                nama: "Pengolahan Sampah Organik",
                deskripsi: "Program daur ulang sampah menjadi pupuk",
                kelompok: "Kelompok 5",
                lokasi: "Desa Sejahtera",
                status: "completed",
                progress: 100
            }
        ];

        const sampleLogbooks = [{
                mahasiswa: {
                    name: "Ahmad Rizki"
                },
                kegiatan: "Survey lokasi dan wawancara dengan perangkat desa",
                tanggal: new Date(),
                status: "unread"
            },
            {
                mahasiswa: {
                    name: "Siti Aminah"
                },
                kegiatan: "Persiapan materi pelatihan digital untuk ibu-ibu PKK",
                tanggal: new Date(Date.now() - 86400000),
                status: "read"
            }
        ];

        const sampleNotifications = [{
                title: "Logbook Baru",
                message: "Ahmad Rizki mengirim logbook harian",
                time: "2 jam yang lalu",
                type: "logbook",
                unread: true
            },
            {
                title: "Laporan Dikirim",
                message: "Siti Aminah mengirim laporan akhir",
                time: "1 hari yang lalu",
                type: "laporan",
                unread: true
            }
        ];
    </script>
@endsection
