<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $query = Attendance::with(['employee.user', 'employee.department'])->latest('date')->latest('id');

        if (!auth()->user()->isAdminOrHrd() && auth()->user()->role !== 'manager') {
            $employeeId = auth()->user()->employee?->id;
            $query->where('employee_id', $employeeId);
        }

        $attendances = $query->paginate(15);

        return view('attendances.index', compact('attendances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:clock_in,clock_out',
        ]);

        $employee = auth()->user()->employee;
        if (!$employee) {
            return back()->withErrors(['attendance' => 'Akun tidak terhubung dengan data karyawan.']);
        }

        $now = Carbon::now();
        $today = $now->toDateString();
        $scheduledStart = Carbon::createFromFormat('Y-m-d H:i:s', "{$today} 07:00:00", $now->getTimezone());

        $attendance = Attendance::firstOrNew([
            'employee_id' => $employee->id,
            'date' => $today,
        ]);

        if ($request->type === 'clock_in') {
            if ($attendance->clock_in) {
                return back()->withErrors(['attendance' => 'Anda sudah melakukan Clock-In hari ini.']);
            }

            $isLate = $now->gt($scheduledStart);
            $lateMinutes = $isLate ? $scheduledStart->diffInMinutes($now) : 0;

            $attendance->clock_in = $now->format('H:i:s');
            $attendance->is_late = $isLate;
            $attendance->late_minutes = $lateMinutes;
            $attendance->status = $isLate ? 'terlambat' : 'hadir';
            $attendance->ip_address = $request->ip();
            $attendance->save();

            $message = $isLate
                ? "Clock-In tercatat ({$attendance->clock_in}). Anda terlambat {$attendance->late_duration_label}."
                : "Clock-In tepat waktu tercatat ({$attendance->clock_in}).";

            return back()->with('success', $message);
        }

        if (!$attendance->clock_in) {
            return back()->withErrors(['attendance' => 'Lakukan Clock-In terlebih dahulu sebelum Clock-Out.']);
        }

        if ($attendance->clock_out) {
            return back()->withErrors(['attendance' => 'Anda sudah melakukan Clock-Out hari ini.']);
        }

        $attendance->clock_out = $now->format('H:i:s');
        $attendance->ip_address = $request->ip();
        $attendance->save();

        return back()->with('success', "Clock-Out tercatat ({$attendance->clock_out}).");
    }
}
