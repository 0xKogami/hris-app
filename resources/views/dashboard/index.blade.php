@extends('layouts.app')
@section('title', 'Dashboard - HRIS')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bold text-primary mb-1">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="text-muted mb-0 small">Pantau kehadiran harian, pengajuan cuti, dan data kepegawaian secara terpusat.</p>
                </div>

                @if(auth()->user()->employee)
                <div class="d-flex gap-2">
                    <form action="{{ route('attendances.store') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="type" value="clock_in">
                        <button type="submit" class="btn btn-success btn-sm fw-semibold" {{ $myAttendance?->clock_in ? 'disabled' : '' }}>
                            <i class="bx bx-log-in"></i> Clock-In {{ $myAttendance?->clock_in ? "({$myAttendance->clock_in})" : '' }}
                        </button>
                    </form>
                    <form action="{{ route('attendances.store') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="type" value="clock_out">
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold" {{ (!$myAttendance?->clock_in || $myAttendance?->clock_out) ? 'disabled' : '' }}>
                            <i class="bx bx-log-out"></i> Clock-Out {{ $myAttendance?->clock_out ? "({$myAttendance->clock_out})" : '' }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-label-primary p-2 rounded-2"><i class="bx bx-user fs-4"></i></span>
                </div>
                <span class="text-muted small d-block">Total Karyawan</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{ $totalEmployees }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-label-success p-2 rounded-2"><i class="bx bx-check-circle fs-4"></i></span>
                </div>
                <span class="text-muted small d-block">Hadir Hari Ini</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{ $presentToday }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-label-warning p-2 rounded-2"><i class="bx bx-calendar-event fs-4"></i></span>
                </div>
                <span class="text-muted small d-block">Sedang Cuti</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{ $onLeaveToday }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-label-info p-2 rounded-2"><i class="bx bx-hourglass fs-4"></i></span>
                </div>
                <span class="text-muted small d-block">Cuti Menunggu Persetujuan</span>
                <h4 class="fw-bold text-dark mb-0 mt-1">{{ $pendingLeaves }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="card-title mb-0 fw-semibold">Log Absensi Hari Ini</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light text-uppercase">
                <tr>
                    <th class="px-4 py-3">Karyawan</th>
                    <th class="px-4 py-3">Departemen</th>
                    <th class="px-4 py-3">Masuk</th>
                    <th class="px-4 py-3">Pulang</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">IP Jaringan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAttendances as $att)
                <tr>
                    <td class="px-4 py-3 fw-semibold text-dark">{{ $att->employee->user->name }}</td>
                    <td class="px-4 py-3">{{ $att->employee->department->name }}</td>
                    <td class="px-4 py-3">{{ $att->clock_in ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $att->clock_out ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="badge bg-label-success text-uppercase">{{ $att->status }}</span>
                    </td>
                    <td class="px-4 py-3 text-muted">{{ $att->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-muted">Belum ada data absensi hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
