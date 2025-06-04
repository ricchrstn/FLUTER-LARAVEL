<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentikasi Dua Faktor - Koperasi Mahasiswa</title>
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
        .two-factor-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .two-factor-image {
            background: var(--koperasi-green);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .two-factor-image img {
            max-width: 100%;
            height: auto;
        }
        .two-factor-form {
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
        .nav-pills .nav-link.active {
            background-color: var(--koperasi-green);
        }
        .nav-pills .nav-link {
            color: var(--koperasi-green);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="two-factor-container">
            <div class="row g-0">
                <div class="col-md-6 d-none d-md-block">
                    <div class="two-factor-image">
                        <img src="{{ asset('images/koperasi-logo.png') }}" alt="Koperasi Logo" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="two-factor-form">
                        <h2 class="text-center mb-4 text-koperasi">Autentikasi Dua Faktor</h2>

                        <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-code-tab" data-bs-toggle="pill" data-bs-target="#pills-code" type="button" role="tab">
                                    <i class="fas fa-key me-2"></i> Kode
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-recovery-tab" data-bs-toggle="pill" data-bs-target="#pills-recovery" type="button" role="tab">
                                    <i class="fas fa-shield-alt me-2"></i> Kode Pemulihan
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-code" role="tabpanel">
                                <p class="text-muted mb-4">
                                    Mohon konfirmasi akses ke akun Anda dengan memasukkan kode autentikasi yang disediakan oleh aplikasi autentikator Anda.
                                </p>

                                <form method="POST" action="{{ route('two-factor.login') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="code" class="form-label">Kode Autentikasi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                            <input type="text" class="form-control" id="code" name="code" required autofocus>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-koperasi btn-lg">
                                            <i class="fas fa-check me-2"></i> Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="pills-recovery" role="tabpanel">
                                <p class="text-muted mb-4">
                                    Mohon konfirmasi akses ke akun Anda dengan memasukkan salah satu kode pemulihan darurat Anda.
                                </p>

                                <form method="POST" action="{{ route('two-factor.login') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="recovery_code" class="form-label">Kode Pemulihan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                            <input type="text" class="form-control" id="recovery_code" name="recovery_code" required>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-koperasi btn-lg">
                                            <i class="fas fa-check me-2"></i> Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 