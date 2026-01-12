@extends('dashboard.koordinator.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN - Buat Schema')

@section('style')
    <style>
        .schema-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
            width: 100%;
        }

        .schema-header {
            background: linear-gradient(135deg, var(--primary-color), #3b71ca);
            border-radius: var(--border-radius);
            padding: 40px;
            margin-bottom: 30px;
            color: white;
            text-align: center;
            box-shadow: var(--box-shadow);
        }

        .schema-header h1 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2.2rem;
        }

        .schema-header p {
            opacity: 0.9;
            margin-bottom: 0;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .schema-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            width: 100%;
        }

        .schema-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--light-color);
            display: flex;
            align-items: center;
            font-size: 1.5rem;
        }

        .card-title i {
            margin-right: 12px;
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
            font-size: 1rem;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.15);
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            z-index: 5;
            pointer-events: none;
            font-size: 1.1rem;
        }

        .input-with-icon {
            padding-left: 50px;
            padding-right: 18px;
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 14px 35px;
            font-weight: 600;
            transition: var(--transition);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .btn-primary-custom:hover {
            background: #1a3ea5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 79, 190, 0.3);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 14px 30px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .schema-actions {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 20px;
            font-size: 1rem;
        }

        .alert-info {
            background-color: #e7f3ff;
            color: #004085;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.9rem;
            margin-top: 6px;
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

        .kategori-info {
            background: var(--light-color);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .kategori-info h6 {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
        }

        .kategori-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .kategori-item {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
            cursor: pointer;
        }

        .kategori-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .kategori-item.selected {
            background: white;
            border-left-color: #28a745;
        }

        .kategori-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .kategori-desc {
            font-size: 0.9rem;
            color: var(--secondary-color);
            line-height: 1.4;
        }

        .calendar-preview {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-top: 25px;
            border: 1px solid #e2e8f0;
            width: 100%;
        }

        .calendar-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-preview-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            font-size: 1.1rem;
        }

        .calendar-mini {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .calendar-mini-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            border: 1px solid #e2e8f0;
            min-height: 35px;
            position: relative;
        }

        .calendar-mini-day.selected {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            font-weight: 600;
        }

        .calendar-mini-day.outside {
            background: #f8f9fa;
            color: #ccc;
        }

        .calendar-mini-day.unavailable {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border-color: #f5c6cb !important;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .calendar-mini-day.unavailable:hover::after {
            content: 'Tanggal sudah digunakan';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1000;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-full-width {
            grid-column: 1 / -1;
        }

        /* Existing schemas styles */
        .existing-schemas-container {
            margin-top: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .existing-schemas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-color);
        }

        .existing-schemas-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            font-size: 1.3rem;
        }

        .schemas-count-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .schemas-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .no-schemas {
            text-align: center;
            padding: 40px 20px;
            color: var(--secondary-color);
        }

        .no-schemas i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .schemas-loading {
            text-align: center;
            padding: 30px;
            color: var(--secondary-color);
        }

        .schemas-loading .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        /* Status badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-upcoming {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #e2e3e5;
            color: #383d41;
        }

        /* Loading states */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .kategori-loading {
            text-align: center;
            padding: 30px;
            color: var(--secondary-color);
        }

        /* Badge styles */
        .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.65em;
        }

        /* Selected kloter highlight */
        .selected-kloter-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            animation: slideInDown 0.5s ease-out;
        }

        .selected-kloter-info h6 {
            color: white;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        /* Warning states */
        .is-warning {
            border-color: #ffc107 !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25) !important;
        }

        /* Style untuk date input yang invalid */
        input[type="date"]:invalid {
            border-color: #f8d7da;
        }

        input[type="date"].is-invalid {
            border-color: #f8d7da;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.4.4.4-.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .date-conflict-alert {
            animation: shake 0.5s ease-in-out;
        }

        /* Style untuk tombol aksi */
        .btn-group-sm>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .btn-outline-primary,
        .btn-outline-danger {
            border-width: 1px;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-outline-danger:hover {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            color: white;
        }

        /* Hover effects untuk tombol aksi */
        .btn-group .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Modal styles */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), #3b71ca);
            color: white;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 20px;
        }

        /* SweetAlert2 custom styles */
        .swal2-popup {
            border-radius: 15px;
            padding: 2rem;
        }

        .swal2-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .swal2-html-container {
            font-size: 1rem;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation for form elements */
        .form-control,
        .form-select,
        .kategori-item,
        .kloter-card {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-hint {
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin-top: 5px;
            display: block;
        }

        .date-input-hint {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 992px) {
            .schema-container {
                max-width: 100%;
                padding: 20px 15px;
            }

            .schema-card {
                padding: 30px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .kloter-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .schema-header {
                padding: 30px 20px;
            }

            .schema-header h1 {
                font-size: 1.8rem;
            }

            .schema-card {
                padding: 25px;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .schema-actions {
                flex-direction: column;
                gap: 15px;
                padding: 25px;
            }

            .schema-actions .btn {
                width: 100%;
            }

            .kategori-list {
                grid-template-columns: 1fr;
            }

            .calendar-mini {
                gap: 4px;
            }

            .calendar-mini-day {
                font-size: 0.8rem;
                min-height: 30px;
            }
        }

        @media (max-width: 576px) {
            .schema-container {
                padding: 15px 10px;
            }

            .schema-card {
                padding: 20px;
            }

            .schema-header {
                padding: 25px 15px;
            }

            .schema-header h1 {
                font-size: 1.5rem;
            }

            .schema-header p {
                font-size: 1rem;
            }

            .form-control,
            .form-select {
                padding: 12px 15px;
            }

            .btn-primary-custom,
            .btn-outline-secondary {
                padding: 12px 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="schema-container">
            @if (session('success'))
                <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
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
            <div class="schema-header">
                <h1><i class="fas fa-project-diagram me-2"></i> Buat Schema KKN Baru</h1>
                <p>Buat schema kegiatan KKN dalam periode schedule yang telah ditentukan</p>
            </div>

            <!-- Form Schema -->
            <form class="schema-card" id="schema-form" method="POST" action="{{ route('submit_schema') }}">
                @csrf
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                <input type="hidden" name="schedule_id" id="schedule_id" value="{{ old('schedule_id') }}">

                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Pilih Kloter</h3>

                <!-- Informasi Kloter yang Dipilih -->
                <div class="selected-kloter-info" id="selected-kloter-info" style="display: none;">
                    <h6><i class="fas fa-check-circle me-2"></i>Kloter Terpilih</h6>
                    <div id="selected-kloter-details"></div>
                </div>

                <!-- Daftar Kloter yang Tersedia -->
                @if ($schedules->count() > 0)
                    <div class="kloter-container">
                        <p class="text-muted mb-3">Pilih salah satu kloter di bawah untuk membuat schema:</p>
                        <div class="kloter-grid">
                            @foreach ($schedules as $schedule)
                                <div class="kloter-card" data-schedule-id="{{ $schedule->schedule_id }}"
                                    data-tgl-mulai="{{ $schedule->tgl_mulai }}"
                                    data-tgl-selesai="{{ $schedule->tgl_selesai }}" data-kloter="{{ $schedule->kloter }}">
                                    <div class="kloter-header">
                                        <h4 class="kloter-title">Kloter {{ $schedule->kloter }}</h4>
                                        <span class="kloter-badge">
                                            <i class="fas fa-clock me-1"></i>Aktif
                                        </span>
                                    </div>
                                    <div class="kloter-dates">
                                        <div class="kloter-date-item">
                                            <span class="kloter-date-label">Mulai</span>
                                            <span class="kloter-date-value">
                                                {{ \Carbon\Carbon::parse($schedule->tgl_mulai)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="kloter-separator">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <div class="kloter-date-item">
                                            <span class="kloter-date-label">Selesai</span>
                                            <span class="kloter-date-value">
                                                {{ \Carbon\Carbon::parse($schedule->tgl_selesai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="kloter-duration">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        {{ \Carbon\Carbon::parse($schedule->tgl_mulai)->startOfDay()->diffInDays(\Carbon\Carbon::parse($schedule->tgl_selesai)->startOfDay()) + 1 }}
                                        hari
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning alert-custom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                            <div>
                                <h5 class="mb-1">Tidak Ada Schedule Aktif</h5>
                                <p class="mb-0">Silakan buat schedule terlebih dahulu sebelum membuat schema.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Existing Schemas Section -->
                <div class="existing-schemas-container" id="existing-schemas-container" style="display: none;">
                    <div class="existing-schemas-header">
                        <h5 class="existing-schemas-title">
                            <i class="fas fa-list-alt me-2"></i>Schema yang Sudah Dibuat
                        </h5>
                        <span class="schemas-count-badge" id="schemas-count">0 schema</span>
                    </div>

                    <div id="schemas-content">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>

                <h3 class="card-title mt-4"><i class="fas fa-edit"></i> Informasi Schema</h3>

                <!-- Informasi Kategori Schema -->
                <div class="kategori-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Pilih Kategori Schema</h6>
                    <div class="kategori-list" id="kategori-list-container">
                        @foreach ($kategoriSchemas as $kategori)
                            <div class="kategori-item" data-value="{{ $kategori->id_kategori }}">
                                <div class="kategori-name">{{ $kategori->id_kategori }}</div>
                                <div class="kategori-desc">{{ $kategori->deskripsi }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="kategori_id" class="form-label required-field">
                            <i class="fas fa-tag me-2"></i>Kategori Schema
                        </label>
                        <select class="form-select" id="kategori_id" name="kategori_id"
                            {{ $schedules->count() == 0 ? 'disabled' : 'required' }}>
                            <option value="">Pilih Kategori Schema</option>
                            @foreach ($kategoriSchemas as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->id_kategori }} - {{ $kategori->deskripsi }}
                                </option>
                            @endforeach
                        </select>
                        <span class="form-hint">Pilih kategori yang sesuai dengan jenis kegiatan schema</span>
                        @error('kategori_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kuota" class="form-label required-field">
                            <i class="fas fa-users me-2"></i>Kuota Schema
                        </label>
                        <input type="number" class="form-control" id="kuota" name="kuota"
                            placeholder="Contoh: 100" value="{{ old('kuota') }}">
                        <span class="form-hint">Masukkan jumlah kuota peserta untuk schema ini</span>
                        @error('kuota')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h3 class="card-title mt-4"><i class="fas fa-calendar-alt"></i> Periode Schema</h3>

                <div class="alert alert-info alert-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi:</strong> Tanggal yang sudah digunakan oleh schema lain tidak dapat dipilih.
                    Sistem akan menampilkan tanggal yang tersedia dalam range schedule.
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tgl_mulai" class="form-label required-field">
                            <i class="fas fa-calendar-day me-2"></i>Tanggal Mulai
                        </label>
                        <div class="input-group">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="date" class="form-control input-with-icon" id="tgl_mulai" name="tgl_mulai"
                                value="{{ old('tgl_mulai') }}" {{ $schedules->count() == 0 ? 'disabled' : 'required' }}>
                        </div>
                        <span class="form-hint" id="tgl-mulai-hint">Pilih tanggal mulai kegiatan schema</span>
                        <span class="date-input-hint" id="tgl-mulai-info"></span>
                        @error('tgl_mulai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tgl_selesai" class="form-label required-field">
                            <i class="fas fa-flag-checkered me-2"></i>Tanggal Selesai
                        </label>
                        <div class="input-group">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="date" class="form-control input-with-icon" id="tgl_selesai"
                                name="tgl_selesai" value="{{ old('tgl_selesai') }}"
                                {{ $schedules->count() == 0 ? 'disabled' : 'required' }}>
                        </div>
                        <span class="form-hint" id="tgl-selesai-hint">Pilih tanggal selesai kegiatan schema</span>
                        <span class="date-input-hint" id="tgl-selesai-info"></span>
                        @error('tgl_selesai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Preview Tanggal -->
                <div class="calendar-preview" id="calendar-preview" style="display: none;">
                    <div class="calendar-preview-header">
                        <h6 class="calendar-preview-title">Preview Periode Schema</h6>
                        <small class="text-muted" id="duration-display"></small>
                    </div>
                    <div class="calendar-mini" id="calendar-mini">
                        <!-- Calendar mini akan diisi oleh JavaScript -->
                    </div>
                </div>

                <!-- Actions -->
                <div class="schema-actions">
                    <a href="{{ route('dashboard_koordinator') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" id="reset-form">
                            <i class="fas fa-redo me-2"></i> Reset Form
                        </button>
                        @if ($schedules->count() > 0)
                            <button type="submit" class="btn btn-primary-custom" id="submit-form">
                                <i class="fas fa-paper-plane me-2"></i> Buat Schema
                            </button>
                        @else
                            <button type="button" class="btn btn-primary-custom" id="submit-form" disabled>
                                <i class="fas fa-paper-plane me-2"></i> Buat Schema
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Schema -->
    <div class="modal fade" id="editSchemaModal" tabindex="-1" aria-labelledby="editSchemaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSchemaModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Schema
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="edit-schema-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <input type="text" name="detail_id" id="edit_schema_id" hidden>
                                <label for="edit_kategori_id" class="form-label required-field">
                                    <i class="fas fa-tag me-2"></i>Kategori Schema
                                </label>
                                <select class="form-select" id="edit_kategori_id" name="kategori_id" required>
                                    <option value="">Pilih Kategori Schema</option>
                                    @foreach ($kategoriSchemas as $kategori)
                                        <option value="{{ $kategori->id_kategori }}">
                                            {{ $kategori->id_kategori }} - {{ $kategori->deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit_kuota" class="form-label required-field">
                                    <i class="fas fa-users me-2"></i>Kuota Schema
                                </label>
                                <input type="number" class="form-control" id="edit_kuota" name="kuota"
                                    placeholder="Contoh: 100">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="edit_tgl_mulai" class="form-label required-field">
                                    <i class="fas fa-calendar-day me-2"></i>Tanggal Mulai
                                </label>
                                <div class="input-group">
                                    <i class="fas fa-calendar-alt input-icon"></i>
                                    <input type="date" class="form-control input-with-icon" id="edit_tgl_mulai"
                                        name="tgl_mulai" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="edit_tgl_selesai" class="form-label required-field">
                                    <i class="fas fa-flag-checkered me-2"></i>Tanggal Selesai
                                </label>
                                <div class="input-group">
                                    <i class="fas fa-calendar-alt input-icon"></i>
                                    <input type="date" class="form-control input-with-icon" id="edit_tgl_selesai"
                                        name="tgl_selesai" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info alert-custom mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Perhatian:</strong> Pastikan tanggal yang dipilih tidak bertabrakan dengan schema lain.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Data schedule dari PHP
            const schedules = @json($schedules);
            let selectedSchedule = null;
            let unavailableDates = [];

            // Kloter card click handler
            $('.kloter-card').on('click', function() {
                const scheduleId = $(this).data('schedule-id');
                const tglMulai = $(this).data('tgl-mulai');
                const tglSelesai = $(this).data('tgl-selesai');
                const kloter = $(this).data('kloter');

                // Update selected state
                $('.kloter-card').removeClass('selected');
                $(this).addClass('selected');

                // Set selected schedule
                selectedSchedule = {
                    id: scheduleId,
                    tgl_mulai: tglMulai,
                    tgl_selesai: tglSelesai,
                    kloter: kloter
                };

                // Update hidden input
                $('#schedule_id').val(scheduleId);

                // Update date inputs dan set min/max
                $('#tgl_mulai').attr('min', tglMulai).attr('max', tglSelesai).val('');
                $('#tgl_selesai').attr('min', tglMulai).attr('max', tglSelesai).val('');

                // Update hints
                $('#tgl-mulai-hint').html(
                    `Pilih tanggal mulai antara ${formatDate(tglMulai)} - ${formatDate(tglSelesai)}`);
                $('#tgl-selesai-hint').html(
                    `Pilih tanggal selesai antara ${formatDate(tglMulai)} - ${formatDate(tglSelesai)}`);

                // Show selected kloter info
                showSelectedKloterInfo(kloter, tglMulai, tglSelesai);

                // Enable form if disabled
                $('#kategori_id, #kuota, #tgl_mulai, #tgl_selesai').prop('disabled', false);

                // Load semua data sekaligus (kategori + existing schemas + unavailable dates)
                loadAllData(scheduleId);
            });

            // Function to load semua data sekaligus
            function loadAllData(scheduleId) {
                console.log('Loading all data for schedule:', scheduleId);

                // Show loading state untuk kategori
                $('#kategori_id').html('<option value="">Memuat kategori...</option>').prop('disabled', true);
                $('#kategori-list-container').html(
                    '<div class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Memuat kategori...</div>'
                );

                // Show loading untuk existing schemas
                $('#existing-schemas-container').show();
                $('#schemas-content').html(`
                    <div class="schemas-loading">
                        <div class="spinner"></div>
                        <p>Memuat data schema...</p>
                    </div>
                `);

                // Get CSRF token
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Load available kategori dan existing schemas
                $.ajax({
                    url: '{{ route('schema.getAvailableKategori') }}',
                    type: 'POST',
                    data: {
                        schedule_id: scheduleId,
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Kategori Response:', response);

                        if (response.success) {
                            // Update kategori options
                            updateKategoriOptions(response.data, response.used_count, response
                                .total_count);

                            // Update existing schemas
                            if (response.existing_schemas && response.existing_schemas.length > 0) {
                                console.log(response.existing_schemas);
                                displayExistingSchemas(response.existing_schemas, response
                                    .schemas_count);
                            } else {
                                displayNoSchemas('Belum ada schema yang dibuat untuk schedule ini');
                            }

                            // Load unavailable dates
                            loadUnavailableDates(scheduleId);

                            // Show success message jika perlu
                            if (response.schemas_count > 0) {
                                showAlert('info',
                                    `Ditemukan ${response.schemas_count} schema untuk kloter ini`);
                            }
                        } else {
                            console.error('API error:', response.message);
                            showAlert('error', response.message || 'Gagal memuat data');
                            resetKategoriOptions();
                            displayNoSchemas('Gagal memuat data schema');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.log('Response:', xhr.responseText);

                        let errorMessage = 'Terjadi kesalahan saat memuat data';

                        if (xhr.status === 403) {
                            errorMessage = 'Akses ditolak. Silakan refresh halaman dan coba lagi.';
                        } else if (xhr.status === 404) {
                            errorMessage = 'Schedule tidak ditemukan.';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Data tidak valid.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                        }

                        showAlert('error', errorMessage);
                        resetKategoriOptions();
                        displayNoSchemas('Gagal memuat data schema');
                    }
                });
            }

            // Function to load unavailable dates
            function loadUnavailableDates(scheduleId) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('schema.getUnavailableDates') }}',
                    type: 'POST',
                    data: {
                        schedule_id: scheduleId,
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            unavailableDates = response.unavailable_dates;
                            console.log('Unavailable dates loaded:', unavailableDates);

                            // Update date inputs untuk disable unavailable dates
                            updateDateInputs();

                            // Update info text
                            updateDateInfoText();

                            // Update calendar preview jika sudah ada tanggal yang dipilih
                            if ($('#tgl_mulai').val() && $('#tgl_selesai').val()) {
                                updateCalendarPreview();
                            }
                        }
                    },
                    error: function() {
                        console.error('Failed to load unavailable dates');
                        unavailableDates = [];
                    }
                });
            }

            // Function to update date inputs dengan unavailable dates
            function updateDateInputs() {
                // Reset previous event handlers
                $('#tgl_mulai, #tgl_selesai').off('change.inputValidation');

                // Add new event handlers dengan validasi
                $('#tgl_mulai, #tgl_selesai').on('change.inputValidation', function() {
                    validateDateInput($(this));
                    updateCalendarPreview();
                    updateDateInfoText();
                });

                // Set initial validation
                validateDateInput($('#tgl_mulai'));
                validateDateInput($('#tgl_selesai'));
            }

            // Function to update date info text
            function updateDateInfoText() {
                const totalDates = calculateDateRange(selectedSchedule.tgl_mulai, selectedSchedule.tgl_selesai);
                const availableDates = totalDates - unavailableDates.length;

                $('#tgl-mulai-info').html(
                    `<i class="fas fa-calendar-check me-1"></i>${availableDates} dari ${totalDates} hari tersedia`
                );
                $('#tgl-selesai-info').html(
                    `<i class="fas fa-calendar-check me-1"></i>${availableDates} dari ${totalDates} hari tersedia`
                );
            }

            // Function to calculate date range
            function calculateDateRange(start, end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                return Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            }

            // Function to validate individual date input
            function validateDateInput($input) {
                const dateValue = $input.val();
                const fieldName = $input.attr('id');

                // Reset previous states
                $input.removeClass('is-invalid is-warning');
                $input.next('.invalid-feedback').remove();

                if (!dateValue) return;

                // Check if date is unavailable
                if (unavailableDates.includes(dateValue)) {
                    $input.addClass('is-invalid');
                    $input.after(`
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Tanggal ini sudah digunakan oleh schema lain
                        </div>
                    `);
                    return;
                }

                // Additional validation for date range
                if (fieldName === 'tgl_selesai' && $('#tgl_mulai').val()) {
                    const startDate = new Date($('#tgl_mulai').val());
                    const endDate = new Date(dateValue);

                    if (endDate < startDate) {
                        $input.addClass('is-invalid');
                        $input.after(`
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Tanggal selesai tidak boleh sebelum tanggal mulai
                            </div>
                        `);
                    }
                }
            }

            // Real-time date validation
            function validateDatesRealTime(startDate, endDate, callback) {
                if (!selectedSchedule || !startDate || !endDate) {
                    callback(false, 'Data tidak lengkap');
                    return;
                }

                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('schema.validateDates') }}',
                    type: 'POST',
                    data: {
                        schedule_id: selectedSchedule.id,
                        tgl_mulai: startDate,
                        tgl_selesai: endDate,
                        _token: csrfToken
                    },
                    success: function(response) {
                        callback(response.valid, response.message, response.conflicting_schemas);
                    },
                    error: function() {
                        callback(false, 'Terjadi kesalahan validasi');
                    }
                });
            }

            // Fungsi untuk memeriksa tabrakan tanggal
            function checkDateConflicts(startDate, endDate, scheduleId, callback) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route('schema.checkDateConflicts') }}',
                    type: 'POST',
                    data: {
                        schedule_id: scheduleId,
                        tgl_mulai: startDate,
                        tgl_selesai: endDate,
                        _token: csrfToken
                    },
                    success: function(response) {
                        callback(response.conflicts, response.conflicting_schemas);
                    },
                    error: function() {
                        callback(false, []);
                    }
                });
            }

            // Validasi tanggal
            function validateDates(showAlert = true) {
                const startDate = $('#tgl_mulai').val();
                const endDate = $('#tgl_selesai').val();

                if (!startDate || !endDate || !selectedSchedule) {
                    return false;
                }

                // Reset semua status error
                $('#tgl_mulai').removeClass('is-invalid is-warning');
                $('#tgl_selesai').removeClass('is-invalid is-warning');
                $('.invalid-feedback').remove();
                $('.date-conflict-alert').remove();

                let isValid = true;

                // Validasi terhadap schedule range
                if (startDate < selectedSchedule.tgl_mulai) {
                    showDateError('tgl_mulai',
                        `Tanggal mulai tidak boleh sebelum ${formatDate(selectedSchedule.tgl_mulai)}`);
                    isValid = false;
                }

                if (startDate > selectedSchedule.tgl_selesai) {
                    showDateError('tgl_mulai',
                        `Tanggal mulai tidak boleh setelah ${formatDate(selectedSchedule.tgl_selesai)}`);
                    isValid = false;
                }

                if (endDate < selectedSchedule.tgl_mulai) {
                    showDateError('tgl_selesai',
                        `Tanggal selesai tidak boleh sebelum ${formatDate(selectedSchedule.tgl_mulai)}`);
                    isValid = false;
                }

                if (endDate > selectedSchedule.tgl_selesai) {
                    showDateError('tgl_selesai',
                        `Tanggal selesai tidak boleh setelah ${formatDate(selectedSchedule.tgl_selesai)}`);
                    isValid = false;
                }

                // Validasi logika tanggal
                if (endDate < startDate) {
                    showDateError('tgl_selesai', 'Tanggal selesai tidak boleh sebelum tanggal mulai');
                    isValid = false;
                }

                // Validasi tanggal unavailable
                const startUnavailable = unavailableDates.includes(startDate);
                const endUnavailable = unavailableDates.includes(endDate);

                if (startUnavailable) {
                    showDateError('tgl_mulai', 'Tanggal mulai sudah digunakan oleh schema lain');
                    isValid = false;
                }

                if (endUnavailable) {
                    showDateError('tgl_selesai', 'Tanggal selesai sudah digunakan oleh schema lain');
                    isValid = false;
                }

                // Jika validasi dasar passed, cek tabrakan dengan schema lain
                if (isValid && selectedSchedule) {
                    checkDateConflicts(startDate, endDate, selectedSchedule.id, function(hasConflicts,
                        conflictingSchemas) {
                        if (hasConflicts) {
                            showDateConflictWarning(conflictingSchemas);
                            isValid = false;
                        }
                    });
                }

                return isValid;
            }

            // Fungsi untuk menampilkan error tanggal
            function showDateError(field, message) {
                $(`#${field}`).addClass('is-invalid');
                $(`#${field}`).after(`<div class="invalid-feedback">${message}</div>`);
            }

            // Fungsi untuk menampilkan warning konflik tanggal
            function showDateConflictWarning(conflictingSchemas) {
                const warningHtml = `
                    <div class="alert alert-warning alert-custom date-conflict-alert mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Periode yang dipilih bertabrakan dengan schema berikut:
                        <ul class="mt-2 mb-0">
                            ${conflictingSchemas.map(schema => 
                                `<li><strong>${schema.kategori_id}</strong> (${formatDate(schema.tgl_mulai)} - ${formatDate(schema.tgl_selesai)})</li>`
                            ).join('')}
                        </ul>
                    </div>
                `;
                $('#calendar-preview').before(warningHtml);

                $('#tgl_mulai').addClass('is-warning');
                $('#tgl_selesai').addClass('is-warning');
            }

            // Update calendar preview dengan unavailable dates - DIPERBAIKI
            function updateCalendarPreview() {
                const startDate = $('#tgl_mulai').val();
                const endDate = $('#tgl_selesai').val();

                // Validasi dasar dulu
                if (!validateDates(false)) {
                    $('#calendar-preview').hide();
                    return;
                }

                // Tampilkan preview
                $('#calendar-preview').show();

                // Hitung durasi - DIPERBAIKI: Gunakan tanggal asli tanpa penambahan
                const start = new Date(startDate);
                const end = new Date(endDate);
                const duration = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                $('#duration-display').text(`${duration} hari`);

                // Generate mini calendar dengan highlight tanggal yang tidak tersedia - DIPERBAIKI
                generateMiniCalendar(start, end);
            }

            // Generate mini calendar - DIPERBAIKI
            function generateMiniCalendar(start, end) {
                const calendarMini = $('#calendar-mini');
                calendarMini.empty();

                // Hari dalam seminggu
                const weekdays = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
                weekdays.forEach(day => {
                    calendarMini.append(
                        `<div class="calendar-mini-day" style="font-weight:bold; background:#f8f9fa;">${day}</div>`
                    );
                });

                // DIPERBAIKI: Gunakan tanggal yang sama persis tanpa penambahan
                const firstDay = new Date(start);
                const lastDay = new Date(end);

                // Buat array semua tanggal dalam range
                const allDatesInRange = [];
                const current = new Date(firstDay);

                while (current <= lastDay) {
                    allDatesInRange.push(new Date(current));
                    current.setDate(current.getDate() + 1);
                }

                // Dapatkan bulan pertama dan terakhir untuk kalender
                const calendarFirstDay = new Date(firstDay.getFullYear(), firstDay.getMonth(), 1);
                const calendarLastDay = new Date(lastDay.getFullYear(), lastDay.getMonth() + 1, 0);

                // Tambahkan hari kosong sebelum bulan dimulai
                for (let i = 0; i < calendarFirstDay.getDay(); i++) {
                    calendarMini.append('<div class="calendar-mini-day outside"></div>');
                }

                // Tambahkan hari dalam bulan - DIPERBAIKI: Gunakan logika yang benar
                const calendarCurrent = new Date(calendarFirstDay);
                while (calendarCurrent <= calendarLastDay) {
                    const dayElement = $('<div class="calendar-mini-day"></div>');
                    const dateString = calendarCurrent.toISOString().split('T')[0];

                    dayElement.text(calendarCurrent.getDate());

                    // Tandai jika hari dalam range yang dipilih - DIPERBAIKI: Gunakan tanggal asli
                    if (calendarCurrent >= firstDay && calendarCurrent <= lastDay) {
                        dayElement.addClass('selected');
                    }

                    // Tandai jika hari di luar schedule
                    if (selectedSchedule &&
                        (calendarCurrent < new Date(selectedSchedule.tgl_mulai) ||
                            calendarCurrent > new Date(selectedSchedule.tgl_selesai))) {
                        dayElement.addClass('outside');
                    }

                    // Tandai jika hari tidak tersedia (sudah digunakan schema lain)
                    if (unavailableDates.includes(dateString)) {
                        dayElement.addClass('unavailable');
                        dayElement.attr('title', 'Tanggal tidak tersedia (sudah digunakan schema lain)');
                    }

                    calendarMini.append(dayElement);
                    calendarCurrent.setDate(calendarCurrent.getDate() + 1);
                }
            }

            // Function to update kategori options
            function updateKategoriOptions(kategoriData, usedCount, totalCount) {
                // Update select dropdown
                const selectHtml = '<option value="">Pilih Kategori Schema</option>' +
                    kategoriData.map(kategori =>
                        `<option value="${kategori.id_kategori}">${kategori.id_kategori} - ${kategori.deskripsi}</option>`
                    ).join('');

                $('#kategori_id').html(selectHtml).prop('disabled', false);

                // Update kategori cards
                const kategoriListHtml = kategoriData.map(kategori =>
                    `<div class="kategori-item" data-value="${kategori.id_kategori}">
                <div class="kategori-name">${kategori.id_kategori}</div>
                <div class="kategori-desc">${kategori.deskripsi}</div>
            </div>`
                ).join('');

                $('#kategori-list-container').html(kategoriListHtml);

                // Update info text
                const infoText = $('.kategori-info h6');
                const originalText = infoText.html().replace(/<span.*?<\/span>/, '');
                const countInfo =
                    `<span class="badge bg-primary ms-2">${kategoriData.length}/${totalCount} tersedia</span>`;
                infoText.html(originalText + countInfo);

                // Re-attach click event untuk kategori items baru
                $('.kategori-item').on('click', function() {
                    const value = $(this).data('value');
                    $('#kategori_id').val(value);

                    // Update UI
                    $('.kategori-item').removeClass('selected');
                    $(this).addClass('selected');
                });

                // Show message jika tidak ada kategori tersedia
                if (kategoriData.length === 0) {
                    $('#kategori-list-container').html(`
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Semua kategori sudah digunakan pada schedule ini.
                </div>
            `);
                    $('#kategori_id').prop('disabled', true);
                }
            }

            // Function to reset kategori options
            function resetKategoriOptions() {
                $('#kategori_id').html('<option value="">Pilih Kategori Schema</option>').prop('disabled', true);
                $('#kategori-list-container').html(
                    '<div class="alert alert-warning text-center">Gagal memuat kategori</div>');

                // Reset info text
                const infoText = $('.kategori-info h6');
                infoText.html(infoText.html().replace(/<span.*?<\/span>/, ''));
            }

            // Function to display existing schemas - DIPERBAIKI dengan data attributes
            function displayExistingSchemas(schemas, count) {
                const container = $('#schemas-content');
                const countBadge = $('#schemas-count');

                // Update count badge
                countBadge.text(`${count} schema`);

                // Create table
                let html = `
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori Schema</th>
                                <th class="text-center">Kuota</th>
                                <th>Periode</th>
                                <th class="text-center">Durasi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                // Add schema rows dengan data attributes
                schemas.forEach(schema => {
                    console.log(schema);
                    const startDate = new Date(schema.tgl_mulai);
                    const endDate = new Date(schema.tgl_selesai);
                    const duration = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                    const status = getSchemaStatus(schema.tgl_mulai, schema.tgl_selesai);
                    const kuota = schema.kuota ? schema.kuota : 'Tidak ada batas';

                    html += `
                        <tr data-schema-id="${schema.id_schema}" 
                            data-kategori-id="${schema.kategori_id}" 
                            data-kuota="${schema.kuota}" 
                            data-tgl-mulai="${schema.tgl_mulai}" 
                            data-tgl-selesai="${schema.tgl_selesai}">
                            <td>
                                <div class="fw-semibold">${schema.kategori_id}</div>
                                <small class="text-muted">${schema.nama_kategori || schema.kategori?.deskripsi || '-'}</small>
                            </td>
                            <td class="text-center">${kuota}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <small class="text-muted">
                                        <i class="fas fa-play-circle me-1"></i>${formatDate(schema.tgl_mulai)}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-flag-checkered me-1"></i>${formatDate(schema.tgl_selesai)}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                <small class="text-muted">${duration} hari</small>
                            </td>
                            <td class="text-center">
                                <span class="badge ${status.class}">${status.text}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-edit-schema" 
                                            data-schema-id="${schema.id_detail_schema}"
                                            data-kategori-id="${schema.kategori_id}"
                                            data-kuota="${schema.kuota}"
                                            data-tgl-mulai="${schema.tgl_mulai}"
                                            data-tgl-selesai="${schema.tgl_selesai}"
                                            title="Edit Schema">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-delete-schema" 
                                            data-schema-id="${schema.id_detail_schema}"
                                            data-kategori-id="${schema.kategori_id}"
                                            title="Hapus Schema">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                html += `
                        </tbody>
                    </table>
                </div>
                `;

                container.html(html);

                // Attach event listeners untuk tombol aksi
                attachSchemaActionListeners();
            }

            // Function untuk attach event listeners ke tombol aksi
            function attachSchemaActionListeners() {
                // Edit button click handler
                $('.btn-edit-schema').on('click', function() {
                    const schemaId = $(this).data('schema-id');
                    const kategoriId = $(this).data('kategori-id');
                    const kuota = $(this).data('kuota');
                    const tglMulai = $(this).data('tgl-mulai');
                    const tglSelesai = $(this).data('tgl-selesai');

                    editSchemaWithData(schemaId, kategoriId, kuota, tglMulai, tglSelesai);
                });

                // Delete button click handler
                $('.btn-delete-schema').on('click', function() {
                    const schemaId = $(this).data('schema-id');
                    const kategoriId = $(this).data('kategori-id');
                    const scheduleId = $(this).data('schedule-id');

                    deleteSchemaWithData(schemaId, kategoriId, scheduleId);
                });
            }

            // Function to display no schemas message
            function displayNoSchemas(message) {
                $('#schemas-content').html(`
                    <div class="no-schemas">
                        <i class="fas fa-inbox"></i>
                        <h5>${message}</h5>
                        <p class="text-muted">Schema yang dibuat akan muncul di sini</p>
                    </div>
                `);
                $('#schemas-count').text('0 schema');
            }

            // Function to determine schema status
            function getSchemaStatus(startDate, endDate) {
                const now = new Date();
                const start = new Date(startDate);
                const end = new Date(endDate);

                if (now < start) {
                    return {
                        class: 'status-upcoming',
                        text: 'Akan Datang'
                    };
                } else if (now >= start && now <= end) {
                    return {
                        class: 'status-active',
                        text: 'Aktif'
                    };
                } else {
                    return {
                        class: 'status-completed',
                        text: 'Selesai'
                    };
                }
            }

            // Show selected kloter info
            function showSelectedKloterInfo(kloter, tglMulai, tglSelesai) {
                const duration = calculateDuration(tglMulai, tglSelesai);
                const infoHtml = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Kloter ${kloter}</strong><br>
                    <small>${formatDate(tglMulai)} - ${formatDate(tglSelesai)}</small>
                </div>
                <div class="text-end">
                    <small>${duration} hari</small>
                </div>
            </div>
        `;
                $('#selected-kloter-details').html(infoHtml);
                $('#selected-kloter-info').show();
            }

            // Format date function - DIPERBAIKI untuk konsistensi
            function formatDate(dateString) {
                const date = new Date(dateString);
                // Pastikan tidak ada penambahan hari
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            // Calculate duration function - DIPERBAIKI
            function calculateDuration(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                // Hitung durasi berdasarkan tanggal asli
                return Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
            }

            // Event listeners
            $('#tgl_mulai, #tgl_selesai').on('change', function() {
                validateDateInput($(this));
                updateCalendarPreview();
                updateDateInfoText();
            });

            // Kategori item click handler
            $('.kategori-item').on('click', function() {
                const value = $(this).data('value');
                $('#kategori_id').val(value);

                // Update UI
                $('.kategori-item').removeClass('selected');
                $(this).addClass('selected');
            });

            // Kategori select change handler
            $('#kategori_id').on('change', function() {
                const value = $(this).val();
                $('.kategori-item').removeClass('selected');
                $(`.kategori-item[data-value="${value}"]`).addClass('selected');
            });

            // Reset form
            $('#reset-form').on('click', function() {
                if (confirm(
                        'Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                    $('#schema-form')[0].reset();
                    $('.kloter-card').removeClass('selected');
                    $('.kategori-item').removeClass('selected');
                    $('#selected-kloter-info').hide();
                    $('#calendar-preview').hide();
                    $('#existing-schemas-container').hide();
                    selectedSchedule = null;
                    unavailableDates = [];
                    $('#schedule_id').val('');

                    // Reset hints
                    $('#tgl-mulai-hint').text('Pilih tanggal mulai kegiatan schema');
                    $('#tgl-selesai-hint').text('Pilih tanggal selesai kegiatan schema');
                    $('#tgl-mulai-info').text('');
                    $('#tgl-selesai-info').text('');

                    // Reset kategori options
                    resetKategoriOptions();

                    // Disable form if no schedule selected
                    if ($('.kloter-card').length === 0) {
                        $('#kategori_id, #kuota, #tgl_mulai, #tgl_selesai').prop('disabled', true);
                    }
                }
            });

            // Form submission handler
            $('#schema-form').on('submit', function(e) {
                if (!validateDates(true)) {
                    e.preventDefault();
                    showAlert('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
                    // Scroll ke error pertama
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });

            // Fungsi untuk menampilkan alert
            function showAlert(type, message) {
                // Hapus alert sebelumnya
                $('.alert-dismissible').alert('close');

                const alertClass = type === 'error' ? 'alert-danger' : type === 'info' ? 'alert-info' :
                    'alert-success';
                const icon = type === 'error' ? 'exclamation-circle' : type === 'info' ? 'info-circle' :
                    'check-circle';

                const alertHtml = `
            <div class="alert ${alertClass} alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
                $('.schema-container').prepend(alertHtml);

                // Auto dismiss setelah 5 detik
                setTimeout(() => {
                    $('.alert-dismissible').alert('close');
                }, 5000);
            }

            // Inisialisasi preview jika ada nilai dari old()
            if ($('#tgl_mulai').val() && $('#tgl_selesai').val()) {
                updateCalendarPreview();
            }

            // Auto-select kloter jika ada dari old()
            const selectedScheduleId = $('#schedule_id').val();
            if (selectedScheduleId) {
                $(`.kloter-card[data-schedule-id="${selectedScheduleId}"]`).click();
            }
        });

        // Global functions untuk aksi schema

        // Fungsi edit schema menggunakan data dari atribut
        function editSchemaWithData(schemaId, kategoriId, kuota, tglMulai, tglSelesai) {
            console.log('Editing schema ID:', schemaId);

            // Validasi schemaId
            if (!schemaId || schemaId === 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID Schema tidak valid',
                    confirmButtonColor: '#3b71ca'
                });
                return;
            }

            // Isi form modal dengan data dari atribut
            $('#edit_schema_id').val(schemaId);
            $('#edit_kategori_id').val(kategoriId);
            $('#edit_kuota').val(kuota);
            $('#edit_tgl_mulai').val(tglMulai);
            $('#edit_tgl_selesai').val(tglSelesai);

            // Tampilkan modal
            $('#editSchemaModal').modal('show');
        }

        // Fungsi delete schema menggunakan data dari atribut
        function deleteSchemaWithData(schemaId, kategoriId, scheduleId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan menghapus schema "${kategoriId}". Data yang dihapus tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Sedang menghapus schema',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX delete request
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: `/delete-schema/${schemaId}`,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken,
                            detail_id: schemaId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `Schema "${kategoriId}" berhasil dihapus`,
                                confirmButtonColor: '#3b71ca'
                            }).then(() => {
                                // Reload data schemas jika ada schedule yang dipilih
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            const errorMessage = xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menghapus schema';
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                                confirmButtonColor: '#3b71ca'
                            });
                        }
                    });
                }
            });
        }

        // Handle submit form edit
        $('#edit-schema-form').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const schemaId = $('#edit_schema_id').val();
            const url = `/update-schema/${schemaId}`;

            // Tampilkan loading
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Sedang menyimpan perubahan',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Schema berhasil diperbarui',
                        confirmButtonColor: '#3b71ca'
                    }).then(() => {
                        // Tutup modal
                        $('#editSchemaModal').modal('hide');

                        // Reload data schemas jika ada schedule yang dipilih
                        if (window.selectedSchedule) {
                            window.loadAllData(window.selectedSchedule.id);
                        }
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menyimpan perubahan';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors)[0][0];
                    } else if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage,
                        confirmButtonColor: '#3b71ca'
                    });
                }
            });
        });

        // Reset form modal ketika modal ditutup
        $('#editSchemaModal').on('hidden.bs.modal', function() {
            $('#edit-schema-form')[0].reset();
        });

        // Hapus fungsi global editSchema dan deleteSchema yang lama
        window.editSchema = function(schemaId) {
            console.warn('editSchema fallback called for ID:', schemaId);
        };

        window.deleteSchema = function(schemaId) {
            console.warn('deleteSchema fallback called for ID:', schemaId);
        };
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
                }, 5000);
            });
        })();
    </script>
@endsection
