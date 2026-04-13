<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Core Employees
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('employment_type', ['Full-time', 'Remote', 'Shifting', 'Contract']);
            $table->date('joining_date');
            $table->enum('status', ['Active', 'On Leave', 'Terminated'])->default('Active');
            $table->timestamps();
        });

        // Family & Next of Kin (Covers your 'Next of Kin' and 'Family' tabs)
        Schema::create('employee_family', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('relationship');
            $table->string('phone_number');
            $table->text('address')->nullable();
            $table->boolean('is_next_of_kin')->default(false);
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
        });
    }
};