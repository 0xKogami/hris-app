<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->employee !== null;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:clock_in,clock_out'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
