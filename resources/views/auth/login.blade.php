<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HRIS NCM Intranet</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/hris-theme.css') }}">
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="card p-4 p-sm-5" style="max-width: 420px; width: 100%;">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center gap-2 fw-bold fs-4 text-dark mb-2">
                <i class="bx bx-buildings text-primary fs-2"></i>
                <span>HRIS Portal</span>
            </div>
            <p class="text-muted small mb-0">Silakan masuk ke akun intranet perusahaan Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label small fw-semibold text-uppercase">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@perusahaan.local" class="form-control">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-semibold text-uppercase">Kata Sandi</label>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Masuk
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
