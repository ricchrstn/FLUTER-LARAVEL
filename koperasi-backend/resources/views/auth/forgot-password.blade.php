<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Koperasi Mahasiswa</title>
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
        .forgot-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .forgot-image {
            background: var(--koperasi-green);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .forgot-image img {
            max-width: 100%;
            height: auto;
        }
        .forgot-form {
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
        <div class="forgot-container">
            <div class="row g-0">
                <div class="col-md-6 d-none d-md-block">
                    <div class="forgot-image">
                        <img src="{{ asset('images/koperasi-logo.png') }}" alt="Koperasi Logo" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="forgot-form">
                        <h2 class="text-center mb-4 text-koperasi">Lupa Password</h2>
                        
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-muted mb-4">
                            Masukkan email Anda yang terdaftar. Kami akan mengirimkan link untuk reset password.
                        </p>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-koperasi btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Link Reset
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none text-koperasi">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                                </a>
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
