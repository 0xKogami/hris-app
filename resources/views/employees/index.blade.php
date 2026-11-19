@extends('layouts.app')
@section('title', 'Data Karyawan - HRIS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Manajemen Karyawan</h4>
        <p class="text-muted small mb-0">Kelola profil karyawan dan dokumen terenkripsi.</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        <i class="bx bx-plus"></i> Tambah Karyawan
    </button>
</div>

<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light text-uppercase">
                <tr>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Nama &amp; Email</th>
                    <th class="px-4 py-3">Departemen / Jabatan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td class="px-4 py-3 font-monospace">{{ $emp->nip }}</td>
                    <td class="px-4 py-3">
                        <div class="fw-semibold text-dark">{{ $emp->user->name }}</div>
                        <div class="text-muted">{{ $emp->user->email }}</div>
                    </td>
                    <td class="px-4 py-3">{{ $emp->department->name }} - {{ $emp->position->title }}</td>
                    <td class="px-4 py-3"><span class="badge bg-label-primary text-uppercase">{{ $emp->employment_status }}</span></td>
                    <td class="px-4 py-3">
                        <div class="d-flex gap-2">
                            @if($emp->document_path)
                                <a href="{{ route('employees.document', $emp) }}" class="btn btn-sm btn-outline-primary py-0 px-2">Dokumen</a>
                            @endif
                            <form action="{{ route('employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('Hapus karyawan ini?')" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-muted">Belum ada data karyawan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div>{{ $employees->links() }}</div>

<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body small">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Lengkap</label><input type="text" name="name" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input type="email" name="email" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Password Awal</label><input type="password" name="password" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select"><option value="employee">Employee</option><option value="manager">Manager</option><option value="hrd">HRD</option></select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-semibold">NIP</label><input type="text" name="nip" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">NIK (16 Digit - Terenkripsi)</label><input type="text" name="nik" maxlength="16" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">No. Telepon</label><input type="text" name="phone" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="gender" class="form-select"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" name="birth_date" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Bergabung</label><input type="date" name="join_date" required class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Departemen</label>
                            <select name="department_id" class="form-select">@foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Jabatan</label>
                            <select name="position_id" class="form-select">@foreach($positions as $p)<option value="{{ $p->id }}">{{ $p->title }}</option>@endforeach</select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-semibold">Status Kerja</label>
                            <select name="employment_status" class="form-select"><option value="kontrak">Kontrak</option><option value="tetap">Tetap</option><option value="magang">Magang</option></select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-semibold">No. Rekening (Terenkripsi)</label><input type="text" name="bank_account" class="form-control"></div>
                        <div class="col-12"><label class="form-label fw-semibold">Alamat</label><textarea name="address" rows="2" required class="form-control"></textarea></div>
                        <div class="col-12"><label class="form-label fw-semibold">Dokumen Kontrak/KTP (PDF/JPG)</label><input type="file" name="document" class="form-control"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
