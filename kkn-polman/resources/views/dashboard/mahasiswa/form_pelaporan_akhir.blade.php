@extends('dashboard.mahasiswa.layouts.app')

@section('title', 'Form Pelaporan Akhir')

@section('style')
    <style>
        /* Card Styles */
        .card {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            margin-bottom: 25px;
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), #3a6bd1);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 20px 25px;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-header .subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0 40px;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 1;
            transform: translateY(-50%);
        }

        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 120px;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .step.active .step-circle {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(30, 79, 190, 0.3);
        }

        .step.completed .step-circle {
            background-color: var(--success-color);
            color: white;
        }

        .step.completed .step-circle::after {
            content: '✓';
        }

        .step-label {
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
        }

        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Form Styles */
        .form-section {
            margin-bottom: 35px;
            padding: 25px;
            background-color: white;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 5px 0;
        }

        .section-description {
            color: #666;
            font-size: 0.95rem;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .form-label .required {
            color: var(--danger-color);
            margin-left: 3px;
        }

        .form-control, .form-select, .form-textarea {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.15);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #e0e0e0;
            color: #666;
        }

        /* File Upload Styles */
        .file-upload-card {
            border: 2px dashed #d1d9e6;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            background-color: #fafbfd;
            transition: var(--transition);
            cursor: pointer;
            margin-bottom: 20px;
        }

        .file-upload-card:hover {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
            transform: translateY(-3px);
        }

        .file-upload-card.dragover {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
            transform: scale(1.02);
        }

        .upload-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 2rem;
            border: 2px solid #e8efff;
        }

        .upload-title {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .upload-description {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .upload-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 0.85rem;
            color: #888;
        }

        .upload-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .file-list-container {
            margin-top: 25px;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
        }

        .file-item:hover {
            background-color: #f0f4ff;
            transform: translateX(5px);
        }

        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .file-info {
            flex-grow: 1;
        }

        .file-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
            word-break: break-word;
        }

        .file-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: #666;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .file-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            background-color: white;
            border: 1px solid #e0e0e0;
            transition: var(--transition);
            cursor: pointer;
        }

        .file-action-btn:hover {
            color: white;
            transform: translateY(-2px);
        }

        .file-action-btn.preview:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .file-action-btn.delete:hover {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        /* Custom Radio and Checkbox */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: #555;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-outline-secondary {
            border-color: #ccc;
            color: #666;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #555;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        /* Alert Styles */
        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-custom i {
            font-size: 1.5rem;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .progress-steps {
                flex-direction: column;
                gap: 25px;
            }
            
            .progress-steps::before {
                display: none;
            }
            
            .step {
                width: 100%;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn {
                width: 100%;
            }
            
            .toast {
                min-width: 250px;
                max-width: 300px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        <!-- Main Form -->
        <div class="row">
            <div class="col-12">
                <form id="laporanAkhirForm" action="{{ route('submit-laporan-akhir') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Card: Informasi Dasar -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-graduate me-2"></i> Informasi Dasar</h3>
                            <div class="subtitle">Data pribadi dan kelompok KKN</div>
                        </div>
                        <div class="card-body">
                            <div class="form-section">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title">Data Mahasiswa</h4>
                                        <p class="section-description">Informasi pribadi mahasiswa pelapor</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user-circle me-2"></i> Nama Lengkap
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                value="{{ $data_diri->name }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="nim" class="form-label">
                                            <i class="fas fa-id-card me-2"></i> NIM
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                            <input type="text" class="form-control" id="nim" name="nim" 
                                                value="{{ $data_diri->nim }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="prodi" class="form-label">
                                            <i class="fas fa-graduation-cap me-2"></i> Program Studi
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                                            <input type="text" class="form-control" id="prodi" name="prodi" 
                                                value="{{ $data_diri->prodi->nama_prodi }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="fakultas" class="form-label">
                                            <i class="fas fa-building me-2"></i> Fakultas
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-landmark"></i></span>
                                            <input type="text" class="form-control" id="fakultas" name="fakultas" 
                                                value="{{ $data_diri->jurusan->nama_jurusan }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <div class="section-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title">Data Kelompok KKN</h4>
                                        <p class="section-description">Informasi kelompok dan pembimbing</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="kelompok" class="form-label">
                                            <i class="fas fa-users me-2"></i> Nama Kelompok
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            <input type="text" class="form-control" id="kelompok" name="kelompok" 
                                                value="{{ $anggotaKelompok->kelompok->detailKelompok->first()->nama_kelompok }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="lokasi" class="form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i> Lokasi KKN
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                            <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                                value="{{ $anggotaKelompok->kelompok->detailKelompok->first()->project->lokasi->nama_lokasi }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="pembimbing" class="form-label">
                                            <i class="fas fa-chalkboard-teacher me-2"></i> Dosen Pembimbing
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <input type="text" class="form-control" id="pembimbing" name="pembimbing" 
                                                value="{{ $anggotaKelompok->kelompok->pembimbingDosen->name }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-4">
                                        <label for="tanggal_laporan" class="form-label">
                                            <i class="fas fa-calendar me-2"></i> Tanggal Laporan<span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                            <input type="date" class="form-control" id="tanggal_laporan" name="tanggal_laporan" required 
                                                   value="{{ \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Dokumen Utama -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-file-alt me-2"></i> Dokumen Utama</h3>
                            <div class="subtitle">Upload dokumen laporan akhir dan presentasi</div>
                        </div>
                        <div class="card-body">
                            <!-- Laporan Utama -->
                            <div class="form-section">
                                <div class="section-header">
                                    <div class="section-icon" style="background-color: #ffeaea; color: #dc3545;">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title">Laporan Akhir (PDF) <span class="required">*</span></h4>
                                        <p class="section-description">Upload laporan akhir dalam format PDF sesuai template</p>
                                    </div>
                                </div>

                                <div class="alert alert-custom alert-warning bg-light-warning">
                                    <i class="fas fa-exclamation-circle text-warning"></i>
                                    <div>
                                        <strong>Penting!</strong> File harus dalam format PDF, maksimal 20MB. Pastikan laporan sudah sesuai dengan pedoman penulisan dan telah diperiksa oleh pembimbing.
                                    </div>
                                </div>

                                <div class="file-upload-card" id="laporanUtamaArea">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <h5 class="upload-title">Unggah Laporan Akhir</h5>
                                    <p class="upload-description">
                                        Seret file PDF ke sini atau klik untuk memilih dari komputer Anda
                                    </p>
                                    <div class="upload-meta">
                                        <span><i class="fas fa-file-pdf"></i> Format: PDF</span>
                                        <span><i class="fas fa-weight-hanging"></i> Maks: 20MB</span>
                                        <span><i class="fas fa-file-alt"></i> Min: 30 halaman</span>
                                    </div>
                                    <input type="file" id="laporan_pdf" name="laporan_pdf" style="display: none;" accept=".pdf" required>
                                </div>

                                <div class="file-list-container" id="laporanUtamaList"></div>
                            </div>

                            <!-- Presentasi -->
                            <div class="form-section">
                                <div class="section-header">
                                    <div class="section-icon" style="background-color: #fff3e0; color: #ff9800;">
                                        <i class="fas fa-file-powerpoint"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title">File Presentasi <span class="required">*</span></h4>
                                        <p class="section-description">Upload slide presentasi hasil KKN</p>
                                    </div>
                                </div>

                                <div class="alert alert-custom alert-info bg-light-info">
                                    <i class="fas fa-info-circle text-info"></i>
                                    <div>
                                        <strong>Catatan:</strong> Format file bisa PPT, PPTX, atau PDF. Maksimal ukuran file 30MB.
                                    </div>
                                </div>

                                <div class="file-upload-card" id="presentasiArea">
                                    <div class="upload-icon">
                                        <i class="fas fa-desktop"></i>
                                    </div>
                                    <h5 class="upload-title">Unggah Slide Presentasi</h5>
                                    <p class="upload-description">
                                        Seret file presentasi ke sini atau klik untuk memilih
                                    </p>
                                    <div class="upload-meta">
                                        <span><i class="fas fa-file-powerpoint"></i> Format: PPT/PPTX/PDF</span>
                                        <span><i class="fas fa-weight-hanging"></i> Maks: 30MB</span>
                                        <span><i class="fas fa-image"></i> Rekomendasi: 15-20 slide</span>
                                    </div>
                                    <input type="file" id="presentasi" name="presentasi" style="display: none;" 
                                           accept=".ppt,.pptx,.pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation" required>
                                </div>

                                <div class="file-list-container" id="presentasiList"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Lampiran -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-paperclip me-2"></i> Lampiran</h3>
                            <div class="subtitle">Dokumen pendukung dan bukti fisik kegiatan</div>
                        </div>
                        <div class="card-body">
                            <!-- Informasi Tambahan -->
                            <div class="form-section">
                                <div class="section-header">
                                    <div class="section-icon" style="background-color: #f3e5f5; color: #9c27b0;">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title">Informasi Tambahan</h4>
                                        <p class="section-description">Penjelasan atau catatan tambahan tentang laporan</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="catatan" class="form-label">
                                        <i class="fas fa-comment-alt me-2"></i> Catatan untuk Reviewer
                                    </label>
                                    <textarea class="form-control form-textarea" id="catatan" 
                                              name="catatan" rows="4"
                                              placeholder="Berikan penjelasan tambahan jika diperlukan..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="link_tambahan" class="form-label">
                                        <i class="fas fa-link me-2"></i> Link Tambahan
                                    </label>
                                    <input type="url" class="form-control" id="link_tambahan" 
                                           name="link_tambahan" placeholder="https://example.com/dokumen">
                                    <small class="text-muted">Contoh: Link Google Drive, YouTube, atau website terkait</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="action-buttons">
                                <div class="left-buttons">
                                    <button type="button" class="btn btn-outline-secondary" id="saveDraftBtn">
                                        <i class="fas fa-save"></i> Simpan Draft
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                                        <i class="fas fa-redo"></i> Reset Form
                                    </button>
                                </div>
                                <div class="right-buttons">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload configuration
            const uploadConfig = {
                laporanUtama: {
                    maxSize: 20 * 1024 * 1024, // 20MB
                    allowedTypes: ['application/pdf'],
                    file: null
                },
                presentasi: {
                    maxSize: 30 * 1024 * 1024, // 30MB
                    allowedTypes: [
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/pdf',
                        'application/zip'
                    ],
                    file: null
                }
            };

            // Initialize file uploads
            initializeFileUpload('laporanUtama');
            initializeFileUpload('presentasi');

            // Form validation
            initializeFormValidation();

            // Button event handlers
            document.getElementById('saveDraftBtn').addEventListener('click', saveDraft);
            document.getElementById('resetBtn').addEventListener('click', resetForm);
            document.getElementById('laporanAkhirForm').addEventListener('submit', submitForm);

            // Helper functions
            function initializeFileUpload(section) {
                const area = document.getElementById(`${section}Area`);
                const input = document.getElementById(section === 'laporanUtama' ? 'laporan_pdf' : 'presentasi');
                const list = document.getElementById(`${section}List`);

                // Click to upload
                area.addEventListener('click', () => input.click());

                // Drag and drop
                area.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    area.classList.add('dragover');
                });

                area.addEventListener('dragleave', () => {
                    area.classList.remove('dragover');
                });

                area.addEventListener('drop', (e) => {
                    e.preventDefault();
                    area.classList.remove('dragover');
                    handleFiles(e.dataTransfer.files, section);
                });

                input.addEventListener('change', (e) => {
                    handleFiles(e.target.files, section);
                });
            }

            function handleFiles(files, section) {
                const config = uploadConfig[section];
                const list = document.getElementById(`${section}List`);
                const input = document.getElementById(section === 'laporanUtama' ? 'laporan_pdf' : 'presentasi');
                
                if (files.length > 0) {
                    const file = files[0];
                    if (validateFile(file, config)) {
                        config.file = file;
                        
                        // Update file input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        
                        list.innerHTML = createFileItem(file, section);
                        showToast('success', `File "${file.name}" berhasil diunggah`);
                    }
                }
            }

            function validateFile(file, config) {
                // Check file size
                if (file.size > config.maxSize) {
                    showToast('error', `File "${file.name}" terlalu besar. Maksimal ${formatSize(config.maxSize)}`);
                    return false;
                }

                // Check file type
                if (!config.allowedTypes.includes(file.type)) {
                    showToast('error', `Format file "${file.name}" tidak didukung`);
                    return false;
                }

                return true;
            }

            function createFileItem(file, section) {
                const element = createFileElement(file, section);
                return element.outerHTML;
            }

            function createFileElement(file, section) {
                const div = document.createElement('div');
                div.className = 'file-item';
                
                const icon = getFileIcon(file.type);
                const size = formatSize(file.size);
                
                div.innerHTML = `
                    <div class="file-icon">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-meta">
                            <span>${size}</span>
                            <span>${new Date().toLocaleDateString()}</span>
                        </div>
                    </div>
                    <div class="file-actions">
                        <div class="file-action-btn preview" title="Preview">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="file-action-btn delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                `;

                // Add event listeners
                div.querySelector('.preview').addEventListener('click', () => previewFile(file));
                div.querySelector('.delete').addEventListener('click', () => removeFile(file, section));

                return div;
            }

            function getFileIcon(mimeType) {
                if (mimeType === 'application/pdf') return 'fa-file-pdf';
                if (mimeType.includes('powerpoint') || mimeType.includes('presentation')) return 'fa-file-powerpoint';
                return 'fa-file';
            }

            function formatSize(bytes) {
                const units = ['B', 'KB', 'MB', 'GB'];
                let size = bytes;
                let unitIndex = 0;
                
                while (size >= 1024 && unitIndex < units.length - 1) {
                    size /= 1024;
                    unitIndex++;
                }
                
                return `${size.toFixed(2)} ${units[unitIndex]}`;
            }

            function removeFile(file, section) {
                const config = uploadConfig[section];
                const input = document.getElementById(section === 'laporanUtama' ? 'laporan_pdf' : 'presentasi');
                
                config.file = null;
                input.value = '';
                
                document.getElementById(`${section}List`).innerHTML = '';
                showToast('info', 'File berhasil dihapus');
            }

            function previewFile(file) {
                const url = URL.createObjectURL(file);
                window.open(url, '_blank');
                URL.revokeObjectURL(url);
            }

            function initializeFormValidation() {
                const form = document.getElementById('laporanAkhirForm');
                
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        showToast('error', 'Harap lengkapi semua field yang wajib diisi');
                    }
                });

                // Real-time validation
                document.getElementById('tanggal_laporan').addEventListener('change', function() {
                    if (!this.value) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                ['laporan_pdf', 'presentasi'].forEach(inputId => {
                    const input = document.getElementById(inputId);
                    input.addEventListener('change', function() {
                        if (!this.files.length) {
                            this.classList.add('is-invalid');
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
            }

            function validateForm() {
                let isValid = true;
                
                // Check tanggal laporan
                const tanggalLaporan = document.getElementById('tanggal_laporan');
                if (!tanggalLaporan.value) {
                    scrollToElement('tanggal_laporan');
                    tanggalLaporan.classList.add('is-invalid');
                    isValid = false;
                }

                // Check file uploads
                const laporanPdf = document.getElementById('laporan_pdf');
                if (!laporanPdf.files.length) {
                    scrollToElement('laporanUtamaArea');
                    laporanPdf.classList.add('is-invalid');
                    isValid = false;
                }

                const presentasi = document.getElementById('presentasi');
                if (!presentasi.files.length) {
                    scrollToElement('presentasiArea');
                    presentasi.classList.add('is-invalid');
                    isValid = false;
                }

                return isValid;
            }

            function scrollToElement(elementId) {
                const element = document.getElementById(elementId);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    element.focus();
                    
                    // Add highlight effect
                    element.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.3)';
                    setTimeout(() => {
                        element.style.boxShadow = '';
                    }, 3000);
                }
            }

            function saveDraft() {
                // Simpan data form ke localStorage
                const formData = {
                    tanggal_laporan: document.getElementById('tanggal_laporan').value,
                    catatan: document.getElementById('catatan').value,
                    link_tambahan: document.getElementById('link_tambahan').value,
                    files: {
                        laporan_pdf: uploadConfig.laporanUtama.file ? uploadConfig.laporanUtama.file.name : null,
                        presentasi: uploadConfig.presentasi.file ? uploadConfig.presentasi.file.name : null
                    }
                };
                
                localStorage.setItem('laporanAkhirDraft', JSON.stringify(formData));
                showToast('success', 'Draft berhasil disimpan di browser Anda');
                
                // Simulate API call feedback
                const btn = document.getElementById('saveDraftBtn');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                btn.disabled = true;
                
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }, 1500);
            }

            function resetForm() {
                if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang belum disimpan akan hilang.')) {
                    // Reset form fields
                    document.getElementById('laporanAkhirForm').reset();
                    
                    // Clear file uploads
                    uploadConfig.laporanUtama.file = null;
                    uploadConfig.presentasi.file = null;
                    
                    // Clear file lists
                    document.getElementById('laporanUtamaList').innerHTML = '';
                    document.getElementById('presentasiList').innerHTML = '';
                    
                    showToast('info', 'Form telah direset');
                }
            }

            function previewForm() {
                if (validateForm()) {
                    // Collect form data for preview
                    const previewData = {
                        name: document.getElementById('name').value,
                        nim: document.getElementById('nim').value,
                        kelompok: document.getElementById('kelompok').value,
                        tanggal_laporan: document.getElementById('tanggal_laporan').value,
                        catatan: document.getElementById('catatan').value,
                        files: {
                            laporan_pdf: uploadConfig.laporanUtama.file ? uploadConfig.laporanUtama.file.name : 'Belum diupload',
                            presentasi: uploadConfig.presentasi.file ? uploadConfig.presentasi.file.name : 'Belum diupload'
                        }
                    };
                    
                    // Create preview modal
                    const modalHtml = `
                        <div class="modal fade" id="previewModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Preview Laporan Akhir</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Data Mahasiswa</h6>
                                                <p><strong>Nama:</strong> ${previewData.name}</p>
                                                <p><strong>NIM:</strong> ${previewData.nim}</p>
                                                <p><strong>Kelompok:</strong> ${previewData.kelompok}</p>
                                                <p><strong>Tanggal Laporan:</strong> ${previewData.tanggal_laporan}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Dokumen</h6>
                                                <p><strong>Laporan PDF:</strong> ${previewData.files.laporan_pdf}</p>
                                                <p><strong>Presentasi:</strong> ${previewData.files.presentasi}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h6>Catatan</h6>
                                            <p>${previewData.catatan || 'Tidak ada catatan'}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('laporanAkhirForm').submit()">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Add modal to body
                    const modalDiv = document.createElement('div');
                    modalDiv.innerHTML = modalHtml;
                    document.body.appendChild(modalDiv);
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
                    modal.show();
                    
                    // Remove modal from DOM after hiding
                    document.getElementById('previewModal').addEventListener('hidden.bs.modal', function() {
                        modalDiv.remove();
                    });
                }
            }

            function submitForm(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    return;
                }
                
                // Show confirmation
                if (!confirm('Apakah Anda yakin ingin mengirim laporan akhir? Setelah dikirim, data tidak dapat diubah.')) {
                    return;
                }
                
                // Show loading state
                const btn = document.getElementById('submitBtn');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                btn.disabled = true;
                
                // Submit form via AJAX
                const form = document.getElementById('laporanAkhirForm');
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log(response);
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message || 'Laporan berhasil dikirim!');
                        
                        // Remove draft from localStorage
                        localStorage.removeItem('laporanAkhirDraft');
                        
                        // Redirect after success
                        setTimeout(() => {
                            window.location.href = data.redirect_url || '{{ route("dashboard_mhs") }}';
                        }, 2000);
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', error.message || 'Gagal mengirim laporan. Silakan coba lagi.');
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                });
            }

            function showToast(type, message) {
                const toastContainer = document.querySelector('.toast-container');
                const toastId = 'toast-' + Date.now();
                
                const toast = document.createElement('div');
                toast.className = `toast show`;
                toast.id = toastId;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                
                const bgColor = type === 'success' ? 'bg-success' :
                               type === 'error' ? 'bg-danger' :
                               type === 'warning' ? 'bg-warning' : 'bg-info';
                
                const icon = type === 'success' ? 'fa-check-circle' :
                            type === 'error' ? 'fa-exclamation-circle' :
                            type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
                
                toast.innerHTML = `
                    <div class="toast-header ${bgColor} text-white">
                        <i class="fas ${icon} me-2"></i>
                        <strong class="me-auto">${type === 'success' ? 'Sukses' : 
                                                type === 'error' ? 'Error' : 
                                                type === 'warning' ? 'Peringatan' : 'Info'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                `;
                
                toastContainer.appendChild(toast);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (document.getElementById(toastId)) {
                        document.getElementById(toastId).remove();
                    }
                }, 5000);
                
                // Close button functionality
                toast.querySelector('.btn-close').addEventListener('click', () => {
                    toast.remove();
                });
            }

            // Load draft from localStorage on page load
            function loadDraft() {
                const draft = localStorage.getItem('laporanAkhirDraft');
                if (draft) {
                    try {
                        const draftData = JSON.parse(draft);
                        
                        document.getElementById('tanggal_laporan').value = draftData.tanggal_laporan || '';
                        document.getElementById('catatan').value = draftData.catatan || '';
                        document.getElementById('link_tambahan').value = draftData.link_tambahan || '';
                        
                        showToast('info', 'Draft ditemukan. Anda dapat melanjutkan pengisian form.');
                    } catch (e) {
                        console.error('Error loading draft:', e);
                    }
                }
            }

            // Initialize
            loadDraft();
        });

        // Global function for modal submission
        window.submitLaporan = function() {
            document.getElementById('laporanAkhirForm').submit();
        };
    </script>
@endsection