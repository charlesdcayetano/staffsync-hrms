<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Employee Profile First
        $employee = Employee::create([
            'employee_code'   => 'EMP-2026-001',
            'first_name'    => 'Charles',
            'middle_name'   => 'L.',
            'last_name'     => 'Cayetano',
            'email'         => 'charles@staffsync.com',
            'phone_number'  => '09123456789',
            'date_of_birth' => '1998-05-15',
            'address'       => 'Poblacion, Panitan, Capiz',
            'department'    => 'Information Technology',
            'designation'   => 'System Architect',
            'status'        => 'Active',
        ]);

        // 2. Create the Login Account linked to that Employee
        User::create([
            'name'          => 'Charles Cayetano',
            'email'         => 'charles@staffsync.com',
            'password'      => Hash::make('password123'),
            'employee_id'   => $employee->id, // Foreign Key linking to employee table
            'is_admin'      => false,         // Set to false for Employee Portal access
        ]);

        // 3. Seed Related Modules (Academic, Financial, etc.)
        $employee->financialDetails()->create([
            'bank_name'      => 'Landbank of the Philippines',
            'account_number' => '1234-5678-90',
            'basic_salary'   => 45000,
        ]);

        $employee->familyMembers()->createMany([
            ['name' => 'Maria Cayetano', 'relationship' => 'Mother', 'contact_number' => '09998887771'],
            ['name' => 'John Cayetano', 'relationship' => 'Father', 'contact_number' => '09998887772'],
        ]);

        $employee->nextOfKin()->create([
            'name'  => 'Maria Cayetano',
            'relation' => 'Mother',
            'phone' => '09998887771',
        ]);

        $employee->educationQualifications()->createMany([
            [
                'qualification_name' => 'BS in Information Technology',
                'institution' => 'Capiz State University',
                'year_attained' => '2020'
            ],
        ]);
        
        $employee->guarantors()->create([
            'name' => 'Dr. Jane Smith',
            'relationship' => 'Professional Mentor',
            'phone' => '09170001112',
            'employer' => 'Pacific Tech Solutions',
        ]);
    }
}