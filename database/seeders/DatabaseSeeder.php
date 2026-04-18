<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Admin Account (Your Access)
        $adminUser = User::create([
            'name' => 'Charles Admin',
            'email' => 'adminn@hrms.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $this->call([
        EmployeeSeeder::class,
    ]);

        // Create the Admin's Employee Profile
        Employee::create([
            'user_id' => $adminUser->id,
            'employee_code' => 'ADM-001',
            'first_name' => 'Charles',
            'last_name' => 'Cayetano',
            'gender' => 'Male',
            'date_of_birth' => '2000-09-20',
            'employment_type' => 'Full-time',
            'job_title' => 'System Administrator',
            'joining_date' => now(),
            'status' => 'Active',
            'is_admin' => true,
            'email' => 'admin@hrms.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create 10 Dummy Employees with Relations
        Employee::factory(10)->create()->each(function ($employee) {
            // Seed Financial Data
            $employee->finance()->create([
                'bank_name' => 'BDO Unibank',
                'account_number' => fake()->bankAccountNumber(),
                'account_name' => $employee->first_name . ' ' . $employee->last_name,
            ]);

            // Seed Education Data
            $employee->education()->create([
                'institution_name' => 'Filamer Christian University',
                'course_study' => 'BS in Information Technology',
                'qualification_type' => 'Bachelor',
                'start_date' => '2021-06-01',
                'end_date' => '2025-07-02',
            ]);
        });
    }
}