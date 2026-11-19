@extends('layouts.app')
@section('title', 'Riwayat Absensi - HRIS')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Riwayat Absensi</h4>
    <p class="text-muted small mb-0">Jam masuk standar 07:00. Keterlambatan dan durasinya dihitung otomatis saat Clock-In.</p>
</div>

<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="text-uppercase">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Karyawan</th>
                    <th class="px-4 py-3">Clock-In</th>
                    <th class="px-4 py-3">Clock-Out</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Keterlambatan</th>
                    <th class="px-4 py-3">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td class="px-4 py-3">{{ $att->date->format('d M Y') }}</td>
                    <td class="px-4 py-3 fw-semibold">{{ $att->employee->user->name }}</td>
                    <td class="px-4 py-3">{{ $att->clock_in ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $att->clock_out ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="badge {{ $att->is_late ? 'bg-label-warning' : 'bg-label-success' }} text-uppercase">
                            {{ $att->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($att->is_late)
                            <span class="fw-semibold text-danger">{{ $att->late_duration_label }}</span>
                        @else
                            <span class="text-muted">{{ $att->late_duration_label }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-muted">{{ $att->ip_address }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-4 text-center text-muted">Belum ada data absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div>{{ $attendances->links() }}</div>
@endsection
