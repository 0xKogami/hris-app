<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $it = Department::create(['code' => 'IT', 'name' => 'Information Technology', 'description' => 'Divisi Pengembangan & Infrastruktur']);
        $hr = Department::create(['code' => 'HRD', 'name' => 'Human Resources', 'description' => 'Divisi Sumber Daya Manusia']);
        $fin = Department::create(['code' => 'FIN', 'name' => 'Finance & Accounting', 'description' => 'Divisi Keuangan']);

        Position::create(['department_id' => $it->id, 'title' => 'System Developer', 'base_salary' => 8500000]);
        Position::create(['department_id' => $hr->id, 'title' => 'HR Manager', 'base_salary' => 10000000]);
        Position::create(['department_id' => $fin->id, 'title' => 'Finance Staff', 'base_salary' => 6500000]);
    }
}
