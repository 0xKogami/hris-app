<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function index()
    {
        $query = Overtime::with(['employee.user', 'employee.department', 'approver'])
            ->latest('date')
            ->latest('id');

        if (!auth()->user()->isAdminOrHrd() && auth()->user()->role !== 'manager') {
            $employeeId = auth()->user()->employee?->id;
            $query->where('employee_id', $employeeId);
        }

        $overtimes = $query->paginate(15);

        return view('overtimes.index', compact('overtimes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string|max:255',
        ]);

        $employee = auth()->user()->employee;
        if (!$employee) {
            return back()->withErrors(['overtime' => 'Akun tidak terhubung dengan data karyawan.']);
        }

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end = Carbon::createFromFormat('H:i', $request->end_time);
        $durationMinutes = $start->diffInMinutes($end);

        if ($durationMinutes <= 0) {
            return back()->withErrors(['overtime' => 'Jam selesai lembur harus lebih besar dari jam mulai.']);
        }

        Overtime::create([
            'employee_id' => $employee->id,
            'date' => $request->date,
            'start_time' => $request->start_time . ':00',
            'end_time' => $request->end_time . ':00',
            'duration_minutes' => $durationMinutes,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan lembur berhasil dikirim dan menunggu persetujuan.');
    }

    public function updateStatus(Request $request, Overtime $overtime)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        if (!auth()->user()->isAdminOrHrd() && auth()->user()->role !== 'manager') {
            abort(403);
        }

        $overtime->update([
            'status' => $request->status,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Status pengajuan lembur berhasil diperbarui.');
    }
}
