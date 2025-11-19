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
        }

        .registration-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .registration-header p {
            color: #6c757d;
            margin-bottom: 0;
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
            background-color: var(--primary-color);
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
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .step-label {
            font-size: 0.8rem;
            text-align: center;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .progress-step.active .step-number {
            background-color: var(--primary-color);
            color: white;
        }

        .progress-step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .progress-step.completed .step-number {
            background-color: #28a745;
            color: white;
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

        .file-upload-card {
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #f8f9fa;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .file-upload-card:hover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
        }

        .file-upload-card.uploaded {
            border-color: #28a745;
            background-color: #f8fff9;
        }

        .file-upload-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-upload-card.uploaded i {
            color: #28a745;
        }

        .file-upload-card h6 {
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .file-upload-card p {
            color: #6c757d;
            margin-bottom: 10px;
            font-size: 0.85rem;
        }

        .file-upload-card .badge {
            font-size: 0.7rem;
        }

        .file-input-hidden {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .uploaded-file-info {
            margin-top: 10px;
            padding: 8px;
            background: white;
            border-radius: 5px;
            width: 100%;
        }

        .uploaded-file-name {
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 5px;
            word-break: break-word;
        }

        .uploaded-file-size {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .remove-file {
            color: #dc3545;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .optional-badge {
            background-color: #6c757d;
        }

        .folder-upload-section {
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            position: relative;
        }

        .folder-upload-section:hover {
            border-color: var(--primary-color);
            background-color: var(--light-color);
        }

        .folder-upload-section i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .folder-upload-section h5 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .folder-upload-section p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .folder-input-hidden {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .browser-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            font-size: 0.8rem;
            color: #856404;
        }

        @media (max-width: 768px) {
            .registration-actions {
                flex-direction: column;
                gap: 15px;
            }

            .registration-actions .btn {
                width: 100%;
            }

            .file-upload-card {
                margin-bottom: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="registration-container">
            <!-- Header -->
            <div class="registration-header">
                <h1><i class="fas fa-file-alt me-2"></i> Formulir Pendaftaran KKN</h1>
                <p>Isi formulir berikut dengan data yang benar dan lengkap</p>
            </div>

            <!-- Progress -->
            <div class="registration-progress">
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
                <div class="progress-label">
                    <div class="progress-step active" id="step-1">
                        <div class="step-number">1</div>
                        <div class="step-label">Data Akademik</div>
                    </div>
                    <div class="progress-step" id="step-2">
                        <div class="step-number">2</div>
                        <div class="step-label">Upload Berkas</div>
                    </div>
                    <div class="progress-step" id="step-3">
                        <div class="step-number">3</div>
                        <div class="step-label">Konfirmasi</div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form class="registration-form" id="registration-form" method="post" action="{{ route('form-submit') }}"
                enctype="multipart/form-data">
                @csrf
                <!-- Data Akademik -->
                <div class="form-section" id="section-academic">
                    <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Data Akademik</h3>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ipk" class="form-label required-field">IPK Terakhir</label>
                            <input type="number" class="form-control" id="ipk" name="ipk" step="0.01"
                                min="0" max="4" placeholder="Contoh: 3.75" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sks" class="form-label required-field">Jumlah SKS</label>
                            <input type="number" class="form-control" id="sks" name="sks" min="0"
                                placeholder="Masukkan jumlah SKS" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="semester" class="form-label required-field">Semester</label>
                            <input type="number" class="form-control" id="semester" name="semester" min="1"
                                max="14" placeholder="Masukkan semester" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label required-field">Status Mahasiswa</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status-mhs" id="status-regular"
                                        value="regular" checked>
                                    <label class="form-check-label" for="status-regular">
                                        Reguler
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status-mhs" id="status-transfer"
                                        value="transfer">
                                    <label class="form-check-label" for="status-transfer">
                                        Transfer
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status-mhs" id="status-other"
                                        value="other">
                                    <label class="form-check-label" for="status-other">
                                        Lainnya
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Berkas -->
                <div class="form-section" id="section-files">
                    <h3 class="section-title"><i class="fas fa-file-upload"></i> Upload Berkas</h3>

                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Informasi:</strong> Upload berkas-berkas berikut sesuai dengan ketentuan yang
                                berlaku.
                                File KTM, Foto Formal, dan Proposal Pengajuan wajib diunggah.
                            </div>
                        </div>
                    </div>

                    <div class="row" id="individual-uploads">
                        <!-- KTM -->
                        <div class="col-md-6 mb-4">
                            <div class="file-upload-card" id="ktm-card">
                                <i class="fas fa-id-card"></i>
                                <h6>Kartu Tanda Mahasiswa (KTM)</h6>
                                <span class="badge bg-danger">Wajib</span>
                                <p>Scan KTM yang masih berlaku<br><small>Format: JPG/PNG/PDF (Maks. 2MB)</small></p>
                                <input type="file" class="file-input-hidden" id="ktm-input" name="ktm"
                                    accept="image/*,.pdf">
                            </div>
                            <div class="uploaded-file-info" id="ktm-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="uploaded-file-name" id="ktm-name"></div>
                                        <div class="uploaded-file-size" id="ktm-size"></div>
                                    </div>
                                    <i class="fas fa-times remove-file" data-target="ktm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Foto Formal -->
                        <div class="col-md-6 mb-4">
                            <div class="file-upload-card" id="photo-card">
                                <i class="fas fa-camera"></i>
                                <h6>Foto Formal</h6>
                                <span class="badge bg-danger">Wajib</span>
                                <p>Foto formal latar belakang merah<br><small>Format: JPG/PNG (Maks. 2MB)</small></p>
                                <input type="file" class="file-input-hidden" id="photo-input" name="photo"
                                    accept="image/*">
                            </div>
                            <div class="uploaded-file-info" id="photo-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="uploaded-file-name" id="photo-name"></div>
                                        <div class="uploaded-file-size" id="photo-size"></div>
                                    </div>
                                    <i class="fas fa-times remove-file" data-target="photo"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Proposal Pengajuan -->
                        <div class="col-md-6 mb-4">
                            <div class="file-upload-card" id="proposal-card">
                                <i class="fas fa-file-alt"></i>
                                <h6>Proposal Pengajuan KKN</h6>
                                <span class="badge bg-danger">Wajib</span>
                                <p>Proposal kegiatan KKN<br><small>Format: PDF (Maks. 5MB)</small></p>
                                <input type="file" class="file-input-hidden" id="proposal-input" name="proposal"
                                    accept=".pdf">
                            </div>
                            <div class="uploaded-file-info" id="proposal-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="uploaded-file-name" id="proposal-name"></div>
                                        <div class="uploaded-file-size" id="proposal-size"></div>
                                    </div>
                                    <i class="fas fa-times remove-file" data-target="proposal"></i>
                                </div>
                            </div>
                        </div>

                        <!-- RAB (Opsional) -->
                        <div class="col-md-6 mb-4">
                            <div class="file-upload-card" id="rab-card">
                                <i class="fas fa-calculator"></i>
                                <h6>Rencana Anggaran Biaya (RAB)</h6>
                                <span class="badge optional-badge">Opsional</span>
                                <p>RAB kegiatan KKN<br><small>Format: PDF (Maks. 2MB)</small></p>
                                <input type="file" class="file-input-hidden" id="rab-input" name="rab"
                                    accept=".pdf">
                            </div>
                            <div class="uploaded-file-info" id="rab-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="uploaded-file-name" id="rab-name"></div>
                                        <div class="uploaded-file-size" id="rab-size"></div>
                                    </div>
                                    <i class="fas fa-times remove-file" data-target="rab"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pernyataan -->
                <div class="form-section" id="section-statement">
                    <h3 class="section-title"><i class="fas fa-check-circle"></i> Pernyataan</h3>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="statement" required>
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

            // Cek browser support untuk upload folder
            function checkFolderUploadSupport() {
                const input = document.createElement('input');
                input.type = 'file';
                const isSupported = 'webkitdirectory' in input || 'directory' in input;

                if (!isSupported) {
                    $('#browser-warning').show();
                }
                return isSupported;
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
                const academicDataComplete =
                    $('#ipk').val() &&
                    $('#sks').val() &&
                    $('#semester').val();

                // Upload Berkas (hanya yang wajib)
                const ktmUploaded = $('#ktm-card').hasClass('uploaded');
                const photoUploaded = $('#photo-card').hasClass('uploaded');
                const proposalUploaded = $('#proposal-card').hasClass('uploaded');
                const filesComplete = ktmUploaded && photoUploaded && proposalUploaded;

                // Pernyataan
                const statementComplete = $('#statement').is(':checked');

                // Update current step berdasarkan kelengkapan data
                if (statementComplete && filesComplete && academicDataComplete) {
                    currentStep = 3; // Konfirmasi
                } else if (academicDataComplete) {
                    currentStep = 2; // Berkas Persyaratan
                } else {
                    currentStep = 1; // Data Akademik
                }

                updateProgressBar();
            }

            // Folder upload functionality - FIXED
            $('#folder-input').on('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    processFolderFiles(files);
                }
            });

            function processFolderFiles(files) {
                // Reset semua upload sebelumnya
                $('.file-upload-card').removeClass('uploaded');
                $('.uploaded-file-info').hide();
                $('.file-input-hidden').val('');

                // Mapping nama file ke input yang sesuai
                const fileMapping = {
                    'ktm': ['ktm', 'kartu_mahasiswa', 'kartu_tanda_mahasiswa'],
                    'photo': ['foto', 'photo', 'pas_foto', 'formal'],
                    'proposal': ['proposal', 'pengajuan', 'kkn_proposal'],
                    'rab': ['rab', 'anggaran', 'biaya', 'rincian']
                };

                // Proses setiap file
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileName = file.name.toLowerCase();

                    // Cari input yang sesuai berdasarkan nama file
                    let targetType = null;

                    for (const [type, keywords] of Object.entries(fileMapping)) {
                        if (keywords.some(keyword => fileName.includes(keyword))) {
                            targetType = type;
                            break;
                        }
                    }

                    if (targetType) {
                        // Update UI untuk file yang sesuai
                        const card = $(`#${targetType}-card`);
                        const info = $(`#${targetType}-info`);
                        const nameElement = $(`#${targetType}-name`);
                        const sizeElement = $(`#${targetType}-size`);

                        card.addClass('uploaded');
                        nameElement.text(file.name);
                        sizeElement.text(formatFileSize(file.size));
                        info.show();

                        // Simpan file reference (dalam implementasi nyata, ini akan di-handle oleh form submission)
                        console.log(`File ${targetType} ditemukan:`, file.name);
                    }
                }

                checkFormCompletion();
                alert(
                    'File dari folder berhasil diproses! Silakan periksa apakah semua file sudah terupload dengan benar.'
                    );
            }

            // File upload functionality untuk semua card individual - FIXED
            $('.file-input-hidden').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const inputId = $(this).attr('id');
                    const fileType = inputId.replace('-input', '');

                    const card = $(`#${fileType}-card`);
                    const info = $(`#${fileType}-info`);
                    const nameElement = $(`#${fileType}-name`);
                    const sizeElement = $(`#${fileType}-size`);

                    // Update card appearance
                    card.addClass('uploaded');

                    // Update file info
                    nameElement.text(file.name);
                    sizeElement.text(formatFileSize(file.size));
                    info.show();

                    checkFormCompletion();
                }
            });

            // Remove file functionality - FIXED
            $(document).on('click', '.remove-file', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const target = $(this).data('target');
                const card = $(`#${target}-card`);
                const info = $(`#${target}-info`);
                const input = $(`#${target}-input`);

                // Reset
                card.removeClass('uploaded');
                input.val('');
                info.hide();

                checkFormCompletion();
            });

            // Format ukuran file
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Event listeners untuk input fields
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                checkFormCompletion();
            });

            // Event listener untuk checkbox pernyataan
            $('#statement').on('change', function() {
                checkFormCompletion();
            });

            // Initialize
            checkFolderUploadSupport();
            updateProgressBar();
        });
    </script>
@endsection
