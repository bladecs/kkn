@extends('dashboard.mahasiswa.layouts.app')

@section('title', 'Formulir Project KKN - Sistem Informasi KKN')

@section('style')
    <style>
        .form-container {
            width: 100%;
            margin: 0 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .form-header {
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .form-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .form-card {
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-color);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            background: #f8f9fa;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
            background: #f0f8ff;
        }

        .file-upload-area i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .file-upload-text {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .file-upload-hint {
            font-size: 0.85rem;
            color: #868e96;
        }

        .file-preview {
            margin-top: 15px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 8px;
            display: none;
        }

        .file-preview.show {
            display: block;
        }

        .file-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .file-size {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .btn-remove-file {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .form-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            width: 100%;
        }

        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            color: #0c5460;
        }

        .address-preview {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            font-style: italic;
            color: #495057;
            min-height: 50px;
            display: flex;
            align-items: center;
        }

        .address-preview.empty {
            color: #6c757d;
            font-style: normal;
        }

        .progress-bar {
            background: var(--primary-color);
        }

        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }

            .file-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="form-container">
            <!-- Header -->
            <div class="form-header">
                <h1><i class="fas fa-project-diagram me-2"></i> Formulir Pengajuan Project KKN</h1>
                <p>Ajukan project KKN Anda dengan mengisi formulir berikut</p>
            </div>

            <!-- Info Alert -->
            <div class="alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Pastikan semua data yang Anda masukkan sudah benar sebelum mengajukan project
                KKN.
                Data yang sudah diajukan tidak dapat diubah tanpa persetujuan admin.
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <form id="projectForm" action="{{ route('submit-project') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Data Mahasiswa -->
                    <h3 class="section-title"><i class="fas fa-user-graduate"></i> Data Mahasiswa</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $data_diri->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> NIM</label>
                                <input type="text" class="form-control" value="{{ $data_diri->nim }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-university"></i> Program Studi</label>
                                <input type="text" class="form-control" value="{{ $data_diri->study_program }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-users"></i> Kelompok KKN</label>
                                <input type="text" class="form-control"
                                    value="{{ $data_pendaftaran->kelompok ?? 'Belum ditentukan' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Data Project -->
                    <h3 class="section-title"><i class="fas fa-project-diagram"></i> Data Project KKN</h3>

                    <div class="form-group">
                        <label for="judul_project" class="form-label required-field">
                            <i class="fas fa-heading"></i> Judul Project KKN
                        </label>
                        <input type="text" class="form-control" id="judul_project" name="judul_project"
                            placeholder="Masukkan judul project KKN Anda" required value="{{ old('judul_project') }}">
                        <div class="form-text">Contoh: "Pemanfaatan Teknologi IoT untuk Smart Farming di Desa XYZ"</div>
                    </div>

                    <!-- Lokasi KKN -->
                    <h4 class="mt-4 mb-3" style="color: var(--primary-color);">
                        <i class="fas fa-map-marked-alt me-2"></i>Lokasi Pelaksanaan KKN
                    </h4>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="lokasi" class="form-label required-field">
                                    <i class="fas fa-home"></i> Lokasi Desa/Kelurahan
                                </label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    placeholder="Contoh: Desa Mekarwangi" required value="{{ old('desa') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jalan" class="form-label required-field">
                                    <i class="fas fa-road"></i> Jalan
                                </label>
                                <input type="text" class="form-control" id="jalan" name="jalan"
                                    placeholder="Contoh: Jl. Merdeka No. 123" required value="{{ old('jalan') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kota" class="form-label required-field">
                                    <i class="fas fa-city"></i> Kota/Kabupaten
                                </label>
                                <input type="text" class="form-control" id="kota" name="kota"
                                    placeholder="Contoh: Bandung" required value="{{ old('kota') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinsi" class="form-label required-field">
                                    <i class="fas fa-map"></i> Provinsi
                                </label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    placeholder="Contoh: Jawa Barat" required value="{{ old('provinsi') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Lengkap (Readonly) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-location-arrow"></i> Alamat Lengkap (Otomatis)
                        </label>
                        <div id="alamat_lengkap_preview" class="address-preview empty">
                            Alamat lengkap akan muncul di sini saat Anda mengisi form di atas
                        </div>
                        <input type="hidden" id="alamat_lengkap" name="alamat" value="{{ old('alamat_lengkap') }}">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_project" class="form-label required-field">
                            <i class="fas fa-file-alt"></i> Deskripsi Singkat Project KKN
                        </label>
                        <textarea class="form-control" id="deskripsi_project" name="deskripsi_project"
                            placeholder="Jelaskan secara singkat tentang project KKN yang akan dilakukan, tujuan, dan manfaatnya..."
                            rows="5" required>{{ old('deskripsi_project') }}</textarea>
                        <div class="form-text">Minimal 200 karakter. Jelaskan latar belakang, tujuan, dan manfaat project.
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                Karakter: <span id="charCount">0</span>/200
                            </small>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <h3 class="section-title"><i class="fas fa-file-upload"></i> Upload Dokumen</h3>

                    <!-- Proposal KKN -->
                    <div class="form-group">
                        <label class="form-label required-field">
                            <i class="fas fa-file-pdf"></i> Proposal KKN
                        </label>
                        <div class="file-upload-area" id="proposalUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="file-upload-text">Klik untuk upload proposal KKN</div>
                            <div class="file-upload-hint">Format: PDF (Maks. 5MB)</div>
                            <input type="file" id="proposal_kkn" name="proposal_kkn" accept=".pdf"
                                style="display: none;" required>
                        </div>
                        <div class="file-preview" id="proposalPreview">
                            <div class="file-info">
                                <div>
                                    <div class="file-name" id="proposalFileName">-</div>
                                    <div class="file-size" id="proposalFileSize">-</div>
                                </div>
                                <button type="button" class="btn-remove-file" onclick="removeFile('proposal')">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- RAB KKN -->
                    <div class="form-group">
                        <label class="form-label required-field">
                            <i class="fas fa-calculator"></i> Rencana Anggaran Biaya (RAB) KKN
                        </label>
                        <div class="file-upload-area" id="rabUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div class="file-upload-text">Klik untuk upload RAB KKN</div>
                            <div class="file-upload-hint">Format: PDF atau Excel (Maks. 2MB)</div>
                            <input type="file" id="rab_kkn" name="rab_kkn" accept=".pdf,.xlsx,.xls"
                                style="display: none;" required>
                        </div>
                        <div class="file-preview" id="rabPreview">
                            <div class="file-info">
                                <div>
                                    <div class="file-name" id="rabFileName">-</div>
                                    <div class="file-size" id="rabFileSize">-</div>
                                </div>
                                <button type="button" class="btn-remove-file" onclick="removeFile('rab')">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar (Optional) -->
                    <div class="form-group" id="uploadProgressContainer" style="display: none;">
                        <label class="form-label"><i class="fas fa-spinner"></i> Progress Upload</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted" id="progressText">Mempersiapkan upload...</small>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                    <i class="fas fa-redo me-2"></i> Reset Form
                </button>
                <button type="submit" form="projectForm" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i> Ajukan Project
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counter for description
            const descTextarea = document.getElementById('deskripsi_project');
            const charCount = document.getElementById('charCount');

            descTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });

            // Real-time address update
            const jalanInput = document.getElementById('jalan');
            const kotaInput = document.getElementById('kota');
            const provinsiInput = document.getElementById('provinsi');
            const alamatPreview = document.getElementById('alamat_lengkap_preview');
            const alamatHidden = document.getElementById('alamat_lengkap');

            // Function to update address preview
            function updateAddressPreview() {
                const jalan = jalanInput.value.trim();
                const kota = kotaInput.value.trim();
                const provinsi = provinsiInput.value.trim();

                let alamatLengkap = '';

                if (jalan || kota || provinsi) {
                    alamatLengkap = [jalan, kota, provinsi].filter(Boolean).join(', ');
                    alamatPreview.textContent = alamatLengkap;
                    alamatPreview.classList.remove('empty');
                    alamatHidden.value = alamatLengkap;
                } else {
                    alamatPreview.textContent = 'Alamat lengkap akan muncul di sini saat Anda mengisi form di atas';
                    alamatPreview.classList.add('empty');
                    alamatHidden.value = '';
                }
            }

            // Add event listeners for real-time updates
            jalanInput.addEventListener('input', updateAddressPreview);
            kotaInput.addEventListener('input', updateAddressPreview);
            provinsiInput.addEventListener('input', updateAddressPreview);

            // Initialize address preview with existing values (if any from old input)
            updateAddressPreview();

            // File upload functionality
            setupFileUpload('proposal');
            setupFileUpload('rab');

            // Form validation
            const form = document.getElementById('projectForm');
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    showAlert('Harap lengkapi semua field yang wajib diisi!', 'error');
                }
            });

            // Auto-capitalize for location inputs
            [jalanInput, kotaInput, provinsiInput].forEach(input => {
                input.addEventListener('blur', function() {
                    this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
                    updateAddressPreview();
                });
            });
        });

        function setupFileUpload(type) {
            const uploadArea = document.getElementById(type + 'UploadArea');
            const fileInput = document.getElementById(type + '_kkn');
            const preview = document.getElementById(type + 'Preview');
            const fileName = document.getElementById(type + 'FileName');
            const fileSize = document.getElementById(type + 'FileSize');

            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });

            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);

                    fileName.textContent = file.name;
                    fileSize.textContent = fileSizeMB + ' MB';

                    // Validate file size
                    const maxSize = type === 'proposal' ? 5 : 2; // MB
                    if (fileSizeMB > maxSize) {
                        showAlert(`Ukuran file ${type} melebihi ${maxSize}MB!`, 'error');
                        this.value = '';
                        preview.classList.remove('show');
                        return;
                    }

                    // Validate file type
                    const validExtensions = type === 'proposal' ? ['.pdf'] : ['.pdf', '.xlsx', '.xls'];
                    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

                    if (!validExtensions.includes(fileExtension)) {
                        showAlert(`Format file ${type} tidak valid! Harus ${validExtensions.join(', ')}`, 'error');
                        this.value = '';
                        preview.classList.remove('show');
                        return;
                    }

                    preview.classList.add('show');
                    showAlert(`File ${type} berhasil dipilih!`, 'success');
                }
            });

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--primary-color)';
                this.style.background = '#f0f8ff';
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                this.style.background = '#f8f9fa';
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                this.style.background = '#f8f9fa';

                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });
        }

        function removeFile(type) {
            const fileInput = document.getElementById(type + '_kkn');
            const preview = document.getElementById(type + 'Preview');

            fileInput.value = '';
            preview.classList.remove('show');
        }

        function validateForm() {
            const judul = document.getElementById('judul_project').value.trim();
            const jalan = document.getElementById('jalan').value.trim();
            const kota = document.getElementById('kota').value.trim();
            const provinsi = document.getElementById('provinsi').value.trim();
            const deskripsi = document.getElementById('deskripsi_project').value.trim();
            const proposal = document.getElementById('proposal_kkn').files.length;
            const rab = document.getElementById('rab_kkn').files.length;

            if (!judul || !jalan || !kota || !provinsi || !deskripsi || deskripsi.length < 200 || !proposal || !rab) {
                return false;
            }

            return true;
        }

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mengosongkan semua field?')) {
                document.getElementById('projectForm').reset();
                document.querySelectorAll('.file-preview').forEach(preview => {
                    preview.classList.remove('show');
                });
                document.getElementById('charCount').textContent = '0';

                // Reset address preview
                const alamatPreview = document.getElementById('alamat_lengkap_preview');
                alamatPreview.textContent = 'Alamat lengkap akan muncul di sini saat Anda mengisi form di atas';
                alamatPreview.classList.add('empty');
                document.getElementById('alamat_lengkap').value = '';

                showAlert('Formulir telah direset!', 'info');
            }
        }

        function showAlert(message, type) {
            // Remove existing alerts
            const existingAlert = document.querySelector('.custom-alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            const alert = document.createElement('div');
            alert.className = `alert alert-${type === 'error' ? 'danger' : type} custom-alert`;
            alert.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            `;
            alert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                    <div>${message}</div>
                </div>
            `;

            document.body.appendChild(alert);

            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
@endsection
