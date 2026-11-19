<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# HRIS Web Application

Aplikasi **Human Resource Information System (HRIS)** berbasis web yang dibangun menggunakan **Laravel 12**, **PHP 8.5**, **MySQL**, **Bootstrap 5.3**, **Boxicons**, dan stylesheet kustom (`hris-theme.css`) dengan pendekatan antarmuka bergaya Sneat serta palet warna lembut (*Warm Linen & Muted Slate*) yang ringan dipandang.

## Fitur Utama

* **Manajemen Peran & Akses (`Role-Based Access Control`)**
  * Mendukung peran **Super Admin**, **HRD**, **Manager**, dan **Employee** dengan pembatasan menu serta hak akses sesuai peran.
* **Pembatasan Akses Jaringan**
  * Dilengkapi middleware pembatasan jaringan internal untuk menjaga keamanan akses aplikasi.
* **Keamanan Data Sensitif**
  * Menggunakan *encryption casting* bawaan Laravel untuk mengenkripsi data sensitif karyawan seperti NIK, informasi rekening bank, dan data gaji secara otomatis.
* **Absensi & Perhitungan Keterlambatan Otomatis**
  * Pencatatan *Clock-In* dan *Clock-Out* dengan jam masuk standar **07:00 WIB**, lengkap dengan deteksi status terlambat serta kalkulasi durasi keterlambatan.
* **Pengajuan & Persetujuan Lembur**
  * Karyawan dapat mengajukan jam lembur beserta alasan, dan peran terkait (Admin/HRD/Manager) dapat menyetujui atau menolak pengajuan tersebut.
* **Cuti, Izin, Penggajian & Data Karyawan**
  * Modul terpusat untuk memantau rekap kehadiran, pengajuan cuti/izin, penggajian, dan data kepegawaian.
* **Tema Kustom Mandiri (`hris-theme.css`)**
  * Mengatur tampilan *sidebar*, *topbar*, kartu, tabel, dan *badge* status secara terpusat tanpa bergantung pada file vendor CSS asli sehingga bebas konflik spesifisitas.

## Tech Stack

* **Backend:** PHP 8.5, Laravel 12
* **Database:** MySQL
* **Frontend:** Blade Templates, Bootstrap 5.3, Boxicons, Custom CSS (`public/assets/css/hris-theme.css`)

## Struktur Folder Proyek

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Controller Dashboard, Employee, Attendance, Leave, Overtime, Payroll
│   │   └── Middleware/         # Middleware pembatasan jaringan internal & hak akses
│   └── Models/                 # Model User, Employee, Department, Attendance, Leave, Overtime, Payroll
├── database/
│   ├── migrations/             # Skema tabel & kolom keterlambatan / lembur
│   └── seeders/                # Data awal peran pengguna & simulasi karyawan
├── public/
│   └── assets/
│       └── css/
│           └── hris-theme.css  # Stylesheet tema utama aplikasi
├── resources/
│   └── views/
│       ├── layouts/            # Layout utama (app.blade.php)
│       ├── dashboard/          # Halaman ringkasan & log absensi harian
│       ├── attendances/        # Riwayat absensi & status keterlambatan
│       ├── overtimes/          # Form pengajuan & persetujuan lembur
│       ├── employees/          # Manajemen data karyawan
│       ├── leaves/             # Pengajuan cuti & izin
│       └── payrolls/           # Data penggajian
└── routes/
    └── web.php                 # Definisi rute aplikasi


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
