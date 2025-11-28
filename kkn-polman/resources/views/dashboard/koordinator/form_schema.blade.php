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

        .date-range-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .date-range-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            font-size: 1.2rem;
        }

        .date-range-badge {
            background: var(--primary-color);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .date-range-display {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }

        .date-range-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .date-range-label {
            font-size: 0.95rem;
            color: var(--secondary-color);
            margin-bottom: 8px;
        }

        .date-range-value {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1.1rem;
        }

        .date-range-separator {
            margin: 0 25px;
            color: var(--secondary-color);
            font-weight: bold;
            font-size: 1.2rem;
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
            border-left-color: greenyellow;
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
            
            .date-range-display,
            .kloter-dates {
                flex-direction: column;
                gap: 15px;
            }
            
            .date-range-separator,
            .kloter-separator {
                transform: rotate(90deg);
                margin: 10px 0;
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

        /* Loading state */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading:after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        /* Form enhancements */
        .form-group {
            margin-bottom: 25px;
        }

        .form-hint {
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin-top: 5px;
            display: block;
        }

        /* Animation for form elements */
        .form-control, .form-select, .kategori-item, .kloter-card {
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
                                     data-tgl-selesai="{{ $schedule->tgl_selesai }}"
                                     data-kloter="{{ $schedule->kloter }}">
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
                                        {{ \Carbon\Carbon::parse($schedule->tgl_mulai)->startOfDay()->diffInDays(\Carbon\Carbon::parse($schedule->tgl_selesai)->startOfDay()) + 1 }} hari
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

                <h3 class="card-title mt-4"><i class="fas fa-edit"></i> Informasi Schema</h3>

                <!-- Informasi Kategori Schema -->
                <div class="kategori-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Pilih Kategori Schema</h6>
                    <div class="kategori-list">
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
                            <i class="fas fa-heading me-2"></i>Kuota Schema
                        </label>
                        <input type="number" class="form-control" id="kuota" name="kuota" 
                            placeholder="Contoh: 100" value="{{ old('kuota') }}">
                        @error('kuota_schema')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h3 class="card-title mt-4"><i class="fas fa-calendar-alt"></i> Periode Schema</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tgl_mulai" class="form-label required-field">
                            <i class="fas fa-calendar-day me-2"></i>Tanggal Mulai
                        </label>
                        <div class="input-group">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="date" class="form-control input-with-icon" id="tgl_mulai" name="tgl_mulai" 
                                value="{{ old('tgl_mulai') }}"
                                {{ $schedules->count() == 0 ? 'disabled' : 'required' }}>
                        </div>
                        <span class="form-hint" id="tgl-mulai-hint">Pilih tanggal mulai kegiatan schema</span>
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
                            <input type="date" class="form-control input-with-icon" id="tgl_selesai" name="tgl_selesai" 
                                value="{{ old('tgl_selesai') }}"
                                {{ $schedules->count() == 0 ? 'disabled' : 'required' }}>
                        </div>
                        <span class="form-hint" id="tgl-selesai-hint">Pilih tanggal selesai kegiatan schema</span>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Data schedule dari PHP
            const schedules = @json($schedules);
            let selectedSchedule = null;

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
                
                // Update date inputs
                $('#tgl_mulai').attr('min', tglMulai).attr('max', tglSelesai);
                $('#tgl_selesai').attr('min', tglMulai).attr('max', tglSelesai);
                
                // Update hints
                $('#tgl-mulai-hint').html(`Pilih tanggal mulai antara ${formatDate(tglMulai)} - ${formatDate(tglSelesai)}`);
                $('#tgl-selesai-hint').html(`Pilih tanggal selesai antara ${formatDate(tglMulai)} - ${formatDate(tglSelesai)}`);
                
                // Show selected kloter info
                showSelectedKloterInfo(kloter, tglMulai, tglSelesai);
                
                // Enable form if disabled
                $('#kategori_id, #nama_schema, #deskripsi, #tgl_mulai, #tgl_selesai').prop('disabled', false);
            });

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

            // Format date function
            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }

            // Calculate duration function
            function calculateDuration(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                return Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
            }

            // Kategori item click handler
            $('.kategori-item').on('click', function() {
                const value = $(this).data('value');
                $('#kategori_id').val(value);
                
                // Update UI
                $('.kategori-item').removeClass('selected');
                $(this).addClass('selected');
            });

            // Validasi tanggal
            function validateDates() {
                const startDate = $('#tgl_mulai').val();
                const endDate = $('#tgl_selesai').val();
                
                if (!startDate || !endDate || !selectedSchedule) {
                    return false;
                }
                
                // Validasi terhadap schedule
                if (startDate < selectedSchedule.tgl_mulai || startDate > selectedSchedule.tgl_selesai) {
                    $('#tgl_mulai').addClass('is-invalid');
                    return false;
                } else {
                    $('#tgl_mulai').removeClass('is-invalid');
                }
                
                if (endDate < selectedSchedule.tgl_mulai || endDate > selectedSchedule.tgl_selesai) {
                    $('#tgl_selesai').addClass('is-invalid');
                    return false;
                } else {
                    $('#tgl_selesai').removeClass('is-invalid');
                }
                
                // Validasi logika tanggal
                if (endDate < startDate) {
                    $('#tgl_selesai').addClass('is-invalid');
                    return false;
                } else {
                    $('#tgl_selesai').removeClass('is-invalid');
                }
                
                return true;
            }

            // Update preview kalender
            function updateCalendarPreview() {
                const startDate = $('#tgl_mulai').val();
                const endDate = $('#tgl_selesai').val();
                
                if (!validateDates()) {
                    $('#calendar-preview').hide();
                    return;
                }
                
                // Tampilkan preview
                $('#calendar-preview').show();
                
                // Hitung durasi
                const start = new Date(startDate);
                const end = new Date(endDate);
                const duration = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                $('#duration-display').text(`${duration} hari`);
                
                // Generate mini calendar
                generateMiniCalendar(start, end);
            }

            // Generate mini calendar
            function generateMiniCalendar(start, end) {
                const calendarMini = $('#calendar-mini');
                calendarMini.empty();
                
                // Hari dalam seminggu
                const weekdays = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
                weekdays.forEach(day => {
                    calendarMini.append(`<div class="calendar-mini-day" style="font-weight:bold; background:#f8f9fa;">${day}</div>`);
                });
                
                // Dapatkan hari pertama bulan dari tanggal mulai
                const firstDay = new Date(start.getFullYear(), start.getMonth(), 1);
                const lastDay = new Date(end.getFullYear(), end.getMonth() + 1, 0);
                
                // Tambahkan hari kosong sebelum bulan dimulai
                for (let i = 0; i < firstDay.getDay(); i++) {
                    calendarMini.append('<div class="calendar-mini-day outside"></div>');
                }
                
                // Tambahkan hari dalam bulan
                const current = new Date(firstDay);
                while (current <= lastDay) {
                    const dayElement = $('<div class="calendar-mini-day"></div>');
                    dayElement.text(current.getDate());
                    
                    // Tandai jika hari dalam range yang dipilih
                    if (current >= start && current <= end) {
                        dayElement.addClass('selected');
                    }
                    
                    // Tandai jika hari di luar schedule
                    if (selectedSchedule && 
                        (current < new Date(selectedSchedule.tgl_mulai) || current > new Date(selectedSchedule.tgl_selesai))) {
                        dayElement.addClass('outside');
                    }
                    
                    calendarMini.append(dayElement);
                    current.setDate(current.getDate() + 1);
                }
            }

            // Event listeners
            $('#tgl_mulai, #tgl_selesai').on('change', function() {
                updateCalendarPreview();
            });

            // Reset form
            $('#reset-form').on('click', function() {
                if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                    $('#schema-form')[0].reset();
                    $('.kloter-card').removeClass('selected');
                    $('.kategori-item').removeClass('selected');
                    $('#selected-kloter-info').hide();
                    $('#calendar-preview').hide();
                    selectedSchedule = null;
                    $('#schedule_id').val('');
                    
                    // Reset hints
                    $('#tgl-mulai-hint').text('Pilih tanggal mulai kegiatan schema');
                    $('#tgl-selesai-hint').text('Pilih tanggal selesai kegiatan schema');
                    
                    // Disable form if no schedule selected
                    if ($('.kloter-card').length === 0) {
                        $('#kategori_id, #nama_schema, #deskripsi, #tgl_mulai, #tgl_selesai').prop('disabled', true);
                    }
                }
            });

            // Fungsi untuk menampilkan alert
            function showAlert(type, message) {
                // Hapus alert sebelumnya
                $('.alert-dismissible').alert('close');
                
                const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
                const icon = type === 'error' ? 'exclamation-circle' : 'check-circle';
                
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

            // Auto-select kategori jika ada dari old()
            const selectedKategori = $('#kategori_id').val();
            if (selectedKategori) {
                $(`.kategori-item[data-value="${selectedKategori}"]`).addClass('selected');
            }

            // Auto-select kloter jika ada dari old()
            const selectedScheduleId = $('#schedule_id').val();
            if (selectedScheduleId) {
                $(`.kloter-card[data-schedule-id="${selectedScheduleId}"]`).click();
            }
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
                }, 5000);
            });
        })();
    </script>
@endsection