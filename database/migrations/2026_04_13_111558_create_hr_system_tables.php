<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Core Employees
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            // $table->string('email')->unique();
            // $table->string('password');
            
            // Merged: Using string instead of enum to match your Seeder's "Full-time" value easily
            $table->string('employment_type')->nullable(); 
            $table->string('job_title')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('status')->default('Active');
            
            // Additional Info
            $table->string('gender')->nullable(); 
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_admin')->default(false); 

            $table->timestamps(); // Only one instance of timestamps is needed
        });

        // Family & Next of Kin
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

        // Finance & Payroll Details
        Schema::create('employee_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('employee_finances');
        Schema::dropIfExists('employee_family');
        Schema::dropIfExists('employees');
    }
};