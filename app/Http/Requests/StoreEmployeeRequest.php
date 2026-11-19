<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdminOrHrd();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:super_admin,hrd,manager,employee'],
            'nip' => ['required', 'string', 'max:50', 'unique:employees,nip'],
            'nik' => ['required', 'digits:16'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'in:L,P'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'join_date' => ['required', 'date'],
            'employment_status' => ['required', 'in:tetap,kontrak,magang'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }
}
