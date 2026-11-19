<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'basic_salary_encrypted' => 'encrypted',
            'allowances_encrypted' => 'encrypted',
            'deductions_encrypted' => 'encrypted',
            'net_salary_encrypted' => 'encrypted',
            'paid_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
