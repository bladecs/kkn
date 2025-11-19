<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dosen - Sistem Informasi KKN</title>
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
                    <i class="fas fa-user-tie"></i>
                </div>
                <h1>Login Dosen Pembimbing</h1>
                <p>Sistem Informasi KKN - Universitas</p>
            </div>

            <!-- Login Form -->
            <form method="post" action="{{ route('login-dosen-submit') }}" id="login-form" class="auth-body">
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
        </div>

        <!-- Additional Information Section -->
        <div class="additional-info">
            <h3>Informasi Login Dosen</h3>
            <div class="info-item">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Akun Dosen Pembimbing</strong>
                    <p>Login ini khusus untuk dosen pembimbing KKN. Pastikan Anda menggunakan email dan password yang telah didaftarkan oleh administrator.</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>Keamanan Akun</strong>
                    <p>Jaga kerahasiaan password Anda. Jika mengalami masalah dengan akun, segera hubungi administrator sistem.</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-tasks"></i>
                <div>
                    <strong>Fitur Dosen Pembimbing</strong>
                    <p>Setelah login, Anda dapat mengelola kelompok KKN, memantau progress mahasiswa, dan memberikan penilaian.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const loginPasswordToggle = document.getElementById('login-password-toggle');
            const loginPasswordInput = document.getElementById('login-password');

            loginPasswordToggle.addEventListener('click', function() {
                if (loginPasswordInput.type === 'password') {
                    loginPasswordInput.type = 'text';
                    loginPasswordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    loginPasswordInput.type = 'password';
                    loginPasswordToggle.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });

            // Auto-hide notifications
            document.querySelectorAll('.server-notif').forEach(function(el) {
                setTimeout(function() {
                    if (window.bootstrap && bootstrap.Alert) {
                        bootstrap.Alert.getOrCreateInstance(el).close();
                    } else {
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
</body>

</html>