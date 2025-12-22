@extends('dashboard.mahasiswa.layouts.app')

@section('title', 'Dashboard - Sistem Informasi KKN')

@section('style')
    <style>
        .profile-container {
            width: 100%;
            margin: 0 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-header {
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .profile-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .profile-card {
            width: 100%;
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--light-color);
            margin-bottom: 20px;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .profile-nim {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .profile-status {
            display: inline-block;
            padding: 5px 15px;
            background: var(--light-color);
            color: var(--primary-color);
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .info-section {
            margin-bottom: 30px;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }

        .info-label {
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .info-label i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .info-value {
            color: #495057;
            padding-left: 28px;
        }

        .profile-actions {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            gap: 15px;
            width: 100%;
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
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px 30px;
            border-bottom: none;
        }

        .modal-header .modal-title {
            font-weight: 600;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
            border-radius: 0 0 15px 15px;
        }

        @media (max-width: 768px) {
            .profile-actions {
                flex-direction: column;
            }

            .profile-actions .btn {
                width: 100%;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wrapper d-flex align-items-stretch">
        <!-- Main Content -->
        <div class="profile-container">
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
            <div class="profile-header">
                <h1><i class="fas fa-user-circle me-2"></i> Profil Mahasiswa</h1>
                <p>Informasi lengkap data pribadi dan akademik Anda</p>
            </div>

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-info">
                    <h2 class="profile-name">{{ $data_diri->name }}</h2>
                    <div class="profile-nim">NIM: {{ $data_diri->nim }}</div>
                    <div class="profile-status">Mahasiswa Aktif - {{ $data_diri->jurusan->nama_jurusan }}</div>
                </div>

                <!-- Data Pribadi -->
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-user"></i> Data Pribadi</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-id-card"></i> Nama Lengkap</div>
                            <div class="info-value">{{ $data_diri->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-id-badge"></i> NIM</div>
                            <div class="info-value">{{ $data_diri->nim }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</div>
                            <div class="info-value">
                                @if (($data_diri->gender ?? '') === 'male')
                                    Laki-laki
                                @elseif (($data_diri->gender ?? '') === 'female')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                            <div class="info-value">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Data Akademik -->
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-graduation-cap"></i> Data Akademik</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-university"></i> Fakultas / Jurusan</div>
                            <div class="info-value">{{ $data_diri->jurusan->nama_jurusan }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-book"></i> Program Studi</div>
                            <div class="info-value">{{ $data_diri->prodi->nama_prodi }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-calendar-alt"></i> Semester</div>
                            <div class="info-value">{{ $data_pendaftaran->detailPendaftaran[0]->semester ?? '-' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-chart-line"></i> IPK</div>
                            <div class="info-value">{{ number_format($data_pendaftaran->detailPendaftaran[0]->ipk ?? 0, 2, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Data KKN -->
                <div class="info-section">
                    <h3 class="section-title"><i class="fas fa-users"></i> Data KKN</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-clipboard-check"></i> Status Pendaftaran</div>
                            <div class="info-value">
                                @if ($data_pendaftaran->status == 'complete')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif ($data_pendaftaran->status == 'pending')
                                    <span class="badge bg-info">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Mendaftar</span>
                                @endif
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-map-marked-alt"></i> Lokasi KKN</div>
                            <div class="info-value">{{ $data_pendaftaran->lokasi ?? '-' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-layer-group"></i> Kelompok</div>
                            <div class="info-value">{{ $data_pendaftaran->kelompok ?? '-' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-user-tie"></i> Dosen Pembimbing</div>
                            <div class="info-value">{{ $data_pendaftaran->dosen_pembimbing ?? '-' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label"><i class="fas fa-clock"></i> Periode KKN</div>
                            <div class="info-value">{{ $data_pendaftaran->periode ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="profile-actions">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDataDiriModal">
                    <i class="fas fa-edit me-2"></i> Edit Data Diri
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Diri -->
    <div class="modal fade" id="editDataDiriModal" tabindex="-1" aria-labelledby="editDataDiriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataDiriModalLabel">
                        <i class="fas fa-edit me-2"></i> Edit Data Diri
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update-data-diri') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $data_diri->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="{{ $data_diri->nim }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="male"
                                            {{ ($data_diri->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="female"
                                            {{ ($data_diri->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
