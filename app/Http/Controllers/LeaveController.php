<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Leave::with(['employee.user', 'approver'])->latest();

        if (!$user->isAdminOrHrd() && $user->role !== 'manager') {
            $query->where('employee_id', $user->employee?->id);
        }

        $leaves = $query->paginate(15);
        return view('leaves.index', compact('leaves'));
    }

    public function store(Request $request)
    {
        $employee = Auth::user()->employee;
        abort_unless($employee !== null, 403);

        $validated = $request->validate([
            'leave_type' => ['required', 'in:cuti_tahunan,cuti_sakit,cuti_melahirkan,izin_khusus'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $days = Carbon::parse($validated['start_date'])->diffInDays(Carbon::parse($validated['end_date'])) + 1;

        if ($validated['leave_type'] === 'cuti_tahunan' && $employee->leave_quota < $days) {
            return back()->withErrors(['leave' => "Sisa kuota cuti tahunan tidak mencukupi (Sisa: {$employee->leave_quota} hari)."]);
        }

        Leave::create([
            'employee_id' => $employee->id,
            'leave_type' => $validated['leave_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $days,
            'reason' => $validated['reason'],
        ]);

        ActivityLog::record('REQUEST_LEAVE', "Mengajukan {$validated['leave_type']} selama {$days} hari.");
        return back()->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        abort_unless(Auth::user()->isAdminOrHrd() || Auth::user()->role === 'manager', 403);
        $request->validate(['status' => ['required', 'in:approved,rejected']]);

        DB::transaction(function () use ($request, $leave) {
            $leave->update([
                'status' => $request->status,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            if ($request->status === 'approved' && $leave->leave_type === 'cuti_tahunan') {
                $leave->employee->decrement('leave_quota', $leave->total_days);
            }

            ActivityLog::record('UPDATE_LEAVE', "Mengubah status cuti ID #{$leave->id} menjadi {$request->status}");
        });

        return back()->with('success', 'Status pengajuan cuti diperbarui.');
    }
}
