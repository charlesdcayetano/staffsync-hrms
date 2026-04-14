<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'employee_code' => 'EMP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01'),
            'employment_type' => $this->faker->randomElement(['Full-time', 'Remote', 'Contract']),
            'job_title' => $this->faker->jobTitle(),
            'joining_date' => $this->faker->date(),
            'status' => 'Active',
        ];
    }
}