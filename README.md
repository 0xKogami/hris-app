# HRIS Web Application (Laravel Portfolio)

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
