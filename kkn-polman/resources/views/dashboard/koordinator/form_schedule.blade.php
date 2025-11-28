@extends('dashboard.koordinator.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN - Buat Schedule')

@section('style')
    <style>
        .schedule-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .schedule-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .schedule-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .schedule-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .schedule-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
            transition: all 0.5s ease;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.25);
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
            color: white;
        }

        .btn-primary-custom:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .detail-schedule-row {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .detail-schedule-row:hover {
            background-color: #e9ecef;
        }

        .remove-detail {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .remove-detail:hover {
            color: #a71e2a;
            transform: scale(1.1);
        }

        .add-detail-btn {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .date-input-group {
            position: relative;
        }

        .date-input-group .form-control {
            padding-left: 40px;
        }

        .date-input-group i {
            position: absolute;
            left: 15px;
            top: 26%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 16px;
            color: #555;
        }

        .schedule-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-info {
            background-color: #e7f3ff;
            border-color: #b3d7ff;
            color: #004085;
        }

        .invalid-feedback {
            display: block;
        }

        @media (max-width: 768px) {
            .schedule-actions {
                flex-direction: column;
                gap: 15px;
            }

            .schedule-actions .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="schedule-container">
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
            <div class="schedule-header">
                <h1><i class="fas fa-calendar-alt me-2"></i> Form Pembuatan Schedule KKN</h1>
                <p>Buat jadwal kegiatan KKN dengan mengisi form berikut</p>
            </div>

            <!-- Form -->
            <form class="schedule-form" id="schedule-form" method="post" action="{{ route('submit_schedule') }}">
                @csrf
                <!-- Detail Kegiatan -->
                <div class="form-section" id="section-detail">
                    <h3 class="section-title"><i class="fas fa-tasks"></i> Detail Kegiatan</h3>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong> Tambahkan detail kegiatan yang akan dilaksanakan dalam schedule ini.
                        Minimal harus ada satu kegiatan.
                    </div>

                    <div id="detail-schedules-container">
                        <!-- Detail kegiatan akan ditambahkan di sini secara dinamis -->
                        <div class="detail-schedule-row" data-index="0">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="kloter_0" class="form-label required-field">Kloter</label>
                                    <input type="number" class="form-control" id="kloter" name="kloter"
                                        placeholder="Contoh: 1,2,3" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi_0" class="form-label required-field">Deskripsi Kegiatan</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                        placeholder="Jelaskan detail kegiatan yang akan dilaksanakan" required></textarea>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tgl_mulai_0" class="form-label required-field">Tanggal Mulai</label>
                                    <div class="date-input-group">
                                        <i class="fas fa-calendar-alt"></i>
                                        <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                                        <div class="invalid-feedback">Tanggal mulai tidak boleh lebih awal dari hari ini.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="tgl_selesai_0" class="form-label required-field">Tanggal Selesai</label>
                                    <div class="date-input-group">
                                        <i class="fas fa-calendar-alt"></i>
                                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai"
                                            required>
                                        <div class="invalid-feedback">Tanggal selesai harus setelah tanggal mulai.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="schedule-actions">
                    <a href="{{ route('dashboard_koordinator') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" id="save-draft">
                            <i class="fas fa-save me-2"></i> Simpan Draft
                        </button>
                        <button type="submit" class="btn btn-primary-custom" id="submit-form">
                            <i class="fas fa-paper-plane me-2"></i> Buat Schedule
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Set min date untuk tanggal mulai (hari ini)
            const today = new Date().toISOString().split('T')[0];
            $('#tgl_mulai').attr('min', today);

            // Set min date untuk tanggal selesai berdasarkan tanggal mulai
            $('#tgl_mulai').on('change', function() {
                const startDate = $(this).val();
                $('#tgl_selesai').attr('min', startDate);

                // Reset tanggal selesai jika lebih awal dari tanggal mulai
                if ($('#tgl_selesai').val() && $('#tgl_selesai').val() <= startDate) {
                    $('#tgl_selesai').val('');
                    $('#tgl_selesai').addClass('is-invalid');
                }
            });

            // Validasi tanggal selesai
            $('#tgl_selesai').on('change', function() {
                const startDate = $('#tgl_mulai').val();
                const endDate = $(this).val();

                if (startDate && endDate && endDate <= startDate) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validasi tanggal mulai
            $('#tgl_mulai').on('change', function() {
                const startDate = $(this).val();
                const today = new Date().toISOString().split('T')[0];

                if (startDate < today) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Fungsi untuk memvalidasi tanggal
            function validateDates() {
                let isValid = true;

                const startDate = $('#tgl_mulai').val();
                const endDate = $('#tgl_selesai').val();
                const today = new Date().toISOString().split('T')[0];

                // Validasi tanggal mulai
                if (startDate < today) {
                    $('#tgl_mulai').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#tgl_mulai').removeClass('is-invalid');
                }

                // Validasi tanggal selesai
                if (startDate && endDate && endDate <= startDate) {
                    $('#tgl_selesai').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#tgl_selesai').removeClass('is-invalid');
                }

                return isValid;
            }

            // Fungsi untuk memperbarui validasi form
            function updateFormValidation() {
                // Hapus kelas is-invalid saat input diubah
                $('input, textarea').on('input', function() {
                    $(this).removeClass('is-invalid');
                });

                // Validasi tanggal saat diubah
                $('input[type="date"]').on('change', function() {
                    validateDates();
                });
            }

            // Validasi form sebelum submit
            $('#schedule-form').on('submit', function(e) {
                // Validasi tanggal
                if (!validateDates()) {
                    e.preventDefault();
                    alert(
                        'Mohon periksa kembali tanggal yang Anda masukkan. Tanggal mulai tidak boleh lebih awal dari hari ini, dan tanggal selesai harus setelah tanggal mulai.');
                    return false;
                }

                return true;
            });

            // Inisialisasi validasi form
            updateFormValidation();
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
