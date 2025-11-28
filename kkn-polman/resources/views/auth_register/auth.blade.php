<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi KKN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e4fbe;
            --secondary-color: #2c6de9;
            --light-color: #e8f0fe;
            --dark-color: #0a2a75;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .auth-header {
            background: var(--primary-color);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .auth-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .auth-header p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .auth-body {
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
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 79, 190, 0.25);
        }

        .input-group-text {
            background: white;
            border-radius: 10px 0 0 10px;
            border: 2px solid #e2e8f0;
            border-right: none;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--dark-color);
            transform: translateY(-2px);
        }

        .auth-footer {
            text-align: center;
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #eaeaea;
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            cursor: pointer;
            transition: all 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .university-logo {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Two column layout for register form */
        .register-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .register-column {
            flex: 1;
            min-width: 300px;
        }

        /* Additional info section */
        .additional-info {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 20px;
            color: var(--dark-color);
        }

        .additional-info h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .info-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 15px;
            margin-top: 3px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .register-columns {
                flex-direction: column;
            }

            body {
                padding: 10px;
            }

            .auth-header,
            .auth-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        @if (session('success'))
            <div class="alert alert-success server-notif alert-dismissible fade show" role="alert" aria-live="polite">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger server-notif alert-dismissible fade show" role="alert" aria-live="polite">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger server-notif alert-dismissible fade show" role="alert" aria-live="polite">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="auth-container">
            <div class="auth-header">
                <div class="university-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Sistem Informasi KKN</h1>
                <p>Kuliah Kerja Nyata - Universitas</p>
            </div>

            <!-- Login Form -->
            <form method="post" action="{{ route('login') }}" id="login-form" class="auth-body">
                @csrf
                <div class="form-group">
                    <label for="login-email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="login-email" name="email"
                            placeholder="Masukkan email Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="login-password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="login-password" name="password"
                            placeholder="Masukkan password" required>
                        <span class="input-group-text password-toggle" id="login-password-toggle">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember-me" name="remember-me">
                    <label class="form-check-label" for="remember-me">Ingat saya</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </div>

                <div class="text-center">
                    <a href="#" class="text-muted">Lupa password?</a>
                </div>
            </form>

            <!-- Register Form -->
            <form method="post" action="{{ route('register') }}" id="register-form" class="auth-body"
                style="display: none;">
                @csrf
                <div class="register-columns">
                    <div class="register-column">
                        <div class="form-group">
                            <label for="register-name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="register-name" name="register-name"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="register-nim" class="form-label">NIM</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control" id="register-nim" name="register-nim"
                                    placeholder="Masukkan NIM" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="register-email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="register-email" name="register-email"
                                    placeholder="Masukkan email Anda" required>
                            </div>
                        </div>
                    </div>

                    <div class="register-column">
                        <input type="hidden" id="route-get-prodi"
                            value="{{ route('get.prodi', ['jurusan_id' => 'JURID']) }}">

                        <div class="form-group">
                            <label class="form-label">Jurusan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <select class="form-control" id="register-jurusan" name="register-jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($jurusan as $jur)
                                        <option value="{{ $jur->id_jurusan }}">{{ $jur->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Program Studi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                <select class="form-control" id="register-prodi" name="register-prodi" required>
                                    <option value="">Pilih Prodi</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="register-password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="register-password" name="password"
                                    placeholder="Buat password" required>
                                <span class="input-group-text password-toggle" id="register-password-toggle">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password-confirmation" name="password_confirmation"
                                    placeholder="Konfirmasi password" required autocomplete="new-password">
                                <span class="input-group-text password-toggle" id="register-confirm-password-toggle">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="agree-terms" name="agree-terms" required>
                    <label class="form-check-label" for="agree-terms">Saya menyetujui <a href="#">syarat dan
                            ketentuan</a></label>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </div>
            </form>

            <div class="auth-footer">
                <p id="login-footer">Belum punya akun? <a href="#" id="switch-to-register">Daftar di sini</a>
                </p>
                <p id="register-footer" style="display: none;">Sudah punya akun? <a href="#"
                        id="switch-to-login">Masuk di sini</a></p>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="additional-info">
            <h3>Informasi Penting</h3>
            <div class="info-item">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Persyaratan Pendaftaran</strong>
                    <p>Pastikan Anda telah memenuhi semua persyaratan sebelum mendaftar, termasuk memiliki IPK minimal
                        2.75 dan telah menyelesaikan minimal 100 SKS.</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <strong>Jadwal Pendaftaran</strong>
                    <p>Pendaftaran KKN dibuka dari 1 Januari hingga 31 Januari 2023. Pastikan Anda mendaftar sebelum
                        batas waktu berakhir.</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-file-alt"></i>
                <div>
                    <strong>Dokumen yang Diperlukan</strong>
                    <p>Siapkan dokumen-dokumen berikut: Transkrip nilai, pas foto, fotokopi KTM, dan sertifikat
                        kesehatan.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle between login and register forms
            const switchToRegister = document.getElementById('switch-to-register');
            const switchToLogin = document.getElementById('switch-to-login');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginFooter = document.getElementById('login-footer');
            const registerFooter = document.getElementById('register-footer');

            switchToRegister.addEventListener('click', function(e) {
                e.preventDefault();
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                loginFooter.style.display = 'none';
                registerFooter.style.display = 'block';
            });

            switchToLogin.addEventListener('click', function(e) {
                e.preventDefault();
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
                registerFooter.style.display = 'none';
                loginFooter.style.display = 'block';
            });

            // Password toggle functionality
            const loginPasswordToggle = document.getElementById('login-password-toggle');
            const loginPasswordInput = document.getElementById('login-password');

            const registerPasswordToggle = document.getElementById('register-password-toggle');
            const registerPasswordInput = document.getElementById('register-password');

            loginPasswordToggle.addEventListener('click', function() {
                if (loginPasswordInput.type === 'password') {
                    loginPasswordInput.type = 'text';
                    loginPasswordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    loginPasswordInput.type = 'password';
                    loginPasswordToggle.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });

            registerPasswordToggle.addEventListener('click', function() {
                if (registerPasswordInput.type === 'password') {
                    registerPasswordInput.type = 'text';
                    registerPasswordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    registerPasswordInput.type = 'password';
                    registerPasswordToggle.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.server-notif').forEach(function(el) {
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    if (window.bootstrap && bootstrap.Alert) {
                        bootstrap.Alert.getOrCreateInstance(el).close();
                    } else {
                        // Fallback if Bootstrap JS isn't loaded
                        el.classList.remove('show');
                        el.style.transition = 'opacity .3s';
                        el.style.opacity = '0';
                        setTimeout(function() {
                            el.remove();
                        }, 300);
                    }
                }, 5000);
            });
        });
    </script>
    <script>
        document.getElementById('register-jurusan').addEventListener('change', function() {

            let jurusanId = this.value;
            let prodiDropdown = document.getElementById('register-prodi');

            // Ambil URL dari route name (yang punya placeholder)
            let routeUrl = document.getElementById('route-get-prodi').value;

            // Replace placeholder dengan jurusan yg dipilih
            routeUrl = routeUrl.replace('JURID', jurusanId);

            prodiDropdown.innerHTML = '<option value="">Loading...</option>';

            fetch(routeUrl)
                .then(response => response.json())
                .then(data => {
                    prodiDropdown.innerHTML = '<option value="">Pilih Prodi</option>';
                    data.forEach(function(prodi) {
                        prodiDropdown.innerHTML +=
                            `<option value="${prodi.id_prodi}">${prodi.nama_prodi}</option>`;
                    });
                });
        });
    </script>
</body>

</html>
