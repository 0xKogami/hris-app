@extends('layouts.app')
@section('title', 'Cuti & Izin - HRIS')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Manajemen Cuti &amp; Izin</h4>
    <p class="text-muted small mb-0">Ajukan cuti atau setujui permohonan tim.</p>
</div>

@if(auth()->user()->employee)
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">
            Ajukan Cuti Baru
            <span class="badge bg-label-info ms-1">Sisa Kuota Tahunan: {{ auth()->user()->employee->leave_quota }} Hari</span>
        </h6>
        <form action="{{ route('leaves.store') }}" method="POST" class="row g-3 small">
            @csrf
            <div class="col-md-3"><label class="form-label fw-semibold">Jenis Cuti</label>
                <select name="leave_type" class="form-select"><option value="cuti_tahunan">Cuti Tahunan</option><option value="cuti_sakit">Cuti Sakit</option><option value="izin_khusus">Izin Khusus</option></select>
            </div>
            <div class="col-md-3"><label class="form-label fw-semibold">Tanggal Mulai</label><input type="date" name="start_date" required class="form-control"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">Tanggal Selesai</label><input type="date" name="end_date" required class="form-control"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">Alasan</label><input type="text" name="reason" required class="form-control"></div>
            <div class="col-12"><button type="submit" class="btn btn-primary btn-sm fw-semibold">Kirim Pengajuan</button></div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light text-uppercase">
                <tr>
                    <th class="px-4 py-3">Karyawan</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Periode</th>
                    <th class="px-4 py-3">Alasan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td class="px-4 py-3 fw-semibold text-dark">{{ $leave->employee->user->name }}</td>
                    <td class="px-4 py-3">{{ str_replace('_', ' ', strtoupper($leave->leave_type)) }}</td>
                    <td class="px-4 py-3">{{ $leave->start_date->format('d/m/Y') }} - {{ $leave->end_date->format('d/m/Y') }} ({{ $leave->total_days }} hr)</td>
                    <td class="px-4 py-3">{{ $leave->reason }}</td>
                    <td class="px-4 py-3"><span class="badge bg-label-warning text-uppercase">{{ $leave->status }}</span></td>
                    <td class="px-4 py-3">
                        @if($leave->status === 'pending' && (auth()->user()->isAdminOrHrd() || auth()->user()->role === 'manager'))
                        <form action="{{ route('leaves.status', $leave) }}" method="POST" class="d-inline-flex gap-1 m-0">
                            @csrf @method('PATCH')
                            <button type="submit" name="status" value="approved" class="btn btn-success btn-sm py-0 px-2">Setujui</button>
                            <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm py-0 px-2">Tolak</button>
                        </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-4 text-center text-muted">Belum ada pengajuan cuti.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
