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

        /* Modern Progress Indicator Styles */
        .phase-indicator {
            padding: 20px 0;
        }

        .phase-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 30px 0;
        }

        .phase-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            z-index: 1;
        }

        .phase-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .phase-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 6px;
            background-color: var(--primary-color);
            z-index: 2;
            transform: translateY(-50%);
            transition: all 0.5s ease;
            opacity: 0;
        }

        .phase-step.completed:not(:last-child)::after {
            opacity: 1;
            background: linear-gradient(90deg, var(--success-color) 0%, var(--success-color) 100%);
        }

        .phase-step.active:not(:last-child)::after {
            opacity: 1;
            background: linear-gradient(90deg, var(--success-color) 0%, var(--primary-color) 50%, #e9ecef 100%);
        }

        .phase-indicator-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 3;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 1.1rem;
            color: #6c757d;
        }

        .phase-step.completed .phase-indicator-circle {
            background: linear-gradient(135deg, var(--success-color) 0%, #34ce57 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .phase-step.active .phase-indicator-circle {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4d8aff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 79, 190, 0.4);
            transform: scale(1.1);
        }

        .phase-label {
            font-size: 0.85rem;
            text-align: center;
            max-width: 100px;
            margin-top: 5px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .phase-step.completed .phase-label {
            color: var(--success-color);
            font-weight: 600;
        }

        .phase-step.active .phase-label {
            color: var(--primary-color);
            font-weight: 700;
        }

        .phase-date {
            font-size: 0.75rem;
            color: #adb5bd;
            margin-top: 5px;
            text-align: center;
        }

        .phase-status {
            margin-top: 10px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(52, 206, 87, 0.15) 100%);
            color: var(--success-color);
        }

        .status-active {
            background: linear-gradient(135deg, rgba(30, 79, 190, 0.15) 0%, rgba(77, 138, 255, 0.15) 100%);
            color: var(--primary-color);
        }

        .status-pending {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
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

        @media (max-width: 768px) {
            .phase-steps {
                flex-wrap: wrap;
            }

            .phase-step {
                margin-bottom: 15px;
                flex: 1;
                min-width: 120px;
            }

            .phase-step:not(:last-child)::after {
                display: none;
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-number">{{ $daily_pendaftaran ?? 0 }}</div>
                    <div class="stat-label">Jumlah Pendaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-clock stat-icon" style="color: var(--warning-color);"></i>
                    <div class="stat-number">{{ $count_not_verif ?? 0 }}</div>
                    <div class="stat-label">Belum Diverifikasi</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-tasks stat-icon" style="color: var(--info-color);"></i>
                    <div class="stat-number">{{ $project_belum_diperiksa ?? 0 }}</div>
                    <div class="stat-label">Project Belum Diperiksa</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <i class="fas fa-chart-line stat-icon" style="color: var(--success-color);"></i>
                    <div class="stat-number">{{ $count_pendaftaran  ?? 0 }}</div>
                    <div class="stat-label">Total Pendaftaran</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart and Timeline Row -->
    <div class="row mb-4">
        <!-- Chart -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-chart-bar section-icon"></i>
                        <h5 class="section-title">Statistik Pendaftaran Harian</h5>
                    </div>
                    <div class="chart-container">
                        <canvas id="pendaftaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Coordinator Activity Timeline -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-history section-icon"></i>
                        <h5 class="section-title">Aktivitas Terbaru Koordinator</h5>
                    </div>
                    <div class="activity-timeline">
                        @if(isset($aktivitas_koordinator) && count($aktivitas_koordinator) > 0)
                            @foreach($aktivitas_koordinator as $aktivitas)
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('pendaftaranChart').getContext('2d');
            
            const chartData = {
                labels: @json($data['chart_labels']),
                datasets: [{
                    label: 'Jumlah Pendaftaran',
                    data: @json($data['chart_data']),
                    backgroundColor: 'rgba(30, 79, 190, 0.2)',
                    borderColor: 'rgba(30, 79, 190, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            };
            
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 5
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            };
            
            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: chartOptions
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