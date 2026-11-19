<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();

        $totalEmployees = Employee::count();
        $presentToday = Attendance::whereDate('date', $today)->whereIn('status', ['hadir', 'terlambat'])->count();
        $onLeaveToday = Leave::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();
        $pendingLeaves = Leave::where('status', 'pending')->count();

        $recentAttendances = Attendance::with(['employee.user', 'employee.department'])
            ->whereDate('date', $today)
            ->latest('clock_in')
            ->take(10)
            ->get();

        $myAttendance = $user->employee
            ? Attendance::where('employee_id', $user->employee->id)->whereDate('date', $today)->first()
            : null;

        return view('dashboard.index', compact(
            'totalEmployees',
            'presentToday',
            'onLeaveToday',
            'pendingLeaves',
            'recentAttendances',
            'myAttendance'
        ));
    }
}
