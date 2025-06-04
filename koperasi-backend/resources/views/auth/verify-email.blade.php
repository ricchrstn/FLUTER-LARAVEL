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
            --koperasi-green: #388e3c;
            --koperasi-light-green: #4caf50;
        }
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verify-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .verify-image {
            background: var(--koperasi-green);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .verify-image img {
            max-width: 100%;
            height: auto;
        }
        .verify-form {
            padding: 3rem;
        }
        .btn-koperasi {
            background-color: var(--koperasi-green);
            border-color: var(--koperasi-green);
            color: white;
        }
        .btn-koperasi:hover {
            background-color: var(--koperasi-light-green);
            border-color: var(--koperasi-light-green);
            color: white;
        }
        .form-control:focus {
            border-color: var(--koperasi-green);
            box-shadow: 0 0 0 0.25rem rgba(56, 142, 60, 0.25);
        }
        .text-koperasi {
            color: var(--koperasi-green);
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
                                Link verifikasi baru telah dikirim ke email Anda.
                            </div>
                        @endif

                        <p class="text-muted mb-4">
                            Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengklik link yang telah kami kirim. Jika Anda tidak menerima email, kami akan mengirimkan link baru.
                        </p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-koperasi btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Ulang Link Verifikasi
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
