<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->isAdminOrHrd(), 403);
        $employees = Employee::with(['user', 'department', 'position'])->latest()->paginate(15);
        $departments = Department::all();
        $positions = Position::all();

        return view('employees.index', compact('employees', 'departments', 'positions'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $docPath = null;
            if ($request->hasFile('document')) {
                $docPath = $request->file('document')->store('employee_documents', 'local');
            }

            Employee::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'nip' => $request->nip,
                'nik_encrypted' => $request->nik,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'join_date' => $request->join_date,
                'employment_status' => $request->employment_status,
                'bank_account_encrypted' => $request->bank_account,
                'document_path' => $docPath,
            ]);

            ActivityLog::record('CREATE_EMPLOYEE', "Menambahkan karyawan baru: {$request->name} ({$request->nip})");
        });

        return back()->with('success', 'Data karyawan berhasil ditambahkan dan dienkripsi.');
    }

    public function downloadDocument(Employee $employee)
    {
        abort_unless(Auth::user()->isAdminOrHrd() || Auth::id() === $employee->user_id, 403);
        abort_unless($employee->document_path && Storage::disk('local')->exists($employee->document_path), 404);

        return Storage::disk('local')->download($employee->document_path);
    }

    public function destroy(Employee $employee)
    {
        abort_unless(Auth::user()->isAdminOrHrd(), 403);
        $name = $employee->user->name;
        if ($employee->document_path) {
            Storage::disk('local')->delete($employee->document_path);
        }
        $employee->user->delete();
        ActivityLog::record('DELETE_EMPLOYEE', "Menghapus data karyawan: {$name}");

        return back()->with('success', 'Data karyawan berhasil dihapus.');
    }
}
