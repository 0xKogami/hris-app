@extends('layouts.app')
@section('title', 'Penggajian - HRIS')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Sistem Penggajian (Terenkripsi)</h4>
    <p class="text-muted small mb-0">Nominal gaji terenkripsi di database dan didekripsi saat ditampilkan.</p>
</div>

@if(auth()->user()->isAdminOrHrd())
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Terbitkan Slip Gaji Bulanan</h6>
        <form action="{{ route('payrolls.store') }}" method="POST" class="row g-3 small">
            @csrf
            <div class="col-md-4"><label class="form-label fw-semibold">Karyawan</label>
                <select name="employee_id" class="form-select">@foreach($employees as $emp)<option value="{{ $emp->id }}">{{ $emp->user->name }} ({{ $emp->position->title }})</option>@endforeach</select>
            </div>
            <div class="col-md-2"><label class="form-label fw-semibold">Bulan (1-12)</label><input type="number" name="period_month" min="1" max="12" value="{{ date('n') }}" required class="form-control"></div>
            <div class="col-md-2"><label class="form-label fw-semibold">Tahun</label><input type="number" name="period_year" value="{{ date('Y') }}" required class="form-control"></div>
            <div class="col-md-2"><label class="form-label fw-semibold">Tunjangan (Rp)</label><input type="number" name="allowances" value="0" min="0" class="form-control"></div>
            <div class="col-md-2"><label class="form-label fw-semibold">Potongan (Rp)</label><input type="number" name="deductions" value="0" min="0" class="form-control"></div>
            <div class="col-12"><button type="submit" class="btn btn-primary btn-sm fw-semibold">Proses &amp; Enkripsi Gaji</button></div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light text-uppercase">
                <tr>
                    <th class="px-4 py-3">Periode</th>
                    <th class="px-4 py-3">Karyawan</th>
                    <th class="px-4 py-3">Gaji Pokok</th>
                    <th class="px-4 py-3">Tunjangan</th>
                    <th class="px-4 py-3">Potongan</th>
                    <th class="px-4 py-3">Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $pay)
                <tr>
                    <td class="px-4 py-3 fw-semibold">{{ $pay->period_month }}/{{ $pay->period_year }}</td>
                    <td class="px-4 py-3 fw-semibold text-dark">{{ $pay->employee->user->name }}</td>
                    <td class="px-4 py-3">Rp {{ number_format((float)$pay->basic_salary_encrypted, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-success">+ Rp {{ number_format((float)$pay->allowances_encrypted, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-danger">- Rp {{ number_format((float)$pay->deductions_encrypted, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 fw-bold text-primary">Rp {{ number_format((float)$pay->net_salary_encrypted, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-4 text-center text-muted">Belum ada data penggajian.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
