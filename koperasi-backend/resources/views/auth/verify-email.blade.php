<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Koperasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .verify-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            margin: 1rem;
        }
        .verify-image {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .verify-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
        }
        .verify-image img {
            max-width: 80%;
            height: auto;
            position: relative;
            z-index: 1;
        }
        .verify-form {
            padding: 3rem;
        }
        .btn-koperasi {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        .btn-koperasi:hover {
            background: #224abe;
            color: white;
            transform: translateY(-2px);
        }
        .text-koperasi {
            color: var(--primary-color);
        }
        .alert {
            border-radius: 0.5rem;
            border: none;
        }
        .alert-success {
            background: rgba(28, 200, 138, 0.1);
            color: #1cc88a;
        }
        .alert-warning {
            background: rgba(246, 194, 62, 0.1);
            color: #f6c23e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verify-container">
            <div class="row g-0">
                <div class="col-md-6 d-none d-md-block">
                    <div class="verify-image">
                        <img src="{{ asset('images/koperasi-logo.png') }}" alt="Koperasi Logo" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="verify-form">
                        <h2 class="text-center mb-4 text-koperasi">Verifikasi Email</h2>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Link verifikasi baru telah dikirim ke email Anda.
                            </div>
                        @endif

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengklik link yang telah kami kirim ke email Anda. Jika Anda tidak menerima email, kami akan mengirimkan email baru.
                        </div>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-koperasi btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Ulang Email Verifikasi
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
