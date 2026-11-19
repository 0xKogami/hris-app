<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run(): void
    {
        $itDept = Department::where('code', 'IT')->first() ?? Department::first();
        $hrDept = Department::where('code', 'HRD')->first() ?? Department::first();
        $finDept = Department::where('code', 'FIN')->first() ?? Department::first();

        $devPos = Position::where('department_id', $itDept->id)->first() ?? Position::first();
        $hrPos = Position::where('department_id', $hrDept->id)->first() ?? Position::first();
        $finPos = Position::where('department_id', $finDept->id)->first() ?? Position::first();

        $accounts = [
            [
                'name' => 'Super Administrator',
                'email' => 'admin@perusahaan.local',
                'password' => 'Admin123!',
                'role' => 'super_admin',
                'nip' => 'EMP-2026001',
                'nik' => '3201010101900001',
                'phone' => '081200000001',
                'gender' => 'L',
                'birth_date' => '1990-01-10',
                'department_id' => $itDept->id,
                'position_id' => $devPos->id,
                'bank_account' => 'BCA - 1110001111',
            ],
            [
                'name' => 'Rina Kartika (HRD)',
                'email' => 'hrd@perusahaan.local',
                'password' => 'Hrd12345!',
                'role' => 'hrd',
                'nip' => 'EMP-2026002',
                'nik' => '3201010101930002',
                'phone' => '081200000002',
                'gender' => 'P',
                'birth_date' => '1993-05-15',
                'department_id' => $hrDept->id,
                'position_id' => $hrPos->id,
                'bank_account' => 'Mandiri - 2220002222',
            ],
            [
                'name' => 'Dimas Pratama (Manager)',
                'email' => 'manager@perusahaan.local',
                'password' => 'Manager123!',
                'role' => 'manager',
                'nip' => 'EMP-2026003',
                'nik' => '3201010101910003',
                'phone' => '081200000003',
                'gender' => 'L',
                'birth_date' => '1991-08-20',
                'department_id' => $itDept->id,
                'position_id' => $devPos->id,
                'bank_account' => 'BNI - 3330003333',
            ],
            [
                'name' => 'Andi Saputra (Karyawan)',
                'email' => 'karyawan@perusahaan.local',
                'password' => 'Karyawan123!',
                'role' => 'employee',
                'nip' => 'EMP-2026004',
                'nik' => '3201010101980004',
                'phone' => '081200000004',
                'gender' => 'L',
                'birth_date' => '1998-11-25',
                'department_id' => $finDept->id,
                'position_id' => $finPos->id,
                'bank_account' => 'BRI - 4440004444',
            ],
        ];

        foreach ($accounts as $acc) {
            $user = User::updateOrCreate(
                ['email' => $acc['email']],
                [
                    'name' => $acc['name'],
                    'password' => Hash::make($acc['password']),
                    'role' => $acc['role'],
                    'is_active' => true,
                ]
            );

            Employee::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'department_id' => $acc['department_id'],
                    'position_id' => $acc['position_id'],
                    'nip' => $acc['nip'],
                    'nik_encrypted' => $acc['nik'],
                    'phone' => $acc['phone'],
                    'gender' => $acc['gender'],
                    'birth_date' => $acc['birth_date'],
                    'address' => 'Jl. Jend. Sudirman Kav. 10, Jakarta',
                    'join_date' => '2026-01-01',
                    'employment_status' => 'tetap',
                    'leave_quota' => 12,
                    'bank_account_encrypted' => $acc['bank_account'],
                ]
            );
        }
    }
}
