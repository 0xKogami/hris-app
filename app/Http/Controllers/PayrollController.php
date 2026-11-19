<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Payroll::with(['employee.user', 'employee.position'])->latest('period_year')->latest('period_month');

        if (!$user->isAdminOrHrd()) {
            $query->where('employee_id', $user->employee?->id);
        }

        $payrolls = $query->paginate(15);
        $employees = $user->isAdminOrHrd() ? Employee::with(['user', 'position'])->get() : collect();

        return view('payrolls.index', compact('payrolls', 'employees'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->isAdminOrHrd(), 403);

        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'period_month' => ['required', 'integer', 'between:1,12'],
            'period_year' => ['required', 'integer', 'min:2020'],
            'allowances' => ['nullable', 'numeric', 'min:0'],
            'deductions' => ['nullable', 'numeric', 'min:0'],
        ]);

        $employee = Employee::with('position')->findOrFail($validated['employee_id']);
        $basic = (float) $employee->position->base_salary;
        $allowances = (float) ($validated['allowances'] ?? 0);
        $deductions = (float) ($validated['deductions'] ?? 0);
        $net = ($basic + $allowances) - $deductions;

        Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'period_month' => $validated['period_month'],
                'period_year' => $validated['period_year'],
            ],
            [
                'basic_salary_encrypted' => (string) $basic,
                'allowances_encrypted' => (string) $allowances,
                'deductions_encrypted' => (string) $deductions,
                'net_salary_encrypted' => (string) $net,
                'status' => 'paid',
                'paid_at' => now(),
            ]
        );

        ActivityLog::record('GENERATE_PAYROLL', "Menerbitkan slip gaji terenkripsi untuk {$employee->user->name} ({$validated['period_month']}/{$validated['period_year']})");
        return back()->with('success', 'Slip gaji berhasil diterbitkan dan dienkripsi.');
    }
}
