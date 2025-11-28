@extends('dashboard.mahasiswa.layouts.app')

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

        .phase-step.complete:not(:last-child)::after {
            opacity: 1;
            background: linear-gradient(90deg, rgb(87, 255, 87) 0%, green 100%);
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

        .phase-step.complete .phase-indicator-circle {
            background: linear-gradient(135deg, rgb(87, 255, 87) 0%, #34ce57 100%);
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
            max-width: 120px;
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

    <!-- Modern Phase Indicator -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Status KKN</h5>
                    <div class="phase-indicator">
                        <div class="phase-steps">
                            <!-- Pendaftaran -->
                            <div class="phase-step" data-phase="pendaftaran">
                                <div class="phase-indicator-circle">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="phase-label">Pendaftaran</div>
                                <div class="phase-status">Menunggu</div>
                            </div>
                            <!-- Pengelompokan-->
                            <div class="phase-step" data-phase="penerjunan">
                                <div class="phase-indicator-circle">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <div class="phase-label">Pengelompokan</div>
                                <div class="phase-status">Menunggu</div>
                            </div>
                            <!-- Pelaksanaan -->
                            <div class="phase-step" data-phase="pelaksanaan">
                                <div class="phase-indicator-circle">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="phase-label">Pelaksanaan</div>
                                <div class="phase-status">Menunggu</div>
                            </div>
                            <!-- Pelaporan -->
                            <div class="phase-step" data-phase="pelaporan">
                                <div class="phase-indicator-circle">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="phase-label">Pelaporan</div>
                                <div class="phase-status">Menunggu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="d-flex flex-grow gap-4 justify-content-between">
        <!-- Tahap Persiapan -->
        <div class="flex-fill mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-clipboard-list section-icon"></i>
                        <h5 class="section-title">Tahap Persiapan</h5>
                    </div>

                    <a href="{{ route('formulir') }}" class="menu-item"
                        @if ($status_pendaftaran) onclick="return false;" style="pointer-events: none; opacity: 0.8;" @endif>
                        <i class="fas fa-file-medical"></i>
                        <span>{{ $status_pendaftaran ? 'Sudah Mendaftar' : 'Formulir Pendaftaran' }}</span>
                    </a>

                    <a href="{{ route('data-diri') }}" class="menu-item">
                        <i class="fas fa-id-card"></i>
                        <span>Data Diri</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tahap Pelaporan -->
        <div class="flex-fill mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="section-header">
                        <i class="fas fa-file-alt section-icon"></i>
                        <h5 class="section-title">Pelaporan & Evaluasi</h5>
                    </div>
                    <a href="{{ route('pelaporan-harian') }}" class="menu-item">
                        <i class="fas fa-file-invoice"></i>
                        <span>Laporan Harian</span>
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-file-contract"></i>
                        <span>Laporan Akhir</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional content to enable scrolling -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Tambahan</h5>
                    <p>Berikut adalah beberapa informasi tambahan untuk mengisi konten halaman:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Jadwal Penting</h6>
                            <ul class="list-group">
                                <li class="list-group-item">Pendaftaran KKN: 1 Januari - 31 Januari 2023</li>
                                <li class="list-group-item">Pembekalan: 15 Februari 2023</li>
                                <li class="list-group-item">Penerjunan: 1 Maret 2023</li>
                                <li class="list-group-item">Pelaksanaan: 1 Maret - 30 Juni 2023</li>
                                <li class="list-group-item">Pelaporan: 1 Juli - 15 Juli 2023</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Pengumuman Terbaru</h6>
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Panduan KKN 2023</h6>
                                        <small>3 hari yang lalu</small>
                                    </div>
                                    <p class="mb-1">Panduan lengkap KKN tahun 2023 telah tersedia.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pembagian Kelompok</h6>
                                        <small>1 minggu yang lalu</small>
                                    </div>
                                    <p class="mb-1">Pembagian kelompok KKN telah diumumkan.</p>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Seminar KKN</h6>
                                        <small>2 minggu yang lalu</small>
                                    </div>
                                    <p class="mb-1">Jadwal seminar hasil KKN telah ditetapkan.</p>
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
        const statusPendaftaran = @json($status_pendaftaran ?? '-');
        const statusProject = @json($status_project ?? '-');

        (function() {
            const el = document.querySelector('.phase-step[data-phase="pendaftaran"]');
            if (!el) return;

            el.classList.remove('complete', 'active');

            function setStatus(el, statusClass, text) {
                el.classList.add(statusClass);
                const statusEl = el.querySelector('.phase-status');
                if (statusEl) {
                    statusEl.className = 'phase-status ' +
                        (statusClass === 'complete' ? 'status-completed' :
                            (statusClass === 'active' ? 'status-active' : 'status-pending'));
                    statusEl.textContent = text;
                }
            }

            const s = (statusPendaftaran || '').toLowerCase().trim();

            if (['complete', 'selesai', 'done'].includes(s)) {
                setStatus(el, 'complete', 'Selesai');
            } else if (['active', 'berjalan', 'ongoing', 'verifikasi'].includes(s)) {
                setStatus(el, 'active', 'Berjalan');
            } else {
                setStatus(el, '', 'Menunggu');
            }
        })();
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
