<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRIS NCM')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/hris-theme.css') }}">
</head>

<body>
    <div class="sneat-shell">
        <!-- Menu Samping (Sneat Style) -->
        <aside id="layout-menu" class="sneat-sidebar">
            <a href="{{ route('dashboard') }}" class="sneat-brand">
                <span
                    class="badge bg-label-primary p-2 rounded-2 d-inline-flex align-items-center justify-content-center">
                    <i class="bx bx-buildings fs-5"></i>
                </span>
                <span class="sneat-brand-text">HRIS NCM</span>
            </a>

            <div class="sneat-menu-header">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="sneat-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bx bx-home-circle"></i>
                <span>Dashboard</span>
            </a>

            @if (auth()->user()->isAdminOrHrd())
                <a href="{{ route('employees.index') }}"
                    class="sneat-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    <i class="bx bx-group"></i>
                    <span>Data Karyawan</span>
                </a>
            @endif

            <a href="{{ route('attendances.index') }}"
                class="sneat-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <i class="bx bx-time-five"></i>
                <span>Absensi</span>
            </a>

            <a href="{{ route('leaves.index') }}"
                class="sneat-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
                <i class="bx bx-calendar-check"></i>
                <span>Cuti &amp; Izin</span>
            </a>

            <a href="{{ route('overtimes.index') }}"
                class="sneat-link {{ request()->routeIs('overtimes.*') ? 'active' : '' }}">
                <i class="bx bx-timer"></i>
                <span>Lembur</span>
            </a>

            <a href="{{ route('payrolls.index') }}"
                class="sneat-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}">
                <i class="bx bx-wallet"></i>
                <span>Penggajian</span>
            </a>
        </aside>

        <!-- Konten Utama -->
        <div class="sneat-main px-3 px-lg-4 pt-3">
            <nav class="sneat-topbar navbar navbar-expand mb-4">
                <div class="container-fluid px-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="fw-semibold text-dark small">{{ auth()->user()->name }}</span>
                        <span class="badge bg-label-primary text-uppercase">{{ auth()->user()->role }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-sm-3">
                        <span class="badge bg-label-success d-none d-sm-inline-flex align-items-center gap-1 py-2 px-2">
                            <i class="bx bx-shield-quarter"></i> {{ request()->ip() }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Keluar</button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="py-4 mt-4 text-muted small d-flex flex-wrap justify-content-between align-items-center">
                <div>&copy; {{ date('Y') }} HRIS Intranet</div>
                <div>Template UI inspired by <a href="https://themeselection.com" target="_blank" rel="noopener"
                        class="text-primary text-decoration-none fw-medium">ThemeSelection Sneat</a></div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
