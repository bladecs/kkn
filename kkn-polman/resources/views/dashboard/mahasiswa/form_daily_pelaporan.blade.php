@extends('dashboard.mahasiswa.layouts.app')

@section('title', 'Form Laporan Harian KKN')

@section('style')
    <style>
        .container-fluid {
            padding: 20px;
            max-width: 100%;
        }

        .main-content {
            width: 100%;
            margin: 0 auto;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 25px 30px;
        }

        .card-body {
            padding: 30px;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-right: 15px;
            background: rgba(30, 79, 190, 0.1);
            padding: 12px;
            border-radius: 10px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: #344767;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 18px;
            border: 1px solid #dce1e7;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 79, 190, 0.15);
            background-color: #fff;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 8px 20px;
            font-size: 0.9rem;
        }

        .activities-container {
            margin-top: 30px;
            padding: 25px;
            background-color: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .activity-item {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid var(--primary-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .activity-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .activity-title {
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            font-size: 1.1rem;
        }

        .activity-meta {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .activity-meta i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .activity-description {
            color: #4a5568;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .activity-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .activity-hidden-inputs {
            display: none;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #cbd5e1;
            opacity: 0.5;
        }

        .empty-state h5 {
            font-weight: 600;
            margin-bottom: 10px;
            color: #64748b;
        }

        .time-input-group {
            position: relative;
        }

        .time-unit {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 500;
            background: #f8fafc;
            padding: 0 5px;
        }

        .total-time {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        .total-time h5 {
            margin: 0;
            color: #334155;
            font-weight: 600;
        }

        .total-time .time-value {
            font-size: 1.8rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-left: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-row {
            margin-bottom: 30px;
        }

        .info-card {
            background: linear-gradient(135deg, #f0f9ff, #e6f7ff);
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 25px;
        }

        .info-card h5 {
            color: #0369a1;
            margin-bottom: 15px;
        }

        .info-card ul {
            margin: 0;
            padding-left: 20px;
        }

        .info-card li {
            margin-bottom: 8px;
            color: #475569;
        }

        /* Alert Styling */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .container-fluid {
                padding: 15px;
            }

            .card-body {
                padding: 20px;
            }

            .activity-header {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            .section-header {
                flex-direction: column;
                text-align: center;
            }

            .section-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .activity-actions {
                flex-wrap: wrap;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Custom form styling */
        .form-floating {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #dce1e7;
            color: #64748b;
        }

        .badge {
            padding: 8px 15px;
            font-size: 0.9rem;
            border-radius: 20px;
        }

        .btn-group {
            gap: 10px;
        }

        .required::after {
            content: " *";
            color: #dc3545;
        }

        .validation-message {
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .validation-message.error {
            color: #dc3545;
        }

        .validation-message.success {
            color: #198754;
        }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="container-fluid">
        <div class="main-content">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clipboard-list me-3" style="font-size: 2.5rem;"></i>
                            <div>
                                <h1 class="mb-2">Form Laporan Harian KKN</h1>
                                <p class="mb-0 opacity-75">Catat semua kegiatan harian KKN Anda di sini secara detail dan
                                    terstruktur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <form id="laporanForm" action="{{ route('logbook-submit') }}" method="POST">
                                @csrf
                                
                                <!-- Informasi Dasar -->
                                <div class="section-header">
                                    <i class="fas fa-calendar-alt section-icon"></i>
                                    <h5 class="section-title">Informasi Laporan</h5>
                                </div>

                                <div class="row g-4 mb-4">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tanggal" class="form-label required">Tanggal Laporan</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-calendar-day"></i>
                                                </span>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    value="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div id="tanggal-error" class="validation-message error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="kelompok" class="form-label required">Kelompok KKN</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                                <input type="text" class="form-control" id="kelompok" name="kelompok"
                                                    value="{{ $anggotaKelompok->kelompok->detailKelompok->first()->nama_kelompok ?? 'Belum ditentukan' }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="week" class="form-label required">Minggu KKN</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                                <input type="number" class="form-control" id="week" name="week" 
                                                    min="1" max="20" required>
                                            </div>
                                            <div id="week-error" class="validation-message error"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Input Kegiatan -->
                                <div class="section-header mt-5">
                                    <i class="fas fa-plus-circle section-icon"></i>
                                    <h5 class="section-title">Tambah Kegiatan Baru</h5>
                                </div>

                                <div class="info-card mb-4">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nama_kegiatan" class="form-label required">Nama Kegiatan</label>
                                                <input type="text" class="form-control" id="nama_kegiatan"
                                                    placeholder="Contoh: Koordinasi dengan Kepala Desa, Sosialisasi Program, dll.">
                                                <div id="nama-kegiatan-error" class="validation-message error"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kategori_id" class="form-label required">Kategori Kegiatan</label>
                                                <select class="form-select" id="kategori_id">
                                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                                    @foreach ($kat_kegiatan as $kat)
                                                        <option value="{{ $kat->id_kategori }}">{{ $kat->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="kategori-error" class="validation-message error"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jumlah_waktu" class="form-label required">Durasi Kegiatan</label>
                                                <div class="time-input-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="jumlah_waktu"
                                                            min="15" max="480" placeholder="Contoh: 120">
                                                        <span class="input-group-text bg-light">menit</span>
                                                    </div>
                                                    <div id="waktu-error" class="validation-message error"></div>
                                                    <small class="text-muted mt-2 d-block">Durasi minimal 15 menit, maksimal 8 jam (480 menit)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="deskripsi_kegiatan" class="form-label required">Deskripsi Kegiatan</label>
                                                <textarea class="form-control" id="deskripsi_kegiatan" rows="3"
                                                    placeholder="Jelaskan secara detail kegiatan yang dilakukan, termasuk tujuan, proses, dan hasilnya..."></textarea>
                                                <div id="deskripsi-error" class="validation-message error"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center mt-2">
                                            <button type="button" class="btn btn-primary btn-lg px-5" id="addActivityBtn">
                                                <i class="fas fa-plus-circle me-2"></i> Tambah ke Daftar Kegiatan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Daftar Kegiatan -->
                                <div class="section-header mt-5">
                                    <i class="fas fa-list-check section-icon"></i>
                                    <h5 class="section-title">Daftar Kegiatan Harian</h5>
                                </div>

                                <div class="activities-container" id="activitiesList">
                                    <div class="empty-state" id="emptyState">
                                        <i class="fas fa-clipboard-list"></i>
                                        <h5>Belum Ada Kegiatan</h5>
                                        <p>Mulai tambahkan kegiatan pertama Anda menggunakan form di atas</p>
                                    </div>
                                </div>

                                <!-- Total Waktu -->
                                <div class="total-time" id="totalTime" style="display: none;">
                                    <h5 class="mb-0">
                                        Total Waktu Kegiatan Hari Ini:
                                        <span class="time-value" id="totalTimeValue">0</span>
                                        <span class="text-muted">menit</span>
                                    </h5>
                                    <small class="text-muted" id="timeConversion"></small>
                                </div>

                                <!-- Keterangan Tambahan -->
                                <div class="section-header mt-5">
                                    <i class="fas fa-sticky-note section-icon"></i>
                                    <h5 class="section-title">Keterangan Tambahan</h5>
                                </div>

                                <div class="form-group mt-3">
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                                        placeholder="Tambahkan catatan khusus, kendala yang dihadapi, rencana untuk hari berikutnya, atau informasi lain yang relevan..."></textarea>
                                    <small class="text-muted">*Keterangan tambahan bersifat opsional</small>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                    <a href="{{ route('dashboard_mhs') }}" class="btn btn-outline-primary px-4">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-danger px-4" id="resetBtn">
                                            <i class="fas fa-redo me-2"></i> Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-primary px-5" id="submitBtn">
                                            <i class="fas fa-paper-plane me-2"></i> Simpan Laporan Harian
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Panduan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-header">
                                <i class="fas fa-graduation-cap section-icon"></i>
                                <h5 class="section-title">Panduan Pengisian Laporan</h5>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="card border-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary mb-3">
                                                <i class="fas fa-check-circle me-2"></i>Ketentuan Laporan
                                            </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Laporan
                                                    diisi setiap hari sebelum pukul 23:59</li>
                                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>
                                                    Deskripsi harus jelas dan detail</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card border-light mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary mb-3">
                                                <i class="fas fa-lightbulb me-2"></i>Tips Pengisian
                                            </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-star text-warning me-2"></i> Catat
                                                    kegiatan segera setelah selesai</li>
                                                <li class="mb-2"><i class="fas fa-star text-warning me-2"></i> Gunakan
                                                    kategori yang sesuai</li>
                                                <li class="mb-2"><i class="fas fa-star text-warning me-2"></i> Periksa
                                                    estimasi waktu dengan teliti</li>
                                                <li class="mb-2"><i class="fas fa-star text-warning me-2"></i> Gunakan
                                                    keterangan untuk penjelasan penting</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // State management
            let activities = [];
            let activityCounter = 0;

            // Elements
            const addActivityBtn = document.getElementById('addActivityBtn');
            const activitiesList = document.getElementById('activitiesList');
            const emptyState = document.getElementById('emptyState');
            const totalTimeDiv = document.getElementById('totalTime');
            const totalTimeValue = document.getElementById('totalTimeValue');
            const timeConversion = document.getElementById('timeConversion');
            const laporanForm = document.getElementById('laporanForm');
            const submitBtn = document.getElementById('submitBtn');

            // Validation elements
            const validationElements = {
                nama_kegiatan: document.getElementById('nama-kegiatan-error'),
                kategori_id: document.getElementById('kategori-error'),
                deskripsi_kegiatan: document.getElementById('deskripsi-error'),
                jumlah_waktu: document.getElementById('waktu-error'),
                week: document.getElementById('week-error'),
                tanggal: document.getElementById('tanggal-error')
            };

            // Clear validation messages
            function clearValidationMessages() {
                Object.values(validationElements).forEach(element => {
                    if (element) element.textContent = '';
                });
            }

            // Show validation message
            function showValidationMessage(elementId, message) {
                if (validationElements[elementId]) {
                    validationElements[elementId].textContent = message;
                }
            }

            // Validate activity form
            function validateActivityForm() {
                let isValid = true;
                clearValidationMessages();

                const namaKegiatan = document.getElementById('nama_kegiatan').value.trim();
                const kategoriId = document.getElementById('kategori_id').value;
                const deskripsi = document.getElementById('deskripsi_kegiatan').value.trim();
                const waktu = document.getElementById('jumlah_waktu').value;

                return isValid;
            }

            // Validate main form
            function validateMainForm() {
                let isValid = true;
                clearValidationMessages();

                const week = document.getElementById('week').value;
                const tanggal = document.getElementById('tanggal').value;

                if (!week || week < 1) {
                    showValidationMessage('week', 'Minggu KKN wajib diisi dengan angka positif');
                    isValid = false;
                }

                if (!tanggal) {
                    showValidationMessage('tanggal', 'Tanggal laporan wajib diisi');
                    isValid = false;
                }

                return isValid;
            }

            // Add activity to list
            addActivityBtn.addEventListener('click', function() {
                if (!validateActivityForm()) {
                    return;
                }

                // Get form values
                const namaKegiatan = document.getElementById('nama_kegiatan').value.trim();
                const kategoriId = document.getElementById('kategori_id').value;
                const kategoriText = document.getElementById('kategori_id').selectedOptions[0].text;
                const deskripsi = document.getElementById('deskripsi_kegiatan').value.trim();
                const waktu = parseInt(document.getElementById('jumlah_waktu').value);

                // Create activity object
                const activity = {
                    id: activityCounter++,
                    nama_kegiatan: namaKegiatan,
                    kategori_id: kategoriId,
                    kategori_text: kategoriText,
                    deskripsi_kegiatan: deskripsi,
                    jumlah_waktu: waktu,
                    timestamp: new Date().toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    })
                };

                // Add to activities array
                activities.push(activity);

                // Update UI
                updateActivitiesList();
                updateTotalTime();
                resetActivityForm();

                // Show success message
                showAlert(`Kegiatan "${namaKegiatan}" berhasil ditambahkan!`, 'success');
            });

            // Update activities list in UI
            function updateActivitiesList() {
                if (activities.length === 0) {
                    emptyState.style.display = 'block';
                    activitiesList.innerHTML = '';
                    activitiesList.appendChild(emptyState);
                    totalTimeDiv.style.display = 'none';
                    return;
                }

                emptyState.style.display = 'none';
                totalTimeDiv.style.display = 'block';

                let html = '';
                activities.forEach((activity, index) => {
                    html += `
                    <div class="activity-item" data-id="${activity.id}">
                        <div class="activity-header">
                            <div>
                                <h6 class="activity-title">${activity.nama_kegiatan}</h6>
                                <div class="activity-meta">
                                    <i class="fas fa-tag"></i> ${activity.kategori_id} 
                                    • <i class="fas fa-clock ms-2"></i> ${activity.jumlah_waktu} menit
                                    • <i class="fas fa-clock ms-2"></i> Ditambahkan: ${activity.timestamp}
                                </div>
                            </div>
                            <span class="badge bg-primary fs-6">${activity.jumlah_waktu} mnt</span>
                        </div>
                        <p class="activity-description mt-2">${activity.deskripsi_kegiatan}</p>
                        
                        <!-- Hidden Inputs untuk form submission -->
                        <div class="activity-hidden-inputs">
                            <input type="hidden" name="kegiatan[${index}][nama_kegiatan]" value="${escapeHtml(activity.nama_kegiatan)}">
                            <input type="hidden" name="kegiatan[${index}][kategori_id]" value="${activity.kategori_id}">
                            <input type="hidden" name="kegiatan[${index}][deskripsi_kegiatan]" value="${escapeHtml(activity.deskripsi_kegiatan)}">
                            <input type="hidden" name="kegiatan[${index}][jumlah_waktu]" value="${activity.jumlah_waktu}">
                        </div>
                        
                        <div class="activity-actions">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteActivity(${activity.id})">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
                });

                activitiesList.innerHTML = html;
            }

            // Escape HTML untuk mencegah XSS
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
            }

            // Update total time
            function updateTotalTime() {
                const total = activities.reduce((sum, activity) => sum + activity.jumlah_waktu, 0);
                totalTimeValue.textContent = total;

                // Convert to hours
                if (total >= 60) {
                    const hours = Math.floor(total / 60);
                    const minutes = total % 60;
                    let conversionText = '';

                    if (minutes > 0) {
                        conversionText = `(${hours} jam ${minutes} menit)`;
                    } else {
                        conversionText = `(${hours} jam)`;
                    }

                    timeConversion.textContent = conversionText;
                } else {
                    timeConversion.textContent = '';
                }
            }

            // Reset activity form
            function resetActivityForm() {
                document.getElementById('nama_kegiatan').value = '';
                document.getElementById('kategori_id').value = '';
                document.getElementById('deskripsi_kegiatan').value = '';
                document.getElementById('jumlah_waktu').value = '';
                document.getElementById('nama_kegiatan').focus();
                clearValidationMessages();
            }

            // Global function to delete activity
            window.deleteActivity = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
                    // Filter out the activity to delete
                    activities = activities.filter(activity => activity.id !== id);

                    // Update UI
                    updateActivitiesList();
                    updateTotalTime();

                    showAlert('Kegiatan berhasil dihapus!', 'success');
                }
            };

            // Reset entire form
            document.getElementById('resetBtn').addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin mereset form? Semua kegiatan yang belum disimpan akan hilang.')) {
                    // Reset activities
                    activities = [];
                    activityCounter = 0;

                    // Reset form
                    document.getElementById('laporanForm').reset();
                    document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

                    // Update UI
                    updateActivitiesList();
                    clearValidationMessages();

                    showAlert('Form berhasil direset!', 'success');
                }
            });

            // Form submit handler
            laporanForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (!validateMainForm()) {
                    return false;
                }
                
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                // Rebuild hidden inputs dengan index yang benar
                rebuildHiddenInputs();
                
                // Submit form setelah 500ms (untuk memastikan DOM terupdate)
                setTimeout(() => {
                    laporanForm.submit();
                }, 500);
            });

            // Rebuild hidden inputs dengan index yang berurutan
            function rebuildHiddenInputs() {
                // Hapus semua hidden inputs yang ada
                const existingHiddenInputs = document.querySelectorAll('.activity-hidden-inputs');
                existingHiddenInputs.forEach(input => input.remove());
                
                // Buat hidden inputs baru dengan index yang berurutan
                activities.forEach((activity, index) => {
                    const hiddenDiv = document.createElement('div');
                    hiddenDiv.className = 'activity-hidden-inputs';
                    hiddenDiv.innerHTML = `
                        <input type="hidden" name="kegiatan[${index}][nama_kegiatan]" value="${escapeHtml(activity.nama_kegiatan)}">
                        <input type="hidden" name="kegiatan[${index}][kategori_id]" value="${activity.kategori_id}">
                        <input type="hidden" name="kegiatan[${index}][deskripsi_kegiatan]" value="${escapeHtml(activity.deskripsi_kegiatan)}">
                        <input type="hidden" name="kegiatan[${index}][jumlah_waktu]" value="${activity.jumlah_waktu}">
                    `;
                    activitiesList.appendChild(hiddenDiv);
                });
            }

            // Alert function
            function showAlert(message, type) {
                // Remove existing alerts
                const existingAlert = document.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                // Create alert element
                const alertDiv = document.createElement('div');
                const alertClass = type === 'error' ? 'danger' :
                    type === 'success' ? 'success' : 'info';
                const alertIcon = type === 'error' ? 'exclamation-circle' :
                    type === 'success' ? 'check-circle' : 'info-circle';

                alertDiv.className = `alert alert-${alertClass} alert-dismissible fade show`;
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${alertIcon} me-2"></i>
                    <div>${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

                // Insert at the top of form container
                const formContainer = document.querySelector('.card-body');
                formContainer.insertBefore(alertDiv, formContainer.firstChild);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentElement) {
                        alertDiv.remove();
                    }
                }, 5000);
            }

            // Check for existing error messages from Laravel
            @if($errors->any())
                showAlert('{{ $errors->first() }}', 'error');
            @endif

            // Check if there's a success message from previous save
            @if(session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif

            // Initialize
            updateActivitiesList();

            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = today;
            
            // Focus on first input
            document.getElementById('nama_kegiatan').focus();
        });
    </script>
@endsection