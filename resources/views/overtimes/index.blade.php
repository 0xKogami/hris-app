@extends('layouts.app')
@section('title', 'Pengajuan Lembur - HRIS')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Pengajuan Lembur</h4>
    <p class="text-muted small mb-0">Ajukan jam lembur dan pantau status persetujuan.</p>
</div>

@if(auth()->user()->employee)
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Form Pengajuan Lembur</h6>
        <form action="{{ route('overtimes.store') }}" method="POST" class="row g-3 small">
            @csrf
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal Lembur</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Jam Mulai</label>
                <input type="time" name="start_time" required class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Jam Selesai</label>
                <input type="time" name="end_time" required class="form-control">
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold">Alasan / Pekerjaan Lembur</label>
                <input type="text" name="reason" placeholder="Contoh: Penyelesaian rekap data bulanan" required class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm fw-semibold">
                    <i class="bx bx-send"></i> Kirim Pengajuan Lembur
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="text-uppercase">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Karyawan</th>
                    <th class="px-4 py-3">Jam Lembur</th>
                    <th class="px-4 py-3">Durasi</th>
                    <th class="px-4 py-3">Alasan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($overtimes as $ot)
                <tr>
                    <td class="px-4 py-3">{{ $ot->date->format('d M Y') }}</td>
                    <td class="px-4 py-3 fw-semibold">{{ $ot->employee->user->name }}</td>
                    <td class="px-4 py-3">{{ substr($ot->start_time, 0, 5) }} - {{ substr($ot->end_time, 0, 5) }}</td>
                    <td class="px-4 py-3 fw-semibold">{{ $ot->duration_label }}</td>
                    <td class="px-4 py-3">{{ $ot->reason }}</td>
                    <td class="px-4 py-3">
                        @php
                            $badgeClass = match($ot->status) {
                                'approved' => 'bg-label-success',
                                'rejected' => 'bg-label-warning',
                                default => 'bg-label-info',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} text-uppercase">{{ $ot->status }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @if($ot->status === 'pending' && (auth()->user()->isAdminOrHrd() || auth()->user()->role === 'manager'))
                        <form action="{{ route('overtimes.status', $ot) }}" method="POST" class="d-inline-flex gap-1 m-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="approved" class="btn btn-success btn-sm py-0 px-2">Setujui</button>
                            <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm py-0 px-2">Tolak</button>
                        </form>
                        @else
                            <span class="text-muted">{{ $ot->approver?->name ?? '-' }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-4 text-center text-muted">Belum ada pengajuan lembur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div>{{ $overtimes->links() }}</div>
@endsection
