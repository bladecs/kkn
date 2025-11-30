@extends('dashboard.mahasiswa.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
        .registration-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .registration-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e4bbe 100%);
            color: white;
        }

        .registration-header h1 {
            color: white;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2.2rem;
        }

        .registration-header p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .registration-progress {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .progress-container {
            position: relative;
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color) 0%, #1e4bbe 100%);
            width: 0%;
            transition: width 0.8s ease-in-out;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
        }

        .step-number {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            z-index: 2;
            border: 2px solid transparent;
        }

        .step-label {
            font-size: 0.8rem;
            text-align: center;
            color: #6c757d;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .progress-step.active .step-number {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 5px rgba(30, 79, 190, 0.2);
        }

        .progress-step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .progress-step.completed .step-number {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .progress-step.completed .step-label {
            color: #28a745;
            font-weight: 600;
        }

        .registration-form {
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
            font-size: 1.3rem;
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
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.25);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e4bbe 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
            color: white;
            box-shadow: 0 4px 6px rgba(30, 79, 190, 0.2);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1e4bbe 0%, #163a8c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(30, 79, 190, 0.3);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            border: 2px solid #6c757d;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .registration-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group .form-control:focus {
            border-color: #e2e8f0;
            box-shadow: none;
        }

        .input-group .form-control:focus+.input-group-text {
            border-color: var(--primary-color);
        }

        .schedule-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .schedule-card {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #f8f9fa;
            position: relative;
        }

        .schedule-card:hover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
            transform: translateY(-3px);
        }

        .schedule-card.selected {
            border-color: var(--primary-color);
            background-color: rgba(30, 79, 190, 0.05);
            box-shadow: 0 5px 15px rgba(30, 79, 190, 0.1);
        }

        .schedule-card.selected::before {
            content: "✓";
            position: absolute;
            top: -10px;
            right: -10px;
            width: 25px;
            height: 25px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .schedule-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .schedule-kloter {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .schedule-dates {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .schedule-description {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 10px;
            line-height: 1.4;
        }

        .schedule-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.7rem;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .info-card i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        .form-feedback {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .valid-feedback {
            color: #28a745;
        }

        .invalid-feedback {
            color: #dc3545;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .registration-actions {
                flex-direction: column;
                gap: 15px;
            }

            .registration-actions .btn {
                width: 100%;
            }

            .schedule-options {
                grid-template-columns: 1fr;
            }
        }

        /* Animasi untuk transisi section */
        .form-section {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling untuk input yang valid */
        .form-control.is-valid {
            border-color: #28a745;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        /* Styling untuk input yang tidak valid */
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="registration-container">
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
            <div class="registration-header">
                <h1><i class="fas fa-file-alt me-2"></i> Formulir Pendaftaran KKN</h1>
                <p>Isi formulir berikut dengan data yang benar dan lengkap</p>
            </div>

            <!-- Form -->
            <form class="registration-form" id="registration-form" method="post" action="{{ route('form-submit') }}">
                @csrf
                <!-- Data Akademik -->
                <div class="form-section" id="section-academic">
                    <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Data Akademik</h3>

                    <div class="info-card">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Pastikan data akademik yang Anda masukkan sesuai dengan data di sistem
                        akademik kampus.
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ipk" class="form-label required-field">IPK Terakhir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                <input type="number" class="form-control" id="ipk" name="ipk" step="0.01"
                                    min="0" max="4" placeholder="Contoh: 3.75" required
                                    value="{{ old('ipk') }}">
                            </div>
                            <div class="form-feedback" id="ipk-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label required-field">Semester</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="number" class="form-control" id="semester" name="semester"
                                    min="1" max="14" placeholder="Masukkan semester" required
                                    value="{{ old('semester') }}">
                            </div>
                            <div class="form-feedback" id="semester-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label required-field">Kloter</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                <select name="kloter" id="kloter" class="form-control">
                                    <option value="" disabled selected>--- Pilih Kloter ---</option>
                                    @foreach ($kloter as $kl)
                                        <option value="{{ $kl->schedule_id }}">{{ $kl->kloter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-feedback" id="semester-feedback"></div>
                        </div>
                    </div>
                </div>

                <!-- Pernyataan -->
                <div class="form-section" id="section-statement">
                    <h3 class="section-title"><i class="fas fa-check-circle"></i> Pernyataan</h3>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="statement" required
                            {{ old('statement') ? 'checked' : '' }}>
                        <label class="form-check-label" for="statement">
                            Saya menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan. Saya
                            bersedia mengikuti seluruh kegiatan KKN sesuai dengan ketentuan yang berlaku.
                        </label>
                        <div class="invalid-feedback">
                            Anda harus menyetujui pernyataan sebelum melanjutkan.
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="registration-actions">
                    <button type="button" class="btn btn-outline-secondary" id="back-button">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </button>
                    <div>
                        <button type="button" class="btn btn-outline-secondary me-2" id="save-draft">
                            <i class="fas fa-save me-2"></i> Simpan Draft
                        </button>
                        <button type="submit" class="btn btn-primary-custom" id="submit-form">
                            <i class="fas fa-paper-plane me-2"></i> Submit Pendaftaran
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
            // State untuk melacak progress
            let currentStep = 1;
            const totalSteps = 3;

            // Data kloter KKN (akan diambil dari server)
            let scheduleOptions = [];

            // Validasi IPK
            function validateIPK(ipk) {
                return ipk >= 0 && ipk <= 4;
            }

            // Validasi SKS
            function validateSKS(sks) {
                return sks >= 0 && sks <= 200;
            }

            // Validasi Semester
            function validateSemester(semester) {
                return semester >= 1 && semester <= 14;
            }

            // Update progress bar
            function updateProgressBar() {
                const progressPercentage = (currentStep - 1) / (totalSteps - 1) * 100;
                $('#progress-bar').css('width', progressPercentage + '%');

                // Update step indicators
                $('.progress-step').removeClass('active completed');

                for (let i = 1; i <= totalSteps; i++) {
                    if (i < currentStep) {
                        $('#step-' + i).addClass('completed');
                    } else if (i === currentStep) {
                        $('#step-' + i).addClass('active');
                    }
                }
            }

            // Check form sections completion
            function checkFormCompletion() {
                // Data Akademik
                const ipkValid = validateIPK(parseFloat($('#ipk').val()));
                const sksValid = validateSKS(parseInt($('#sks').val()));
                const semesterValid = validateSemester(parseInt($('#semester').val()));

                const academicDataComplete = ipkValid && sksValid && semesterValid;

                // Pilihan Kloter
                const scheduleSelected = $('#selected-schedule').val() !== '';

                // Pernyataan
                const statementComplete = $('#statement').is(':checked');

                // Update current step berdasarkan kelengkapan data
                if (statementComplete && scheduleSelected && academicDataComplete) {
                    currentStep = 3; // Konfirmasi
                } else if (academicDataComplete) {
                    currentStep = 2; // Pilihan Kloter
                } else {
                    currentStep = 1; // Data Akademik
                }

                updateProgressBar();

                // Update UI untuk validasi
                updateValidationUI();
            }

            // Update UI untuk validasi input
            function updateValidationUI() {
                // IPK
                const ipk = parseFloat($('#ipk').val());
                if (isNaN(ipk)) {
                    $('#ipk').removeClass('is-valid is-invalid');
                    $('#ipk-feedback').text('');
                } else if (validateIPK(ipk)) {
                    $('#ipk').removeClass('is-invalid').addClass('is-valid');
                    $('#ipk-feedback').text('IPK valid').removeClass('invalid-feedback').addClass('valid-feedback');
                } else {
                    $('#ipk').removeClass('is-valid').addClass('is-invalid');
                    $('#ipk-feedback').text('IPK harus antara 0.00 dan 4.00').removeClass('valid-feedback')
                        .addClass('invalid-feedback');
                }

                // SKS
                const sks = parseInt($('#sks').val());
                if (isNaN(sks)) {
                    $('#sks').removeClass('is-valid is-invalid');
                    $('#sks-feedback').text('');
                } else if (validateSKS(sks)) {
                    $('#sks').removeClass('is-invalid').addClass('is-valid');
                    $('#sks-feedback').text('Jumlah SKS valid').removeClass('invalid-feedback').addClass(
                        'valid-feedback');
                } else {
                    $('#sks').removeClass('is-valid').addClass('is-invalid');
                    $('#sks-feedback').text('Jumlah SKS harus antara 0 dan 200').removeClass('valid-feedback')
                        .addClass('invalid-feedback');
                }

                // Semester
                const semester = parseInt($('#semester').val());
                if (isNaN(semester)) {
                    $('#semester').removeClass('is-valid is-invalid');
                    $('#semester-feedback').text('');
                } else if (validateSemester(semester)) {
                    $('#semester').removeClass('is-invalid').addClass('is-valid');
                    $('#semester-feedback').text('Semester valid').removeClass('invalid-feedback').addClass(
                        'valid-feedback');
                } else {
                    $('#semester').removeClass('is-valid').addClass('is-invalid');
                    $('#semester-feedback').text('Semester harus antara 1 dan 14').removeClass('valid-feedback')
                        .addClass('invalid-feedback');
                }

                // Jadwal
                if ($('#selected-schedule').val() === '') {
                    $('#schedule-feedback').show();
                } else {
                    $('#schedule-feedback').hide();
                }
            }

            // Event listeners untuk input fields
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
                checkFormCompletion();
            });

            // Event listener untuk checkbox pernyataan
            $('#statement').on('change', function() {
                checkFormCompletion();
            });

            // Tombol refresh kloter
            $('#refresh-schedules').on('click', function() {
                loadSchedules();
            });

            // Tombol kembali
            $('#back-button').on('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateProgressBar();

                    // Scroll ke section yang sesuai
                    $('html, body').animate({
                        scrollTop: $(`#section-${getSectionName(currentStep)}`).offset().top - 100
                    }, 500);
                }
            });

            // Helper untuk mendapatkan nama section berdasarkan step
            function getSectionName(step) {
                switch (step) {
                    case 1:
                        return 'academic';
                    case 2:
                        return 'schedule';
                    case 3:
                        return 'statement';
                    default:
                        return 'academic';
                }
            }

            // Simpan draft
            $('#save-draft').on('click', function() {
                // Dalam implementasi nyata, ini akan menyimpan data sementara
                const formData = {
                    ipk: $('#ipk').val(),
                    sks: $('#sks').val(),
                    semester: $('#semester').val(),
                    schedule_id: $('#selected-schedule').val()
                };

                // Simpan ke localStorage (contoh sederhana)
                localStorage.setItem('kkn_draft', JSON.stringify(formData));

                alert(
                    'Data berhasil disimpan sebagai draft. Anda dapat melanjutkan pengisian form lain waktu.');
            });

            // Load draft jika ada
            function loadDraft() {
                const draft = localStorage.getItem('kkn_draft');
                if (draft) {
                    const formData = JSON.parse(draft);
                    $('#ipk').val(formData.ipk);
                    $('#sks').val(formData.sks);
                    $('#semester').val(formData.semester);
                    $('#selected-schedule').val(formData.schedule_id);

                    checkFormCompletion();
                }
            }

            // Submit form
            $('#registration-form').on('submit', function(e) {
                // Validasi akhir sebelum submit
                const ipkValid = validateIPK(parseFloat($('#ipk').val()));
                const sksValid = validateSKS(parseInt($('#sks').val()));
                const semesterValid = validateSemester(parseInt($('#semester').val()));
                const scheduleSelected = $('#selected-schedule').val() !== '';
                const statementChecked = $('#statement').is(':checked');

                if (!ipkValid || !sksValid || !semesterValid || !scheduleSelected || !statementChecked) {
                    e.preventDefault();
                    alert('Harap lengkapi semua data dengan benar sebelum mengirim formulir.');
                    return false;
                }

                // Tampilkan konfirmasi
                if (!confirm('Apakah Anda yakin ingin mengirim formulir pendaftaran KKN?')) {
                    e.preventDefault();
                    return false;
                }

                // Tampilkan loading state
                $('#submit-form').html('<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...').prop(
                    'disabled', true);

                // Hapus draft setelah submit berhasil
                localStorage.removeItem('kkn_draft');
            });

            // Initialize
            loadSchedules();
            loadDraft();
            updateProgressBar();
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
