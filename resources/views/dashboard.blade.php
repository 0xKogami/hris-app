<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HRIS Perusahaan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto">
            <div class="flex items-center justify-between h-16 px-6 bg-slate-950 text-white font-bold text-lg tracking-wider">
                <span>HRIS SYSTEM</span>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">✕</button>
            </div>
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg bg-indigo-600 text-white">📊 Dashboard</a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">👥 Data Karyawan</a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">🕒 Absensi</a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">📝 Cuti & Izin</a>
                <a href="#" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition">💰 Penggajian</a>
            </nav>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex flex-col flex-1 h-full overflow-hidden">

            <!-- TOP NAVBAR -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shadow-sm">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none">☰</button>
                <div class="text-sm font-semibold text-gray-700">Selamat Datang, Administrator</div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                        🟢 Jaringan Kantor Aman
                    </span>
                    <form action="#" method="POST">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Keluar</button>
                    </form>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 space-y-6">
                <!-- Header Info -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Utama</h1>
                    <p class="text-sm text-gray-500">Ringkasan aktivitas dan data kepegawaian perusahaan.</p>
                </div>

                <!-- CARDS STATS -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="text-sm font-medium text-gray-500">Total Karyawan</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">124</div>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="text-sm font-medium text-gray-500">Hadir Hari Ini</div>
                        <div class="mt-2 text-3xl font-bold text-emerald-600">118</div>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="text-sm font-medium text-gray-500">Cuti / Izin</div>
                        <div class="mt-2 text-3xl font-bold text-amber-600">4</div>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="text-sm font-medium text-gray-500">Alpha / Tanpa Ketarangan</div>
                        <div class="mt-2 text-3xl font-bold text-red-600">2</div>
                    </div>
                </div>

                <!-- TABLE SECTION -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-800">Aktivitas Absensi Terbaru</div>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Nama Karyawan</th>
                                <th class="px-6 py-3">Jam Masuk</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">Budi Santoso</td>
                                <td class="px-6 py-4">08:00 WIB</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-md">Hadir</span></td>
                                <td class="px-6 py-4 text-gray-400">192.168.1.15</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">Siti Aminah</td>
                                <td class="px-6 py-4">08:15 WIB</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-semibold bg-amber-100 text-amber-700 rounded-md">Terlambat</span></td>
                                <td class="px-6 py-4 text-gray-400">192.168.1.22</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
